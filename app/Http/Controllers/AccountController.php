<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\ShiftRecords;
use App\ShiftCategory;


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
        $shiftCategory = new ShiftCategory();
        $schedule = new Schedule();

        $doctorShiftRecords = $shiftRecords->getShiftRecordsByDoctorID();
         foreach ($doctorShiftRecords as $shiftRecords) {
            $name1 = $user->getDoctorInfoByID($shiftRecords->schID_1_doctor);
            $name2 = $user->getDoctorInfoByID($shiftRecords->schID_2_doctor);
            $categorySerial = $shiftRecords->shiftRecords($shiftRecords->scheduleID);
            $categoryName = $categorySerial->findName($shiftRecords->categorySerial);
            $shiftRecords->schID_1_doctor = $name1->name;
            $shiftRecords->schID_2_doctor = $name2->name;
            $shiftRecords->categorySerial = $categoryName->categoryName;
        }

        return view('pages.profile', [
            'doctor' => $user->getCurrentUserInfo(),'doctorShiftRecords' =>$doctorShiftRecords
        ]);
    }
}