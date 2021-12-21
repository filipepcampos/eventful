<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
  // Don't add create and update timestamps in database.
  public $timestamps  = false;
  protected $table = 'report';

  public function author(){
    return $this->belongsTo('App\Models\User');
  }
}
