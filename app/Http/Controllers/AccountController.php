<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// import models
use App\User;
use App\ShiftRecords;
use App\ShiftCategory;
use App\Schedule;
use App\OfficialLeave;
use App\ConfirmStatus;
use App\ScheduleRecord;



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
        $officialLeave = new OfficialLeave();
        $shiftRecords = new ShiftRecords();
        $confirmStatus = new ConfirmStatus();
        $scheduleRecord = new ScheduleRecord();

        $doctorShiftRecords = $shiftRecords->getMoreCheckShiftsRecordsInformation(true); //到shiftrecords modle找資料

        $doctorOfficialLeave = $officialLeave->getLeavesByDoctorID($user->getCurrentUserID());

        $officialLeaveArr =[];

        foreach ($doctorOfficialLeave as $leave) {
            $leaveDic =[
                'date' => $leave->recordDate,
                'remark' => $leave->remark,
                'hour' => $leave->leaveHours,
                'status'=> ''
            ];

            $leaveDic['status'] = $confirmStatus->getStatusBySerial($leave->confirmStatus);

            array_push($officialLeaveArr,$leaveDic);

        }

        $leaveHours=[];
        $hour = $user->getCurrentUserInfo()->currentOfficialLeaveHours;


          
       $doctorScheduleRecords = $scheduleRecord->getScheduleRecordByDoctorID($user->getCurrentUserID());

       $scheduleRecordArr =[];

        foreach ($doctorScheduleRecords as $record) {
            $recordDic =[
                'date' => $record->month,
                'shiftHours' => $record->shiftHours,
            ];

            array_push($scheduleRecordArr,$recordDic);

        }

        $totalScheduleRecords = $scheduleRecord->getScheduleTotoalBydoctorID($user->getCurrentUserID());

        for ($i=12 ; $i<=$hour;) {
            array_push($leaveHours,$i);
            $i=$i+12;
        }

         //選擇月份
        $currentMonth = date('Y-m');
        $nextMonth=date("Y-m", strtotime('+1 month'));
        
        return view('pages.profile', [
             'doctor' => $user->getCurrentUserInfo(),
             'doctorShiftRecords' =>$doctorShiftRecords,
             'doctorOfficialLeave'=>$officialLeaveArr,
             'leaveHours' => $leaveHours,
             'currentMonth'=>$currentMonth,
             'nextMonth'=>$nextMonth,
             'doctorScheduleRecords'=>$scheduleRecordArr,
             'totalScheduleRecords' => $totalScheduleRecords
         ]);
    }
    
    public function hour(Request $request){
        $data = $request['id'];
        $user = new User();
        $hour = $user->getDoctorInfoByID($data)->currentOfficialLeaveHours;
        return $hour;
    }

    //醫生申請公假
    public function addOfficialLeaveByDoctor(Request $request){
        $data = $request->all();

        $user = new User();
        $officialLeave = new officialLeave();

        $leave = [
            'doctorID' => $user->getCurrentUserInfo()->doctorID,
            'leaveHours'=> -1*$data['hour'],
            'updatedLeaveHours' => $user->getCurrentUserInfo()->currentOfficialLeaveHours+(-1*$data['hour']),
            'leaveMonth'=>$data['leaveMonth'],
            'remark' => $data['content'],
        ];
    

        $leave = $officialLeave->applyLeave($leave);

        return redirect('profile');

    }

    // 回傳醫生的公假
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
    
   
    // 調整班表->正式班表 彈出式視窗取得醫生2的上班資訊
    public function getDoctorSheduleInfoByID(Request $request){
        $data = $request->all();

        $schedule = new Schedule();

        $user = new User();
        
        $doctor = $schedule->getCurrentMonthShiftsByID($data['id']);

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
            $doctorData->totalShift,
            $doctorData->mustOnDutyTotalShifts,
            $doctorData->mustOnDutyMedicalShifts,
            $doctorData->mustOnDutySurgicalShifts,
            $doctorData->mustOnDutyTaipeiShifts,
            $doctorData->mustOnDutyTamsuiShifts,
            $doctorData->mustOnDutyDayShifts,
            $doctorData->mustOnDutyNightShifts,
            $doctorData->weekendShifts
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
    
    
    //公布正式班表
    public function announceSchedule(Request $request){
        
        $schedule = new Schedule();

        $schedule->confirmNextMonthSchedule();
 
    }
    
    


    public function getRecordByDoctor(Request $request){

        $data = $request->all();

        $scheduleRecord = new ScheduleRecord();
        $user = new User();
        $records = $scheduleRecord->getAllScheduleRecordByDoctorID($data['doctorID']); 

        $scheduleRecordArr=[];

        foreach ($records as $record ) {
           $recordDic =[
                'date' => $record->month,
                'shiftHours' => $record->shiftHours,
                'doctorName' => $user->getDoctorInfoByID($data['doctorID'])->name
            ];

            array_push($scheduleRecordArr,$recordDic);
        }

        return $scheduleRecordArr; 
    }
}
