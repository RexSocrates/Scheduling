<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\ShiftRecords;
use App\ShiftCategory;
use App\Schedule;


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

        $dataInschedule = array();

        $doctorShiftRecords = $shiftRecords->getShiftRecordsByDoctorID();

        foreach ($doctorShiftRecords as $record) {
            $doctor1 = $user->getDoctorInfoByID($record->schID_1_doctor);
            $doctor2 = $user->getDoctorInfoByID($record->schID_2_doctor);
            $schedule1 = $schedule->scheduleData($record->scheduleID_1);
            $schedule2 = $schedule->scheduleData($record->scheduleID_2);
            $catName1 = $shiftCategory->findName($schedule1->category);
            $catName2 = $shiftCategory->findName($schedule2->category);

            $record->schID_1_doctor = $doctor1->name;
            $record->schID_2_doctor = $doctor2->name;
            // $record->categorySerial = $categoryName->categoryName;

            array_push($dataInschedule, array($doctor1->name, $doctor2->name, $schedule1->date, $schedule2->date, $catName1, $catName2));
        }

        return view('pages.profile', [
            'doctor' => $user->getCurrentUserInfo(),
            'doctorShiftRecords' =>$dataInschedule
        ]);
    }
}
