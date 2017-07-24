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

Route::get('/resign/{id}', 'TestController@resign');

// 正式路由
Route::get('doctors', 'AccountController@getAtWorkDoctorsPage');

Route::get('resign/{id}', 'AccountController@resign');

Route::get('profile', 'AccountController@getProfilePage');

Route::get('getChartPage', 'ChartController@getChartPage');

Route::post('doctorsChart', 'ChartController@getChartPageBySelectedID ');

// 列出全部人的預班資訊
Route::get('/reservation-all', 'ReservationController@reservation');

// 列出個人的預班資訊
Route::get('/reservation', 'ReservationController@getReservationByID');
Route::post('/reservation', 'ReservationController@addRemark');
//Route::match(['get', 'post'], '/reservation_data', "ReservationController@renderData");

//列出全部班表資訊
Route::get('/schedule-all', 'ScheduleController@schedule');

//列出個人班表資訊
Route::get('/schedule', 'ScheduleController@getScheduleByDoctorID');

<<<<<<< HEAD
Route::get('/first-edition-all', 'ScheduleController@firstSchedule');
Route::post('/first-edition-all', 'ShiftRecordsController@addShifts');
=======
// 列出所有使用者的資訊以及公假
Route::get('officialLeave', 'AccountController@getOfficialLeavePage');
>>>>>>> 76e88afd4ac1b63b453a55d89181bde5c9e65237


// ========================================================================
Route::get('getExchangeSchedulePage', function() {
	return view('testPage.exchangeSchedule');
});

Route::get('getOfficialLeavePage', 'AccountController@getOfficialLeavePage');

Route::post('exchangeSchedule', 'ShiftRecordsController@adminConfirm');

Route::post('testDateFormat', 'TestController@testDateFormat');

Route::get('testUserInfo', 'TestController@getUserInfo');

Route::get('testDate', 'TestController@getDateForm');

Route::post('testDate', 'TestController@getDateValue');

Route::get('testDoctorList', 'TestController@getDoctorList');

Route::get('testShowAtWorkDoctorList', 'TestController@showAtWorkDoctorList');

Route::post('resign', 'TestController@resign');

// 取得單一醫師班數的醫生ID傳遞 從醫師列表傳送
Route::get('getDoctorShifts/{id}', 'TestController@getShiftForDoctor');

Route::post('getDoctorShifts/updateShifts', 'TestController@updateDoctorShifts');


// push mail-sending work on the queue
Route::get('shiftExchangeMail', 'MailController@shiftExchange');

Route::get('applyShiftExchangeMail', 'MailController@applyShiftExchanging');

Route::get('exchangingSuccessMail', 'MailController@agreeShiftExchanging');

Route::get('exchangingFailedMail', 'MailController@rejectShiftExchanging');

Route::get('getTestPage', 'TestController@getTestPage');

// ========================================================================
//Route::get('/schedule', 'ScheduleController@schedule');

//Route::get('/reservation', 'AccountController@reservation');




// ===========================showReservationByresSerial==============================
Route::get('/showReservation', 'ReservationController@showReservation');
Route::post('/show','ReservationController@getDataByResSerial');

// ==================================showDoctor'sReservation==========================

//Route::post('doctor', 'ReservationController@getDoctorID');



//Route::get('/reservation', 'ReservationController@amountDayShift');

//Route::get('getReseverationByPeriodSerial','ReservationController@getReseverationByPeriodSerial');


// =============================update================================================
Route::post('updateReservation', 'ReservationController@updateReservation');
Route::post('toEdit', 'ReservationController@getDataByID');

// ===================================================================================

Route::get('/reservation/delete/{id}', 'ReservationController@deleteReservation');

// =============================add================================================
Route::get('/addReservation', function() {
    return view('addReservation');
});
Route::post('/addReservation', 'ReservationController@addReservation');
// ===================================================================================



//所有換班紀錄
Route::get('/shiftRecords/', 'ShiftRecordsController@shiftRecords');

//單一醫生換班紀錄
Route::get('/getShiftRecordsByDoctorID', 'ShiftRecordsController@getShiftRecordsByDoctorID');

//新增換班
Route::get('/addShifts', function() {
    return view('addShifts');
});
Route::post('/addShifts', 'ShiftRecordsController@addShifts');

//醫生換班確認
Route::post('/doctorCheckShift', 'ShiftRecordsController@doc2Confirm');
Route::post('/doctorCheck', 'ShiftRecordsController@getDataByID');


Route::get('/dateadd', 'ReservationController@getdateAdd');
//Route::post('reservation/updateReservation/{id}', 'ReservationController@updateReservation');
//Route::get('/reservation/updateReservation/{id}', function() {
//	return view('updateReservation');

//});
