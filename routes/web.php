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

Route::get('/', function () {
    return view('welcome');
})->name('landing');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//User routes
Route::get('/users/{role?}', 'UserController@index')->name('users-index');
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
Route::get('/reservation-slots', 'ReservationSlotsController@index')->name('reservation-slots-index');
Route::get('/reservation-slots/new', 'ReservationSlotsController@new')->name('new-reservation-slot');
Route::post('/reservation-slots/create', 'ReservationSlotsController@create')->name('create-reservation-slot');
Route::get('/reservation-slots/edit/{reservation-slot}', 'ReservationSlotsController@edit')->name('edit-reservation-slot');
Route::post('/reservation-slots/update/{reservation-slot}', 'ReservationSlotsController@update')->name('update-reservation-slot');
Route::get('/reservation-slots/destroy/{reservation-slot}', 'ReservationSlotsController@destroy')->name('destroy-reservation-slot');



