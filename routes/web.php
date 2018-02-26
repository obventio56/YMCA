<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth']], function() {
  
  Route::get('/racquetball-schedule', function ($name = null) {
      return redirect()->route('show-reservation-slot-group', [env('RACQUETBALL_GROUP', 2)]);
  });

  Route::get('/reserve-courts', function ($name = null) {
      return redirect()->route('check-date-for-reservation-slot-group', [env('RACQUETBALL_GROUP', 2)]);;
  });
  
  //User routes
  Route::get('/users/{role?}', 'UserController@index')->name('users-index');
  Route::get('/user/new', 'UserController@new')->name('new-user');
  Route::post('/user/create', 'UserController@create')->name('create-user');
  Route::get('/user/edit/{user}', 'UserController@edit')->name('edit-user');
  Route::post('/user/update/{user}', 'UserController@update')->name('update-user');
  Route::get('/user/destroy/{user}', 'UserController@destroy')->name('destroy-user');

  //Location routes
  Route::get('/locations', 'LocationController@index')->name('locations-index');
  Route::get('/location/new', 'LocationController@new')->name('new-location');
  Route::post('/location/create', 'LocationController@create')->name('create-location');
  Route::get('/location/edit/{location}', 'LocationController@edit')->name('edit-location');
  Route::post('/location/update/{location}', 'LocationController@update')->name('update-location');
  Route::get('/location/destroy/{location}', 'LocationController@destroy')->name('destroy-location');

  //Reservation slot routes
  Route::get('/reservation-slots', 'ReservationSlotController@index')->name('reservation-slots-index');
  Route::get('/reservation-slot/new', 'ReservationSlotController@new')->name('new-reservation-slot');
  Route::post('/reservation-slot/create', 'ReservationSlotController@create')->name('create-reservation-slot');
  Route::get('/reservation-slot/edit/{reservation_slot}', 'ReservationSlotController@edit')->name('edit-reservation-slot');
  Route::post('/reservation-slot/update/{reservation_slot}', 'ReservationSlotController@update')->name('update-reservation-slot');
  Route::get('/reservation-slot/destroy/{reservation_slot}', 'ReservationSlotController@destroy')->name('destroy-reservation-slot');

  //Reservation slot group routes
  Route::get('/reservation-slot-groups', 'ReservationSlotGroupController@index')->name('reservation-slot-groups-index');
  Route::get('/reservation-slot-group/new', 'ReservationSlotGroupController@new')->name('new-reservation-slot-group');
  Route::post('/reservation-slot-group/create', 'ReservationSlotGroupController@create')->name('create-reservation-slot-group');
  Route::get('/reservation-slot-group/{group}', 'ReservationSlotGroupController@show')->name('show-reservation-slot-group');
  Route::post('/reservation-slot-group/{group}', 'ReservationSlotGroupController@show_with_date')->name('show-reservation-slot-with-date');
  Route::get('/reservation-slot-group/destroy/{group}', 'ReservationSlotGroupController@destroy')->name('destroy-reservation-slot-group');
  Route::get('/reservation-slot-group/check_date/{group}', 'ReservationSlotGroupController@check_date')->name('check-date-for-reservation-slot-group');
  Route::get('/reservation-slot-group/check_time/{group}','ReservationSlotGroupController@check_time')->name('check-time-for-reservation-slot-group'); 

  
  //Reservation routes
  Route::get('/reservation/check_date/{reservation_slot}', 'ReservationController@check_date')->name('check-date-for-reservation');
  //this is post because the date is passed by a form. 
  Route::post('/reservation/check_time/{reservation_slot}','ReservationController@check_time')->name('check-time-for-reservation'); 
  //this is get because the date could also be passed by not a form. 
  Route::get('/reservation/check_time/{reservation_slot}','ReservationController@check_time')->name('check-time-for-reservation'); 
  //This wouldn't be my choice, but i'm not going to re-do the markup
  Route::get('/reservation/new/{reservation_slot}/{desired_date_time}', 'ReservationController@new')->name('new-reservation');
  Route::get('/reservation/destroy/{reservation}', 'ReservationController@destroy')->name('destroy-reservation');
  Route::post('/reservation/create', 'ReservationController@create')->name('create-reservation');
  Route::get('/reservation/calendar', 'ReservationController@calendar')->name('calendar-of-reservations'); //i'm trying to keep labels very english
  
  //Event routes
  Route::get('/events', 'EventController@index')->name('events-index');
  Route::get('/events/name/{name}', 'EventController@name')->name('events-by-name');
  Route::get('/event/show/{event}', 'EventController@show')->name('show-event');
  Route::get('/event/new', 'EventController@new')->name('new-event');
  Route::post('/event/create', 'EventController@create')->name('create-event');
  Route::get('/event/edit/{event}', 'EventController@edit')->name('edit-event');
  Route::post('/event/update/{event}', 'EventController@update')->name('update-event');
  Route::get('/event/destroy/{event}', 'EventController@destroy')->name('destroy-event');

  Route::get('/registration/create/{event}', 'RegistrationController@create')->name('create-registration');
  Route::get('/registration/destroy/{registration}', 'RegistrationController@destroy')->name('destroy-registration');

});






