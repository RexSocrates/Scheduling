<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\ShiftRecords;
use App\ShiftCategory;
use App\Schedule;
use App\OfficialLeave;



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
    
    // 取得個人資料頁面
    public function getProfilePage() {
        $user = new User();
        $shiftRecords = new ShiftRecords();

        $data = $shiftRecords->getMoreCheckShiftsRecordsInformation(true); //到shiftrecords modle找資料

       
        return view('pages.profile', [
             'doctor' => $user->getCurrentUserInfo(),
             'doctorShiftRecords' =>$data
         ]);
    }
    
    // 取奪所有醫師的公假紀錄
    public function getOfficialLeavePage() {

        $user = new User();
        $officialLeave = new OfficialLeave();
        
        $doctors = $user->getDoctorList();
        
        $doctorsLeave = array();
        
        foreach($doctors as $doctor) {
            $leaves = $officialLeave->getLeavesByDoctorID($doctor->doctorID);
            
            array_push($doctorsLeave, array($doctor, $leaves));
        }
            //return $doctorsLeave;
        return view('pages.officialaffair', [
            'doctorsLeave' => $doctorsLeave
        ]);
        
    }

     public function getOfficialLeavePageById(Request $request) {
        $data = $request->all();
        
        $user = new User();

        $doctorID = $data['id'];

        $officialLeave = new OfficialLeave();
        
        $leaves = $officialLeave->getLeavesByDoctorID($doctorID);
        
        $doctorsLeave = array();
        
        foreach($leaves as $leave) {
            $recordDate = $leave->recordDate;
            $confirmingPersonID = $leave->confirmingPersonID;
            $leaveDate = $leave->leaveDate;
            $remark = $leave->remark;
            $leaveHours = $leave->leaveHours;
            
            array_push($doctorsLeave, array($recordDate,$confirmingPersonID,$leaveDate,$remark,$leaveHours,$doctorID));
            //echo $doctorsLeave[0];
        }
            return $doctorsLeave;
            //echo $doctorsLeave[1][0];
        // return view('pages.officialaffair', [
        //     'doctorsLeave' => $doctorsLeave
        // ]);
        
    }
    
    // 調整班表->彈出式視窗取得醫生2的上班資訊
    public function getDoctorInfoByID(Request $request){
        $data = $request->all();

        $schedule = new Schedule();

        $user = new User();
        
        $doctor = $schedule->getNextMonthShiftsByID($data['id']);

        $array = array();

        foreach ($doctor as $data) {
            $id = $data->scheduleID;
            $date = $data->date;
            $name = $user->getDoctorInfoByID($data->doctorID)->name;
            
            array_push($array, array($id,$name,$date));
        }

        return $array;
    }
    
    // Ajax get request 用於醫生頁面編輯 回傳指定醫生資料
    public function editDoctorInfo(Request $request) {
        $data = $request->all();
        $doctorID = (int)$data['doctorID'];
        
        $userObj = new User();
        
        $doctorData = $userObj->getDoctorInfoByID($doctorID);
        
        return [
            $doctorData->doctorID,
            $doctorData->email,
            $doctorData->name,
            $doctorData->level,
            $doctorData->major,
            $doctorData->location,
            $doctorData->identity,
            $doctorData->mustOnDutyTotalShifts,
            $doctorData->mustOnDutyMedicalShifts,
            $doctorData->mustOnDutySurgicalShifts,
            $doctorData->mustOnDutyTaipeiShifts,
            $doctorData->mustOnDutyTamsuiShifts,
            $doctorData->mustOnDutyDayShifts,
            $doctorData->mustOnDutyNightShifts,
        ];
    }
    
    // 醫師管理頁面->更新醫師資訊
    public function doctorInfoUpdate(Request $request) {
        $data = $request->all();
        $doctorID = $data['hiddenDoctorID'];
        
        $userObj = new User();
        
        $userObj->updateUserWithSpecificID($doctorID, $data);
        
        return redirect('doctors');
    }
    
    public function getSettingPage() {
        return view('pages.setting');
    }
}
