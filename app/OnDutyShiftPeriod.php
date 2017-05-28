<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class OnDutyShiftPeriod extends Model
{
    //
    protected $table = 'OnDutyShiftPeriod';
    
    // 加入醫生ID與時段編號
    public function addShiftToDoctorAndPeriod($id, $periodSerial, $shifts) {
        // 如果已有記錄就更改，沒有記錄就新增
        
        $count = DB::table('OnDutyShiftPeriod')
            ->where('doctorID', $id)
            ->where('periodSerial', $periodSerial)
            ->count();
        
        if($count == 0) {
            // 新增資料
            
            DB::table('OnDutyShiftPeriod')->insert([
                'doctorID' => $id,
                'periodSerial' => $periodSerial,
                'shifts' => $shifts
            ]);
        }else {
            // 更新資料
            DB::table('OnDutyShiftPeriod')
                ->where('doctorID', $id)
                ->where('periodSerial', $periodSerial)
                ->update(['shifts' => $shifts]);
        }
    }
    
    // 取得所有醫生的所有時段記錄 order by doctor ID
    public function getAllShifts() {
        $data = DB::table('OnDutyShiftPeriod')
            ->orderBy('doctorID', 'asc')
            ->get();
        
        return $data;
    }
    
    // 查詢 單一醫生指定時段的班數
    public function getShiftInfo($id, $periodSerial) {
        $data = DB::table('OnDutyShiftPeriod')
            ->where('doctorID', $id)
            ->where('periodSerial', $periodSerial)
            ->first();
        
        return $data;
    }
    
    // 查詢 單一醫生所有時段班數
    public function getShiftsByID($id) {
        $data = DB::table('OnDutyShiftPeriod')
            ->where('doctorID', $id)
            ->get();
        
        return $data;
    }
    
    // 查詢 所有醫生指定時段的班數
    public function getShiftsBySerial($periodSerial) {
        $data = DB::table('OnDutyShiftPeriod')
            ->where('periodSerial', $periodSerial)
            ->orderBy('doctorID')
            ->get();
        
        return $data;
    }
    
    // 刪除 暫不實作
}
