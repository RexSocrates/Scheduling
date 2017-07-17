<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\User;
class ShiftRecords extends Model
{
    protected $table = "ShiftRecords";

    //查看換班
    public function shiftRecordsList(){
        $shiftRecords = DB::table("ShiftRecords")->get();

         return $shiftRecords;

    }
   

     //查詢 單一醫生換班紀錄
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

    //提出換班
    public function addShifts($scheduleID_1, $scheduleID_2, $schID_1_doctor, $schID_2_doctor, $doc2Confirm, $adminConfirm, $created_at){

    	$newChangeSerial= DB::table('ShiftRecords')-> insertGetId([
    				'scheduleID_1' => $scheduleID_1,
    				'scheduleID_2' => $scheduleID_2,
    				'schID_1_doctor' => $schID_1_doctor,
    				'schID_2_doctor' => $schID_2_doctor,
    				'doc2Confirm' => $doc2Confirm,
    				'adminConfirm' => $adminConfirm,
                    'created_at' => $created_at

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
    public function adminConfirm($id, $adminConfirm){

            DB::table('shiftRecords')
                ->where('changeSerial', $id)
                ->update(['adminConfirm' => $adminConfirm]);        

    }

    
}
