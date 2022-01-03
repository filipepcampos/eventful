<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    protected $table="users";

    protected $dates = [
        'account_creation_date',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password', 'name', 'birthdate', 'description'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Events the user is attending
     */
    public function attending() {
      return $this->belongsToMany('App\Models\Event', 'attendee');
    }

    public function invites() {
        return $this->hasMany('App\Models\Invite', 'invitee_id');
    }
}
