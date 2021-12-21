<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
  // Don't add create and update timestamps in database.
  public $timestamps  = false;
  protected $table = 'comment';

  /**
   * Comment author
   */
  public function author() {
    return $this->belongsTo('App\Models\User');
  }

  /**
   * Comment ratings
   */
  public function ratings(){
    return $this->hasMany('App\Models\Rating');
  }

  /**
   * Attached files
   */
  public function files(){
    return $this->hasMany('App\Models\File');
  }

  /**
   * Reports received
   */
  public function reports(){
    return $this->hasMany('App\Models\CommentReport');
  }
}
