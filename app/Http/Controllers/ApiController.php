<?php

namespace App\Http\Controllers;

use App\ErsContact;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class ApiController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
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
         $results = ErsContact::search($query)->get();

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
     * Search All.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function searchAll()
    {
         $results = ErsContact::search('*')->get();

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
