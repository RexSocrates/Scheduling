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

// 正式路由
Route::get('doctors', 'AccountController@getAtWorkDoctorsPage');

// 取得公告頁面
Route::get('index', 'AnnouncementController@getAnnouncementPage');

// 新增公告
Route::post('addAnnouncement', 'AnnouncementController@addAnnouncement');

Route::get('resign/{id}', 'AccountController@resign');

// 取得個人頁面
Route::get('profile', 'AccountController@getProfilePage');

// 統計圖表頁面
Route::get('getChartPage', 'ChartController@getChartPage');

// 單一醫生上班紀錄的統計圖表
Route::post('doctorsChart', 'ChartController@getChartPageBySelectedID');

// 列出全部人的預班資訊
Route::get('/reservation-all', 'ReservationController@reservation');

// 列出個人的預班資訊
Route::get('/reservation', 'ReservationController@getReservationByID');

//列出
Route::get('/countDay','ReservationController@countDay');

//Route::get('alert1','ReservationController@countDay');

//Route::get('count','ReservationController@countDay');
// 新增備註
Route::post('/addRemark', 'ReservationController@addRemark');

Route::match(['get', 'post'], '/reservation_data', "ReservationController@renderData");

//列出全部班表資訊
Route::get('/schedule-all', 'ScheduleController@schedule');

//列出個人班表資訊
Route::get('/schedule', 'ScheduleController@getScheduleByDoctorID');

//初版班表 個人
Route::get('first-edition', 'ScheduleController@firstEditionSchedule');

//初版班表 全部醫生
Route::get('/first-edition-all', 'ScheduleController@firstSchedule');

//初版班表->換班資訊
Route::get('first-edition-shift-info','ShiftRecordsController@shiftRecords');
Route::post('first-edition-shift-info','ShiftRecordsController@firstEditionShiftAddShifts');

// Route::post('doctorInfo','ShiftRecordsController@doctorInfo');
// Route::get('doctorInfo',function(){
// 	return view('pages.first-edition-shift-info');
// });


//初版班表->換班資訊 換班確認
Route::get('checkShift/{id}','ShiftRecordsController@checkShift');
Route::get('rejectShift/{id}','ShiftRecordsController@rejectShift');

// 列出所有使用者的資訊以及公假
Route::get('officialLeave', 'AccountController@getOfficialLeavePage');

// 新增預班
Route::post('sendReservationAdd', 'ReservationController@addReservation');

// 更新預班
Route::post('sendReservationUpdate', 'ReservationController@updateReservation');

// 刪除預班
Route::post('sendReservationDelete', 'ReservationController@deleteReservation');

// 列出正式班表的換班資訊
Route::get('schedule-shift-info', 'ShiftRecordsController@getShiftRecords');
Route::post('schedule-shift-info','ShiftRecordsController@firstEditionShiftAddShifts');


// 醫生2同意或拒絕換班
Route::get('doctor2AgreeShiftRecord/{serial}', 'ShiftRecordsController@doctor2AgreeShiftRecord');
Route::get('doctor2DenyShiftRecord/{serial}', 'ShiftRecordsController@doctor2DenyShiftRecord');



//調整班表->初版班表
Route::get('/shift-first-edition','ShiftRecordsController@shiftFirstEdition');

// 調整班表->初版班表 新增換班
Route::post('sendShiftUpdate','ShiftRecordsController@shiftFirstEditionAddShifts');

// 調整班表的換班資訊
Route::get('shift-info', 'ShiftRecordsController@adminShiftRecords');

// 排班人員確認換班
Route::get('adminAgreeShiftRecord/{serial}', 'ShiftRecordsController@adminAgreeShiftRecord');



Route::group(['middleware' => ['admin']], function () {
    // 給排班人員的路由
});

Route::group(['middleware' => ['auth']], function () {
    // 給一般醫生(登入後的使用者)的路由
});






// ========================================================================
//Route::post('postAjaxRequest', 'TestController@postAjaxRequest');
//Route::get('postAjaxRequest', 'TestController@postAjaxRequest');

Route::get('test','TestController@shiftFirstEditionAddShifts');

Route::get('testDay','TestController@countDay');
//調整班表->正式班表
Route::get('shift-scheduler', function() {
	return view('pages.shift-scheduler');
});

Route::get('getIndex', function() {
    return view('pages.index');
});



Route::get('testDateString', 'TestController@testDateString');

Route::get('addDoctorAndResTest', 'TestController@addDoctorAndResTest');

Route::get('changeDoctor','AccountController@getDoctorInfoByID');


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
// Route::get('/addShifts', function() {
//     return view('addShifts');
// });
// Route::post('/addShifts', 'ShiftRecordsController@addShifts');

//醫生換班確認
//Route::post('/doctorCheckShift', 'ShiftRecordsController@doc2Confirm');
//Route::post('/doctorCheck', 'ShiftRecordsController@getDataByID');


//Route::get("info",'AccountController@getDoctorInfoByID');
Route::get('/dateadd', 'ReservationController@getdateAdd');
//Route::post('reservation/updateReservation/{id}', 'ReservationController@updateReservation');
//Route::get('/reservation/updateReservation/{id}', function() {
//	return view('updateReservation');

//});
