<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Schedule;

class ChartController extends Controller
{
    //
    
    public function getChartPage() {
        $user = new User();
        
        $doctors = $user->getAtWorkDoctors();
        
        //$currentUser = $user->getCurrentUserInfo();
        
        $schedule = new Schedule();
        
        $shifts = $schedule->getCurrentMonthShiftsByID(3);
        
        $shiftsData = $schedule->countScheduleCategory($shifts);
        
        return view('pages.chart', [
            'doctors' => $doctors,
            'currentUser' => "張瑋翎",
            'totalShift' => count($shifts),
            'shiftsData' => $shiftsData
        ]);
    }
    
    public function getChartPageBySelectedID(Request $request) {
        $userID = $request->get('selectedUserID');
        
        $user = new User();
        
        $doctors = $user->getAtWorkDoctors();
        
        $selectedtUser = $user->getDoctorInfoByID($userID);
        
        $schedule = new Schedule();
        
        $shifts = $schedule->getCurrentMonthShiftsByID($userID);
        
        $shiftsData = $schedule->countScheduleCategory($shifts);
        
        return view('pages.chart', [
            'doctors' => $doctors,
            'currentUser' => $selectedtUser,
            'totalShift' => count($shifts),
            'shiftsData' => $shiftsData
        ]);
    }
    
    
}
