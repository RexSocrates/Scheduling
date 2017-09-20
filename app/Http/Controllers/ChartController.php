<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Schedule;

class ChartController extends Controller
{
    //
    // 取得正式班表統計圖表頁面
    public function getChartPage() {
        $user = new User();
        
        $doctors = $user->getAtWorkDoctors();
        
        $currentUser = $user->getCurrentUserInfo();
        
        $schedule = new Schedule();
        
        $shifts = $schedule->getCurrentMonthShiftsByID($currentUser->doctorID);
        
        $shiftsData = $schedule->countScheduleCategory($shifts);
        
        return view('pages.chart', [
            'doctors' => $doctors,
            'currentUser' => $currentUser->name,
            'totalShift' => count($shifts),
            'shiftsData' => $shiftsData
        ]);
    }
    
    // 取得特定醫師在正式班表中的上班統計資訓
    public function getChartPageBySelectedID(Request $request) {
        $data = $request->all();
        $user = new User();

        $doctors = $user->getAtWorkDoctors();
        
        $userID = $data['selectedUserID'];
        
       
        $selectedtUser = $user->getDoctorInfoByID($userID)->name;
        
        $schedule = new Schedule();
        
        $shifts = $schedule->getCurrentMonthShiftsByID($userID);
        
        $shiftsData = $schedule->countScheduleCategory($shifts);
        
       
        $array = array($selectedtUser,count($shifts),$shiftsData);
    
       return view('pages.chart', [
            'doctors' => $doctors,
            'currentUser' => $selectedtUser,
            'totalShift' => count($shifts),
            'shiftsData' => $shiftsData
        ]);
       
    }

    public function getChartPageBySelectedDoctorID(Request $request) {
        $data = $request->all();

        $user = new User();
        
        $userID = $data['selectedUserID'];
       
        $selectedtUser = $user->getDoctorInfoByID($userID)->name;
        
        $schedule = new Schedule();
        
        $shifts = $schedule->getCurrentMonthShiftsByID($userID);
        
        $shiftsData = $schedule->countScheduleCategory($shifts);
        
       
        $array = array($selectedtUser,count($shifts),$shiftsData);
    
        return $array;
       
    }

    
    
}
