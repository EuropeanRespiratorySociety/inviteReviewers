<?php

namespace App\Http\Controllers;

use App\ErsContact;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ConnectException;

use App\Extensions\TokenStorage as TokenFile;


class ApiController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->username = env('ERS_API_USER');
        $this->password = env('ERS_API_PW');
        $this-> client = new Client();
        $this->tokenStoragePath = '../storage';
        $this->token = $this->setToken(); 

    }

    private function auth($username, $password) {
        $response = $this->client->post('https://api.ersnet.org/authentication', [
            'headers' => [
                'Content-Type' => 'application/json'
            ],
            'body' => json_encode([
                'email' => $username,
                'password' => $password,
                'strategy' => 'local'
            ])
        ]);

        return json_decode($response->getBody(), true);
    }

    private function setToken(){
        $now = new \DateTime('now', new \DateTimeZone('UTC'));
        $file = new TokenFile('token', $this->tokenStoragePath);
      
        if($file->read('token') === null){	
            $token = $this->auth($this->username, $this->password);
            $token['expires'] = $now->add(new \DateInterval('PT23H'))->getTimestamp();
            $file->write($token);
            return $token['accessToken'];
            // return $this->auth($this->username, $this->password);	
        }

        if($now->getTimestamp() >= $file->read('expires')){
            $token = $this->auth($this->username, $this->password);
            $token['expires'] = $now->add(new \DateInterval('PT23H'))->getTimestamp();
            $file->write($token);
            return $token['accessToken'];
        }

        if($now->getTimestamp() < $file->read('expires')){
            return $file->read('token');
        }
}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reviewers = DB::table('reviewers')->where('user_id', '=', Auth::user()->id)->get();
        $selfAsReviewer = DB::table('reviewers')->where('user_id', '=', Auth::user()->ers_id)->get();
        $totalReviewers = count($reviewers);
        if($selfAsReviewer){
            ++$totalReviewers;
        }
        
        $quantity = DB::table('invitation_permissions')->where('ers_id', '=', Auth::user()->ers_id)->get();

        return Response::json([
                'self'      => $selfAsReviewer,
                'reviewers' => $reviewers,
                'quantity'  => $quantity['0']->quantity - $totalReviewers
            ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //check that the sent reviwer is not already invited
        $reviewer = DB::table('reviewers')->where('ers_id', '=', $request->ers_id)->get();


        
        $newReviewer = Auth::user()->reviewers()->create($request->all());
        
        if(!$newReviewer){
           return Response::json([ 
                'message'   => "Ooops, something went wrong"
            ], 422);  
        }

        return Response::json([
                'reviewer'  => $newReviewer->toArray(),
                'message'   => "The reviewer has been added to the list"
            ], 200);
    }

    /**
     * Search.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function search($query)
    {
        $res = $this->client->request('GET', 'https://api.ersnet.org/ers/contacts?pattern='.$query, [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer '.$this->token
            ]    
        ]);

        $res = json_decode($res->getBody(), true);

        $search = [];
        if(!$res){
            return $res;
        }

        foreach ($res['data'] as $result) {
            $search[] = [
                'title' => isset($result['Title']) ? $result['Title'] : '',
                'last_name' => isset($result['LastName']) ? $result['LastName'] : '',
                'first_name'=> isset($result['FirstName']) ? $result['FirstName'] : '',
                'email'=> isset($result['SmtpAddress1']) ? $result['SmtpAddress1'] : '',
                'city' => isset($result['MainCity']) ? $result['MainCity'] : '',
                'country'=> isset($result['MainCountryCode']) ? $result['MainCountryCode'] : '',
                'ers_id'=>  isset($result['ContactId']) ? $result['ContactId'] : '',
            ];
        }

        return $search;

    }

    public function contact($query) {
        $res = $this->client->request('GET', 'https://api.ersnet.org/ers/contacts/'.$query, [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer '.$this->token
            ]    
        ]);

        $res = json_decode($res->getBody(), true);
        $contact = $res['data'];
        $search = [
            'title' => isset($contact['Title']) ? $contact['Title'] : '',
            'last_name' => isset($contact['LastName']) ? $contact['LastName'] : '',
            'first_name'=> isset($contact['FirstName']) ? $contact['FirstName'] : '',
            'email'=> isset($contact['SmtpAddress1']) ? $contact['SmtpAddress1'] : '',
            'city' => isset($contact['MainCity']) ? $contact['MainCity'] : '',
            'country'=> isset($contact['MainCountryCode']) ? $contact['MainCountryCode'] : '',
            'ers_id'=> isset($contact['ContactId']) ? $contact['ContactId']: '',
        ];
        return $search;
    }

    /**
     * Search 2 for test purposes.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function search2($query)
    {
        $search = DB::table('all_ers_contacts')->where('last_name', '=', $query)->get();

        return $search;

    }

    /**
     * Search All.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function searchAll()
    {
         $results = ErsContact::search('%')->get();

         $search = array();

         if(!$results){
            return $search;
         }

         foreach ($results as $result) {

             $search[] = [
                    'title' => $result->title,
                    'last_name' => $result->last_name,
                    'first_name'=> $result->first_name,
                    'email'=> $result->email,
                    'city'=> $result->city,
                    'country'=> $result->country,
                    'ers_id'=> $result->ers_id,
             ];
         }

         return $search;

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
