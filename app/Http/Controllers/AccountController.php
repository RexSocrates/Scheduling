<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\ShiftRecords;
use App\ShiftCategory;
use App\Schedule;

use App\Jobs\GetShiftRecordsInformation;

class AccountController extends Controller
{
    //取得在職醫師列表
    public function getAtWorkDoctorsPage() {
        $user = new User();
        
        $data = [
            'doctors' => $user->getAtWorkDoctors(),
            'userName' => $user->getCurrentUserInfo()->name
        ];
        
        return view('pages.doctor', $data);
    }
    
    // 單一醫生離職
    public function resign($id) {
        $user = new User();
        
        $user->resign($id);
        
        return redirect('doctors');
    }
    
    public function getProfilePage() {
        $user = new User();
        $shiftRecords = new ShiftRecords();

        $data = $shiftRecords->getMoreShiftsRecordsInformation(true); //到shiftrecords modle找資料

       
        return view('pages.profile', [
             'doctor' => $user->getCurrentUserInfo(),
             'doctorShiftRecords' =>$data
         ]);
    }
}
