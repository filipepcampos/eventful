<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
  // Don't add create and update timestamps in database.
  public $timestamps  = false;
  protected $table = 'post';

  /**
   * The event this post belongs to
   */
  public function events() {
    return $this->hasMany('App\Models\Event');
  }
}
