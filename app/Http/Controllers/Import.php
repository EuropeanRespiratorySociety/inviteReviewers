<?php

namespace App\Http\Controllers;

use App\ErsContact;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\InvitationPermission;
use Illuminate\Support\Facades\DB;
use App\Extensions\PermissionImport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class Import extends Controller
{
    //CSV settings
    protected $delimiter  = ',';
    protected $enclosure  = '"';
    protected $lineEnding = '\r\n';

    public function __construct()
    {
        set_time_limit(0);
        $this->middleware('auth');
    }
    /**
     * Import the ERS Permision to invite.
     *
     * 
     */
    public function importPermissions()
    {

        Excel::load('files/permissions.xlsx', function($reader) {

            // Getting all results
            $results = $reader->get();
            foreach($results as $row){
                    $permissions = [
                    'ers_id'    => $row->ers_id,
                    'quantity'  => $row->quantity
                    ];

                    InvitationPermission::create($permissions);   

                }
            });


        
    }

    /**
     * Import the All Contact list.
     *
     * 
     */
    public function importAll()

    //not working use JSON meanwhile.
    {
        
        
        Excel::filter('chunk')->load('files/AllContacts.xlsx')->chunk(50, function($results) {

            // Getting all results

        //Excel::load('files/AllContacts.xlsx', function($reader) {
        
        //$results = $reader->get(); 
            
            foreach($results as $row){
                
                $permissions = [
                    'ers_id'=> $row->partner, 
                    'title'=> $row->title,
                    'last_name'=> $row->last_name,
                    'first_name'=> $row->first_name, 
                    'city'=> $row->city1, 
                    'country'=> $row->country1, 
                    'email'=> $row->smtp_addr
                ];
                
            ErsContact::create($permissions);

            }
           return "upload finished" ;
        });
    }
}


    

