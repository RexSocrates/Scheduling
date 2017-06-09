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

// ===========================showallReservationList==================================
Route::get('/reservation', 'AccountController@reservation');

// ==================================showDoctor'sReservation==========================

Route::post('doctor', 'AccountController@getDoctorID');
Route::get('getReservationByID', 'AccountController@getReservationByID');

// =============================update================================================
Route::post('updateReservation', 'AccountController@updateReservation');

Route::post('toEdit', 'AccountController@getDataByID');

// ===================================================================================

Route::get('/reservation/delete/{id}', 'AccountController@deleteReservation');

// =============================add================================================
Route::get('/addReservation', function() {
    return view('addReservation');
});
Route::post('/addReservation', 'AccountController@addReservation');
// ===================================================================================




Route::get('/shiftRecords/', 'ShiftRecordsController@shiftRecords');

Route::get('/addShifts', function() {
    return view('addShifts');
});

Route::post('/addShifts', 'ShiftRecordsController@addShifts');


//Route::post('reservation/updateReservation/{id}', 'AccountController@updateReservation');
//Route::get('/reservation/updateReservation/{id}', function() {
//	return view('updateReservation');

//});
