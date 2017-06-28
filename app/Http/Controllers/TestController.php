<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use App\User;

class TestController extends Controller
{
    
    // 印出目前登入的使用者ID
    public function getUserID() {
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
    
    // 回傳醫生名單頁面
    public function getDoctorList() {
        $user = new User();
        
        $data = ['doctors' => $user->getDoctorList()];
        
        return view('testPage.doctorList', $data);
    }
    
    // 取得在職醫師名單
    public function showAtWorkDoctorList() {
        $user = new User();
        
        $data = ['doctors' => $user->getAtWorkDoctors()];
        
        return view('testPage.doctorAtWorkList', $data);
    }
    
    // 單一醫生離職
    public function resign() {
        $user = new User();
        
        $resignedDoctorID = Input::get('doctorID');
        
        $user->resign($resignedDoctorID);
        
        return redirect('testShowAtWorkDoctorList');
    }
}