<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role', 'active_user',
    ];

  
     protected $dispatchesEvents = [
        'saving' => UserSaving::class
     ];
  
     protected $dates = ['deleted_at'];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
  
    public function role_radio_button_status() {
      $initial_values = Array(
        0=>'',
        1=>'',
        2=>''
      );
      $initial_values[$this->role] = 'checked';
      return $initial_values;
    }
}
