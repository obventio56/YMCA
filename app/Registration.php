<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Registration extends Model
{
    use SoftDeletes;

    public function user() {
      return $this->belongsTo('App\User'); 
    }
  
    public function event() {
      return $this->belongsTo('App\Event'); 
    }
}
