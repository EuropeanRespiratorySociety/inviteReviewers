<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reviewer extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'reviewers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
                    'user_id',  
                    'ers_id',  
                    'title',
                    'first_name',
                    'last_name',
                    'email', ];

    
    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
