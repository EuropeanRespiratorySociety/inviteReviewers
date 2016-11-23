<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
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
        $user = Auth::user();

        if(!$user->ers_id == 203041 || !$user->ers_id == 308224){
            abort(404);
        }

            $users = DB::table('users')
                ->join('reviewers', 'users.id', '=', 'reviewers.user_id')
                ->join('invitation_permissions', 'users.ers_id', '=', 'invitation_permissions.ers_id')
                ->select('users.name', 'users.email', 'invitation_permissions.quantity', 'reviewers.ers_id', 'reviewers.title', 'reviewers.first_name', 'reviewers.last_name', 'reviewers.email')
                ->get();

            foreach($users as $key => $user){
                $results[$user->name]['quantity']= $user->quantity;
                $results[$user->name]['reviewers'][$key]['ers_id']= $user->ers_id;
                $results[$user->name]['reviewers'][$key]['title']= $user->title;
                $results[$user->name]['reviewers'][$key]['first_name']= $user->first_name;
                $results[$user->name]['reviewers'][$key]['last_name']= $user->last_name;
                $results[$user->name]['reviewers'][$key]['email']= $user->email;
                $results[$user->name]['total'] = count($results[$user->name]['reviewers']);

            }    
            return view('report', ['results' => $results]);

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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
