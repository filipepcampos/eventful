<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
  // Don't add create and update timestamps in database.
  public $timestamps  = false;
  protected $table = 'event';

  /**
   * Host of this event
   */
  public function host() {
    return $this->belongsTo('App\Models\User');
  }

  /*
   * Event tags
   */
  public function tags(){
    return $this->belongsToMany('App\Models\Tag');
  }

  /*
   * Event reports
   */
  public function reports(){
    return $this->hasMany('App\Models\EventReport');
  }

  /*
   * Event attendees
   */
  public function attendees() {
    return $this->hasMany('App\Models\Attendee');
  }

  /**
   * Event comments
   */
  public function comments() {
    return $this->hasMany('App\Models\Comment');
  }

  /**
   * Event posts
   */
  public function posts(){
    return $this->hasMany('App\Models\Post');
  }

  /**
   * Join requests
   */
  public function requests() {
    return $this->hasMany('App\Models\Request');
  }
}
