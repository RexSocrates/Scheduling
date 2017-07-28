<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ShiftRecords;
use Illuminate\Support\Facades\Input;
use App\Schedule;
use App\User;

class ShiftRecordsController extends Controller
{
    //列出 新增換班 所有換班紀錄  醫生確認換班
    public  function  shiftRecords(){
        $shiftRecords = new ShiftRecords();
        $schedule = new Schedule();
        $user = new User();

        $currentDoctor = $user->getCurrentUserInfo();

        
        $allShiftData = $shiftRecords->getMoreCheckShiftsRecordsInformation(false);  // 列出所有待確認換班資訊

        $shiftDataByDoctorID = $shiftRecords->getMoreUncheckShiftsRecordsInformation(true); //換班待確認

        $currentDoctorSchedule=$schedule->getScheduleByCurrentDoctorID(); //查看目前登入的醫生班表資訊

        //選擇換班醫生
        $doctorName = $user->getDoctorInfoByID(2);
        $doctorSchedule = $schedule->getScheduleByDoctorID(2); //之後用ajax傳入id


        //換班確認

        return view ("pages.first-edition-shift",array('shiftRecords'=>$allShiftData,'shiftDataByDoctorID'=>$shiftDataByDoctorID,'currentDoctor'=>$currentDoctor,'currentDoctorSchedule'=>$currentDoctorSchedule,'doctorName'=>$doctorName ,'doctorSchedule'=>$doctorSchedule));

    } 

    //醫生確認換班
    public function checkShift($id){
        $shiftRecords = new ShiftRecords();

        $shiftCheck = $shiftRecords->doc2Confirm($id,1);

        return redirect ('first-edition-shift');
    }

    //醫生拒絕換班
    public function rejectShift($id){
        $shiftRecords = new ShiftRecords();

        $shiftCheck = $shiftRecords->doc2Confirm($id,2);

        return redirect ('first-edition-shift');
    }

    //查詢 單一醫生換班紀錄
    public function getShiftRecordsByDoctorID(){
        $shiftRecords = new ShiftRecords();
        $data = $shiftRecords ->getShiftRecordsByDoctorID();

        return view ("getShiftRecordsByDoctorID",array('data' => $data));
    }

    //新增換班
    public function addShifts(){
    		$addShifts = new ShiftRecords();
    		$scheduleID_1 = Input::get('scheduleID_1');
    		$scheduleID_2 = Input::get('scheduleID_2');
    		$schID_1_doctor = Input::get('schID_1_doctor');
    		$schID_2_doctor = Input::get('schID_2_doctor');
            $doc2Confirm = 0;
            $adminConfirm = 0;

    		$newShiftSerial = $addShifts->addShifts($scheduleID_1,$scheduleID_2,$schID_1_doctor,$schID_2_doctor,$doc2Confirm,$adminConfirm);

    		return redirect('first-edition-shift'); 

    }

    //醫生確認換班
    public function doc2Confirm(){
        $doc2Confirm = Input::get('doc2Confirm');
        $update = new ShiftRecords();
        $serial = Input::get('serial');
        $updatedDoc2Confirm = $update->doc2Confirm($serial,$doc2Confirm);
        
        return redirect('shiftRecords'); 

    }

    //排班人員確認換班
    public function adminConfirm(){
        $changeSerial = Input::get('changeSerial');

        $shiftRecord = new ShiftRecords();
        $adminConfirmNumber = Input::get('adminConfirm');

        $shiftRecord->adminConfirm($changeSerial,$adminConfirmNumber);

        return redirect('shiftRecords'); 

    }

     public function getDataByID() {
        $serial = Input::get('serial');

        return view('doctorCheckShift', array('serial' => $serial) );

    }


}
