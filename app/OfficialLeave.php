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
    
    // 取得單一公假紀錄
    public function getLeaveBySerial($serial) {
        $leave = DB::table('OfficialLeave')
            ->where('leaveSerial', $serial)
            ->first();
        
        return $leave;
    }
    
    // 排班人員加入公假紀錄
    public function addLeave($dataArray) {
        // confirmStatus : 0 hasn't been confirmed
        // 1 confirmed, 2 rejected
        $newSerial = DB::table('OfficialLeave')->insertGetId([
            'doctorID' => $dataArray['doctorID'],
            'recordDate'=> date('Y-m-d'),
            'remark' => $dataArray['remark'],
            'confirmStatus' => 1,
        ]);
        
        return $newSerial;
    }
    
    // 一般醫師提出公假申請
    public function applyLeave($dataArray) {
        // 公假時數需登記為負數
        
        $newSerial = DB::table('OfficialLeave')->insertGetId([
            'doctorID' => $dataArray['doctorID'],
            'leaveHours' => $dataArray['leaveHours'],
            'recordDate'=> date('Y-m-d'),
            'remark' => $dataArray['remark'],
            'confirmStatus' => 0,
        ]);
        
        return $newSerial;
    }
    
    // 排班人員確認或拒絕公假的使用
    public function changeConfirmStatus($dataArray) {
        DB::table('OfficialLeave')
            ->where('leaveSerial', $dataArray['serial'])
            ->update(['confirmStatus' => $dataArray['newStatus'],
                     'confirmingPersonID' => $dataArray['confirmingPerson']]);
    }
    
}
