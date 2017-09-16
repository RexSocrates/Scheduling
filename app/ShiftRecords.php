<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\User;
use App\ScheduleCategory;
use App\ConfirmStatus;

class ShiftRecords extends Model
{
    protected $table = "ShiftRecords";

    //查看 全部換班申請(醫生與排班人員尚未確認)
    public function getUncheckShiftRecordsList(){
        $shiftRecords = DB::table("ShiftRecords")
        ->where('doc2Confirm',0)
        ->where('adminConfirm',0)
        ->get();

         return $shiftRecords;
    }

    //查看 全部換班確認申請(醫生與排班人員確認)
    public function checkShiftRecordsList(){
        $shiftRecords = DB::table("ShiftRecords")
        ->where('doc2Confirm',1)
        ->where('adminConfirm',1)
        ->get();

         return $shiftRecords;
    }
    
    //查看 全部換班確認申請(排班人員尚未確認)
    public function shiftRecordsList() {
        $records = DB::table('ShiftRecords')
            ->where('doc2Confirm',1)
            ->where('adminConfirm',0)
            ->get();
        
        return $records;
    }

    //查看 醫生2確認換班申請
    public function doc2CheckShifts() {
        $records = DB::table('ShiftRecords')
            ->where('doc2Confirm',1)
            ->orderBy('date','desc')
            ->get();
        
        return $records;
    }
   
    //查詢 單一換班紀錄
    public function getShiftRecordByChangeSerial($changeSerial){
        $shiftRecord=DB::table('ShiftRecords')
        ->where('changeSerial',$changeSerial)
        ->first();

        return $shiftRecord;
    }



    //查詢 單一醫生換班紀錄(已確認)
    public function getShiftRecordsByDoctorID(){
        $user = new User();
        $doctorID = $user->getCurrentUserID();
        $shiftRecords=DB::table('ShiftRecords')
        ->where('schID_1_doctor',$doctorID)
        ->orwhere('schID_2_doctor',$doctorID)
        ->where('doc2Confirm',1)
        ->where('adminConfirm',1)
        ->get();

        return $shiftRecords;
    }

    //查詢 單一醫生換班(未確認)
    public function getUncheckShiftRecordsByDoctorID(){
        $user = new User();
        $doctorID = $user->getCurrentUserID();
        $shiftRecords=DB::table('ShiftRecords')
        ->where('schID_2_doctor',$doctorID)
        ->where('doc2Confirm',0)
        ->where('adminConfirm',0)
        ->get();

        return $shiftRecords;
    }

    //查詢 單一醫生換班紀錄
    public function getRejectShiftRecordsByDoctorID(){
        $user = new User();
        $doctorID = $user->getCurrentUserID();

        $shiftRecords=DB::table('ShiftRecords')
            ->where('doc2Confirm',2)
            ->orwhere('adminConfirm',2)
            ->orwhere('adminConfirm',0)
            ->where('schID_1_doctor', $doctorID)
            ->orWhere('schID_2_doctor', $doctorID)
            ->where('doc2Confirm',2)
            ->orwhere('adminConfirm',2)
            ->orwhere('adminConfirm',0)
            ->get();

        return $shiftRecords;
    }

    //查看 換班紀錄
    public function getShiftRecordsList(){
        $shiftRecords = DB::table("ShiftRecords")
        ->get();

         return $shiftRecords;
    }
    
    // 依照申請日期取出所有換班紀錄
    public function getRecordsOrderByDate() {
        $records = DB::table('ShiftRecords')
            ->orderBy('date', 'desc')
            ->get();
        
        return $records;
    }


    // 更多資訊的換班紀錄(已確認)
    public function getMoreCheckShiftsRecordsInformation($single){

        $schedule = new Schedule();
        $user = new User();
        $shiftCategory = new ScheduleCategory();      

        $shiftRecordsData;

        if($single) {
            // 只搜尋個人
            $shiftRecordsData = $this->getShiftRecordsByDoctorID(); 
        }else {
            $shiftRecordsData = $this->checkShiftRecordsList();
        }

       $dataInschedule = array();

        foreach ($shiftRecordsData as $record) {

            $doctor1 = $user->getDoctorInfoByID($record->schID_1_doctor);
            $doctor2 = $user->getDoctorInfoByID($record->schID_2_doctor);

            $schedule1 = $schedule->getScheduleDataByID($record->scheduleID_1);
            $schedule2 = $schedule->getScheduleDataByID($record->scheduleID_2);
            
            $catName1 = $shiftCategory->findScheduleName($schedule1->schCategorySerial);
            $catName2 = $shiftCategory->findScheduleName($schedule2->schCategorySerial);

            array_push($dataInschedule, array($doctor1->name, $doctor2->name, $schedule1->date, $schedule2->date, $catName1, $catName2, $record->date, $record->changeSerial));
        }
        return $dataInschedule;
    }

