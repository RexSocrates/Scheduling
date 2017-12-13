<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class OfficialLeave extends Model
{
    //
    protected $table = 'OfficialLeave';
    
    // 取得所有公假紀錄
    public function getLeaves() {
        $leaves = DB::table('OfficialLeave')->get();
        
        return $leaves;
    }

    //取得所有未確認公假申請
    public function getUnconfirmLeaves() {
        $leaves = DB::table('OfficialLeave')
                ->where('confirmStatus',0)
                ->get();
        
        return $leaves;
    }

    //取得所有被拒絕和確認公假申請
    public function getRejectedAndConfirmLeaves() {
        $leaves = DB::table('OfficialLeave')
                ->where('confirmStatus',2)
                ->orwhere('confirmStatus',1)
                ->orderBy('recordDate', "desc")
                ->get();
        
        return $leaves;
    }

    //取得所有確認公假申請
    public function getconfirmLeaves() {
        $leaves = DB::table('OfficialLeave')
                ->where('confirmStatus',1)
                ->orderBy('leaveSerial', 'desc')
                ->get();
        
        return $leaves;
    }
    
    //取得排班月所有確認的公假申請
    public function getResMonthConfirmLeaves() {
        $resMonthStr = date('Y-m', strtotime(date('Y-m').'+1 month'));
        
        $leaves = DB::table('OfficialLeave')
            ->where('confirmStatus',1)
            ->where('leaveMonth', $resMonthStr)
            ->orderBy('leaveSerial', 'desc')
            ->get();
        
        $leaveCount = 0;
        foreach($leaves as $leave) {
            if($leave->leaveHours <= 0) {
                $leaveCount += abs($leave->leaveHours);
            }
        }
        
        return ($leaveCount / 12);
    }
    
    // 取得單一公假紀錄
    public function getLeaveBySerial($serial) {
        $leave = DB::table('OfficialLeave')
            ->where('leaveSerial', $serial)
            ->first();
        
        return $leave;
    }


    
    // 透過醫生ID 取得公假紀錄
    public function getLeavesByDoctorID($doctorID) {
        $leaves = DB::table('OfficialLeave')
            ->where('doctorID', $doctorID)
            ->orderBy('leaveSerial','desc')
            ->get();
        
        return $leaves;
    }

   
    
    // 排班人員加入公假紀錄
    public function addLeaveByAdmin(array $dataArray) {
        // confirmStatus : 0 hasn't been confirmed
        // 1 confirmed, 2 rejected
        $newSerial = DB::table('OfficialLeave')->insertGetId([
            'confirmingPersonID'=> $dataArray['confirmingPersonID'],
            'doctorID' => $dataArray['doctorID'],
            'leaveHours'=> $dataArray['leaveHours'],
            'updatedLeaveHours' =>$dataArray['updatedLeaveHours'],
            'recordDate'=> date('Y-m-d'),
            'remark' => $dataArray['remark'],
            'confirmStatus' => 1,
        ]);

        return $newSerial;
    }
    
    //更新醫生公假
    public function updateLeaveHours($doctorID,$currentOfficialLeaveHours){
         DB::table('Doctor')
            ->where('doctorID', $doctorID)
            ->update([
                'currentOfficialLeaveHours' => $currentOfficialLeaveHours,
            ]);
    }

    // 一般醫師提出公假申請
    public function applyLeave($dataArray) {
        // 公假時數需登記為負數
        
        $newSerial = DB::table('OfficialLeave')->insertGetId([
            'doctorID' => $dataArray['doctorID'],
            'leaveHours' => $dataArray['leaveHours'],
            'updatedLeaveHours' =>$dataArray['updatedLeaveHours'],
            'recordDate'=> date('Y-m-d'),
            'remark' => $dataArray['remark'],
            'leaveMonth' => $dataArray['leaveMonth'],
            'confirmStatus' => 0,
        ]);
        
        return $newSerial;
    }
    
    // 排班人員確認或拒絕公假的使用
    public function changeConfirmStatus($dataArray) {
        DB::table('OfficialLeave')
            ->where('leaveSerial', $dataArray['serial'])
            ->update([
                'confirmStatus' => $dataArray['newStatus'],
                'confirmingPersonID' => $dataArray['confirmingPerson'],
                'leaveHours' => $dataArray['leaveHours'],
                'updatedLeaveHours' =>$dataArray['updatedLeaveHours'],
            ]);
            
    }

   
    
}
