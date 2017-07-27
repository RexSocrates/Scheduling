<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\User;
use App\ScheduleCategory;

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
        ->where('doc2Confirm',1)
        ->where('adminConfirm',1)
        ->where('schID_1_doctor',$doctorID)
        ->orwhere('schID_2_doctor',$doctorID)
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

            array_push($dataInschedule, array($doctor1->name, $doctor2->name, $schedule1->date, $schedule2->date, $catName1, $catName2, $record->date));
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


    //提出換班
    public function addShifts($scheduleID_1, $scheduleID_2, $schID_1_doctor, $schID_2_doctor, $doc2Confirm, $adminConfirm){

    	$newChangeSerial= DB::table('ShiftRecords')-> insertGetId([
    				'scheduleID_1' => $scheduleID_1,
    				'scheduleID_2' => $scheduleID_2,
    				'schID_1_doctor' => $schID_1_doctor,
    				'schID_2_doctor' => $schID_2_doctor,
    				'doc2Confirm' => $doc2Confirm,
    				'adminConfirm' => $adminConfirm,
                    'date' => date('Y-m-d')

    		]);

    		return $newChangeSerial;
    }

    // 醫生確認
    public function doc2Confirm($id, $doc2Confirm){

            DB::table('shiftRecords')
                ->where('changeSerial', $id)
                ->update(['doc2Confirm' => $doc2Confirm]);


    }

	// 排班確認
    public function adminConfirm($changeSerial, $adminConfirm){

            DB::table('shiftRecords')
                ->where('changeSerial', $changeSerial)
                ->update(['adminConfirm' => $adminConfirm]); 

            $schedule = new Schedule();
            $schedule->exchangeSchedule($changeSerial);

    }



    
}
