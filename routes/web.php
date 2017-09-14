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
    return redirect('login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// 正式路由
Route::get('doctors', 'AccountController@getAtWorkDoctorsPage');

// Ajax get request 編輯醫師資料
Route::get('editDoctorInfo', 'AccountController@editDoctorInfo');

// 更新醫生資訊
Route::post('doctorInfoUpdate', 'AccountController@doctorInfoUpdate');

// 取得公告頁面
Route::get('index', 'AnnouncementController@getAnnouncementPage');

// 透過 AJAX 顯示單一公告
Route::get('getAnnouncement', 'AnnouncementController@getAnnouncement');

// 刪除公告
Route::get('deleteAnnouncement/{serial}', 'AnnouncementController@deleteAnnouncement');

// 設定頁面
Route::get('setting', 'AccountController@getSettingPage');

// 新增公告
Route::post('addAnnouncement', 'AnnouncementController@addOrUpdateAnnouncement');

// 醫生離職
Route::get('resign/{id}', 'AccountController@resign');

// 取得個人頁面
Route::get('profile', 'AccountController@getProfilePage');

//一般醫生新增公假
Route::post('addOfficialLeaveByDoctor', 'AccountController@addOfficialLeaveByDoctor');



// 單一醫生上班紀錄的統計圖表
Route::get('doctorsChart', 'ChartController@getChartPage');
Route::post('doctorsChart', 'ChartController@getChartPageBySelectedID');
Route::get('doctorsChart_selectedUserID','ChartController@getChartPageBySelectedDoctorID');

// 列出全部人的預班資訊
Route::get('/reservation-all', 'ReservationController@reservation');

// 列出個人的預班資訊
Route::get('/reservation', 'ReservationController@getReservationByID');

//列出
Route::get('/countDay','ReservationController@countDay');

Route::get('/alert1','ReservationController@countDay');

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
Route::get('checkShift','ShiftRecordsController@checkShift');
Route::get('rejectShift/{id}','ShiftRecordsController@rejectShift');

// 列出所有使用者的資訊以及公假
Route::get('officialLeave', 'LeaveController@getOfficialLeavePage');

//得到醫生的剩餘公假
 Route::get('getLeaveHoursByID','AccountController@hour');

//排班人員確認公假
Route::get('confirmOffcialLeave/{serial}','LeaveController@confirmOffcialLeave');

//排班人員拒絕公假
Route::get('unconfirmOffcialLeave/{serial}', 'LeaveController@unconfirmOffcialLeave');

//新增醫生公假
Route::post('addOfficialLeave', 'LeaveController@addOfficialLeaveByAdmin');


// 新增預班
Route::post('sendReservationAdd', 'ReservationController@addReservation');

// 更新預班
Route::post('sendReservationUpdate', 'ReservationController@updateReservation');

// 刪除預班
Route::post('sendReservationDelete', 'ReservationController@deleteReservation');

// 列出正式班表的換班資訊
Route::get('schedule-shift-info', 'ShiftRecordsController@getShiftRecords');
Route::post('schedule-shift-info','ShiftRecordsController@firstEditionShiftAddShifts');

//根據月份選擇列出備註
Route::get('changeMonth','RemarkController@getRemarkByMonth');


// 醫生2同意或拒絕換班
Route::get('doctor2AgreeShiftRecord/{serial}', 'ShiftRecordsController@doctor2AgreeShiftRecord');
Route::get('doctor2DenyShiftRecord/{serial}', 'ShiftRecordsController@doctor2DenyShiftRecord');



//調整班表->初版班表
Route::get('/shift-first-edition','ShiftRecordsController@shiftFirstEdition');//->name('shift-first-edition');
Route::get('change-shift-first-edition','ShiftRecordsController@shiftFirstEditionAddShifts');

//調整班表->初版班表 確認醫生1換班狀態
Route::get('checkDocStatus','ShiftRecordsController@checkDoc1ShiftStatus');

//調整班表->初版班表 確認醫生2換班狀態
//Route::get('checkDoc2Status','ShiftRecordsController@checkDoc2ShiftStatus');

// 調整班表->初版班表 新增換班
Route::post('sendShiftUpdate','ShiftRecordsController@shiftFirstEditionAddShifts');

//Route::post('getSiftInfo',"ShiftRecordsController@shiftFirstEditionShowShifts");

//調整班表->初版班表 彈出視窗醫生2資訊
Route::get('changeDoctor','AccountController@getDoctorFirstScheduleInfoByID');

//調整班表->彈出視窗醫生1資訊
Route::get('changeDoctor1','ScheduleController@getDoctorInfoByScheduleID');


//拖拉換班顯示資訊
Route::get('showInfo','ScheduleController@getDoctorInfoByScheduleIDWhenExchange');

//調整班表->新增班 驗證
Route::get('confirmsaveSchedule','ScheduleController@confirmscheduleStatus');

//調整班表->新增班
Route::get('saveSchedule','ScheduleController@addSchedule');


Route::get('updateScheduleID','ScheduleController@getDoctorInfoByScheduleID');

//調整班表->刪除班
Route::get('deleteSchedule','ScheduleController@deleteSchedule');


Route::get('checkDoctorSchedule','ScheduleController@confirmscheduleStatusBySerial');
Route::get('updateSchedule','ScheduleController@updateSchedule');


//調整班表->正式班表
Route::get('/shift-scheduler','ShiftRecordsController@shiftScheduler');

//調整班表->正式班表 彈出視窗醫生2資訊
Route::get('changeDoctorSchedule','AccountController@getDoctorSheduleInfoByID');

// 調整班表的換班資訊
Route::get('shift-info', 'ShiftRecordsController@adminShiftRecords');

//確認醫生是否有在當日上班
Route::get('getScheduleInfo','ShiftRecordsController@getShiftRecordsBySerial');

// 排班人員確認換班
Route::get('adminAgreeShiftRecord', 'ShiftRecordsController@adminAgreeShiftRecord');

// 排班人員拒絕換班
Route::get('adminDisagreeShiftRecord/{serial}', 'ShiftRecordsController@adminDisagreeShiftRecord');



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

//演算法輸入格式測試
Route::get('sendRequest', 'AlgorithmController@sendRequest');

//Route::get('test','TestController@shiftFirstEditionAddShifts');

Route::get('getAAAA', 'TestController@getAAAA');

Route::get('testDay','TestController@countDay');

Route::get('getIndex', function() {
    return view('pages.index');
});



Route::get('testDateString', 'TestController@testDateString');

Route::get('addDoctorAndResTest', 'TestController@addDoctorAndResTest');



Route::get('getExchangeSchedulePage', function() {
	return view('testPage.exchangeSchedule');
});

Route::get('getOfficialLeavePage', 'LeaveController@getOfficialLeavePage');

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
Route::get('shiftExchangeMail', 'MailController@sendShiftExchangeMail');

Route::get('applyShiftExchangeMail', 'MailController@applyShiftExchanging');

Route::get('exchangingSuccessMail', 'MailController@agreeShiftExchanging');

Route::get('exchangingFailedMail', 'MailController@rejectShiftExchanging');

Route::get('sendRandomNotificationMail', 'MailController@sendRandomNotificationMail');

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


Route::get("info",'TestController@confirmscheduleStatusBySerial');
Route::get('/dateadd', 'ReservationController@getdateAdd');
//Route::post('reservation/updateReservation/{id}', 'ReservationController@updateReservation');
//Route::get('/reservation/updateReservation/{id}', function() {
//	return view('updateReservation');

//});
