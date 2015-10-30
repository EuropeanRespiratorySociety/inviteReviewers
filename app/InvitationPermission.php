<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvitationPermission extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'invitation_permissions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
                    'ers_id', 
                    'quantity'];

    public function user()
    {
        return $this->belongsTo('App\User', 'ers_id', 'ers_id');
    }
}
