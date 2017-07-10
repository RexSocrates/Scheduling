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
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/schedule', 'ScheduleController@schedule');

Route::get('/reservation', 'AccountController@reservation');

Route::get('/reservation/updateReservation/{id}', function() {
	return view('updateReservation');
});

Route::post('reservation/updateReservation/{id}', 'AccountController@updateReservation');

Route::get('/reservation/delete/{id}', 'AccountController@deleteReservation');

Route::get('/addReservation', function() {
    return view('addReservation');
});

Route::post('/addReservation', 'AccountController@addReservation');

Route::get('/shiftRecords/{id}', 'ShiftRecordsController@shiftRecords');
