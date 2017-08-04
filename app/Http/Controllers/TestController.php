<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use App\User;
use App\Remark;
use App\Announcement;

class TestController extends Controller
{
    
    // 印出目前登入的使用者ID
    public function getUserInfo() {
        $user = new User();
        
        echo 'User ID : '.$user->getCurrentUserID();
    }
    
    // 回傳輸入日期的表單
    public function getDateForm() {
        return view('testPage.testDate');
    }
    
    // 測試日期印出格式
    public function getDateValue() {
        $date = Input::get('date');
        
        echo $date;
    }
    
    // 取得在職醫師名單
    public function showAtWorkDoctorList() {
        $user = new User();
        
        $data = ['doctors' => $user->getAtWorkDoctors()];
        
        return view('testPage.doctorAtWorkList', $data);
    }
    
    // 單一醫生離職
    public function resign($id) {
        $user = new User();
        
//        $resignedDoctorID = Input::get('doctorID');
        
        $user->resign($id);
        
        return redirect('testShowAtWorkDoctorList');
    }
    
    // 取得單一醫生所有的排班班數
    public function getShiftForDoctor($id) {
//        echo 'Doctor ID : '.$id;
        $user = new User();
        
        $userData = $user->getDoctorInfoByID($id);
        
        return view('testPage.doctorShifts', ['userData' => $userData]);
    }
    
    // 更新單一醫師的排班資料
    public function updateDoctorShifts(Request $request) {
        $data = $request->all();
        
        $user = new User();
        
        $rows = $user->updateShifts($data['doctorID'], $data);
        
        return redirect('testDoctorList');
    }
    
    public function getTestPage() {
        return view('pages.doctor');
    }
    
    public function addoneDay() {
        $time = strtotime(date('Y-m-d'));
        echo $time.'<br>';
        
        $newformat = date('Y-m-d',$time + 24 * 60 * 60);
        
        echo $newformat;
    }
    
    // 回傳醫生名單頁面
    public function getDoctorList() {
        $user = new User();
        
        $data = [
            'doctors' => $user->getDoctorList(),
            'userName' => $user->getCurrentUserInfo()->name
        ];
        
        return view('pages.doctor', $data);
    }
    
    public function testDateFormat(Request $request) {
        $data = $request->all();
        
        echo 'Date format : '.$data['birthday'];
    }
    
    public function getChartPage() {
        return view('pages.chart');
    }
    
    public function getOfficialLeavePage() {
        return view('pages.officialaffair');
    }
    
    public function reservationSave() {
//        $id = Input::get('field_name');
        
        $remark = new Remark();
        
        $remark->addRemark(100, 'asdfgh');
        
//        echo 'ID : '.$id;
    }
    
    //測試 jQuery 的 AJAX 
    public function postAjaxRequest(Request $request) {
        $requestedData = $request->all();
        
        $annoucement = new Announcement();
        
        $data = [
            'doctorID' => 1,
//            'title' => 'This is title',
            'title' => $requestedData['date'],
//            'title' => $requestedData['number'],
//            'content' => 'This is content'
            'content' => $requestedData['content']
        ];
        
        $annoucement->addAnnouncement($data);
    }
}