     // 更多資訊的換班申請(未確認)
    public function getMoreUncheckShiftsRecordsInformation($single){

        $schedule = new Schedule();
        $user = new User();
        $shiftCategory = new ScheduleCategory();      

        $shiftRecordsData;

        if($single) {
            // 只搜尋個人
            $shiftRecordsData = $this->getUncheckShiftRecordsByDoctorID(); 
        }else {
            $shiftRecordsData = $this->getUncheckShiftRecordsList();
        }

        $dataInschedule = array();

        foreach ($shiftRecordsData as $record) {

            $doctor1 = $user->getDoctorInfoByID($record->schID_1_doctor);
            $doctor2 = $user->getDoctorInfoByID($record->schID_2_doctor);

            $schedule1 = $schedule->getScheduleDataByID($record->scheduleID_1);
            $schedule2 = $schedule->getScheduleDataByID($record->scheduleID_2);
            
            $catName1 = $shiftCategory->findScheduleName($schedule1->schCategorySerial);
            $catName2 = $shiftCategory->findScheduleName($schedule2->schCategorySerial);

            array_push($dataInschedule, array($doctor1->name, $doctor2->name, $schedule1->date, $schedule2->date, $catName1, $catName2, $record->date, $record->changeSerial));
        }
        return $dataInschedule;
    }

     // 被所有拒絕換班紀錄
    public function getRejectShiftsRecordsInformation($single){

        $schedule = new Schedule();
        $user = new User();
        $shiftCategory = new ScheduleCategory();  
        $comfirmStatus = new ConfirmStatus();  

        $shiftRecordsData;

        if($single) {
            // 只搜尋個人
            $shiftRecordsData = $this->getRejectShiftRecordsByDoctorID(); 
        }else {
            $shiftRecordsData = $this->getShiftRecordsList();
        }

        $dataInschedule = array();

        foreach ($shiftRecordsData as $record) {

            $doctor1 = $user->getDoctorInfoByID($record->schID_1_doctor);
            $doctor2 = $user->getDoctorInfoByID($record->schID_2_doctor);

            $schedule1 = $schedule->getScheduleDataByID($record->scheduleID_1);
            $schedule2 = $schedule->getScheduleDataByID($record->scheduleID_2);
            
            $catName1 = $shiftCategory->findScheduleName($schedule1->schCategorySerial);
            $catName2 = $shiftCategory->findScheduleName($schedule2->schCategorySerial);

            $doc2Confirm = $comfirmStatus->getStatusBySerial($record->doc2Confirm);
            $adminConfirm = $comfirmStatus->getStatusBySerial($record->adminConfirm);

            array_push($dataInschedule, array($doctor1->name, $doctor2->name, $schedule1->date, $schedule2->date, $catName1, $catName2, $record->date, $record->changeSerial, $doc2Confirm, $adminConfirm ));
        }
        return $dataInschedule;
    }

    //提出換班
    public function addShifts($data){

    	$newChangeSerial= DB::table('ShiftRecords')-> insertGetId([
    				'scheduleID_1' => $data['scheduleID_1'],
    				'scheduleID_2' => $data['scheduleID_2'],
    				'schID_1_doctor' => $data['schID_1_doctor'],
    				'schID_2_doctor' => $data['schID_2_doctor'],
    				'doc2Confirm' => $data['doc2Confirm'],
    				'adminConfirm' => $data['adminConfirm'],
                    'date' => date('Y-m-d')

    		]);

    		return $newChangeSerial;
    }

    // 醫生確認
    public function doc2Confirm($serial, $doc2Confirm){
        DB::table('shiftRecords')
            ->where('changeSerial', $serial)
            ->update(['doc2Confirm' => $doc2Confirm]);
    }

	// 排班人員確認
    public function adminConfirm($changeSerial, $adminConfirm){
       DB::table('shiftRecords')
            ->where('changeSerial', $changeSerial)
            ->update(['adminConfirm' => $adminConfirm]);
        if($adminConfirm==1){
           $schedule = new Schedule();
           $schedule->exchangeSchedule($changeSerial);
        } 
    }

    // 查詢 換班編號
    public function getChangeSerial($scheduleID_1,$scheduleID_2){
        $changeSerial=DB::table('shiftRecords')
        ->where('scheduleID_1',$scheduleID_1)
        ->where('scheduleID_1',$scheduleID_1)
        ->first();

        return $changeSerial;

    }
}
