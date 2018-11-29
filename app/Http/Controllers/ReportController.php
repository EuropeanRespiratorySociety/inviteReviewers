<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\User;

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

        $allowed = false;

        if($user->ers_id == 203041
            || $user->ers_id == 308224
            || $user->ers_id == 408341) {
            $allowed = true;
        }

        if(!$allowed){
            abort(404);
        }



            $users = DB::table('users')
                ->join('reviewers', 'users.id', '=', 'reviewers.user_id')
                ->join('invitation_permissions', 'users.ers_id', '=', 'invitation_permissions.ers_id')
                ->select('users.name', 'users.ers_id as chair_ers_id', 'users.email', 'invitation_permissions.quantity', 'reviewers.ers_id', 'reviewers.title', 'reviewers.first_name', 'reviewers.last_name', 'reviewers.email')
                ->get();

            foreach($users as $key => $user){
                $results[$user->name]['quantity']= $user->quantity;
                $results[$user->name]['ers_id']= $user->chair_ers_id;
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
    * Login as someone else
    */
    public function impersonate($id)
    {
        $user = Auth::user();
        $allowed = false;

        if($user->ers_id == 203041 || $user->ers_id == 308224){
            $allowed = true;
        }

        if(!$allowed){
            return "not allowed";
        }

        $reviewer = User::where('ers_id', $id)->first();
        $impersonated = Auth::loginUsingId($reviewer->id);
        return redirect('/');
    }
}
