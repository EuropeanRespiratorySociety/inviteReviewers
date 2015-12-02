<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Extensions\SearchableTrait;

class ErsContact extends Model
{
    use SearchableTrait;
    
    protected $searchable = [
        'columns' => [
            'first_name' => 8,
            'last_name' => 10,
            'email' => 5,
            'country' => 3,
            'city' => 3,
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
