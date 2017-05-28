<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class ShiftPeriodPerMonth extends Model
{
    //
    protected $table = 'ShiftPeriodPerMonth';
    
    // 取得所有醫師過去的每月應上班數
    public function getHistoricalShifts() {
        $shifts = DB::table('ShiftPeriodPerMonth')->get();
        
        return $shifts;
    }
    
    // 取得所有醫師當月應上班數
    public function getCurrentMonthShifts() {
        $currentMonth = date('Y-m');
        
        $shifts = DB::table('ShiftPeriodPerMonth')
            ->where('date', $currentMonth)
            ->get();
        
        return $shifts;
    }
    
    // 取出單一醫生的過去每個月的歷史紀錄
    public function getHistoricalShiftsByDoctorID($id) {
        $shifts = DB::table('ShiftPeriodPerMonth')
            ->where('doctorID', $id)
            ->get();
        
        return $shifts;
    }
    
    
    // 取出單一醫生當月各時段上班數
    public function getCurrentMonthShiftsByDoctorID($id) {
        $currentMonth = date('Y-m');
        
        $shifts = DB::table('ShiftPeriodPerMonth')
            ->where('doctorID', $id)
            ->where('date')
            ->get();
        
        return $shifts;
    }
    
    // 新增一位醫師當月的單一時段上班時數
    public function addShifts($id, $periodSerial, $date, $shifts) {
        DB::table('ShiftPeriodPerMonth')->insert([
            'doctorID' => $id,
            'periodSerial' => $periodSerial,
            'date' => $date,
            'shifts' => $shifts
        ]);
    }
}
