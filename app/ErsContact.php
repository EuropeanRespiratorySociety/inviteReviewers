<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Extensions\SearchableTrait;

class ErsContact extends Model
{
    use SearchableTrait;
    
    protected $searchable = [
        'columns' => [
            'first_name' => 10,
            'last_name' => 10,
            'email' => 10,
            'country' => 10,
            'city' => 10,
        ],
    ];


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'all_ers_contacts';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
                    'ers_id', 
                    'title',
                    'last_name',
                    'first_name', 
                    'city', 
                    'country', 
                    'email'];
}
