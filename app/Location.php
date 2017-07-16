<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
  
    protected $fillable = ['title', 'description', 'manager_email'];
  
    public function user()
    {
        return $this->belongsTo('App\User');
    }
  
}
