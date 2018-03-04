<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
      if(config('database.default') == 'sqlite'){
          $db = app()->make('db');
          $db->connection()->getPdo()->exec("pragma foreign_keys=1");
      }
      
      Validator::extend('current_user_is_admin', function ($attribute, $value, $parameters, $validator) {
        return Auth::user()->role == 2;
      });
      
      Validator::extend('greater_than_field', function($attribute, $value, $parameters, $validator) {
        $min_field = $parameters[0];
        $data = $validator->getData();
        $min_value = $data[$min_field];
        return $value > $min_value;
      }); 
      
      Validator::extend('email_list', function($attribute, $value, $parameters, $validator) {
        $email_list = $value;
        $explodedEmails = explode(",", $email_list);

        foreach ($explodedEmails as $email)
        {
            $validator = Validator::make(
                array('individualEmail' => $email),
                array('individualEmail' => 'email') 
            );

            if ($validator->fails())
            {
                return false;
            }

        };

        return true;
      });

      Validator::replacer('greater_than_field', function($message, $attribute, $rule, $parameters) {
        return str_replace(':field', $parameters[0], $message);
      });
    }
        //
    

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
