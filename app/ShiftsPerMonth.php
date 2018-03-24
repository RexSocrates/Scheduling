<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class ShiftsPerMonth extends Model
{
    //
    protected $table = 'ShiftsPerMonth';
    
    
    // 取得所有醫生當月各班數
    public function getCurrentMonthShifts() {
        $currentMonth = date('Y-m');
        
        $shifts = DB::table('ShiftsPerMonth')
            ->where('date', $currentMonth);
            ->get();
        
        return $shifts;
    }
    
    // 取得單一醫生過去每個月各班數
    public function getShiftsByID($id) {
        $shifts = DB::table('ShiftsPerMonth')
            ->where('doctorID', $id)
            ->get();
        
        return $shifts;
    }
    
    
    // 取得指定醫生當月的各個班數
    public function getShiftsByDoctorID($id) {
        $currentMonth = date('Y-m');
        
        $shifts = DB::table('ShiftsPerMonth')
            ->where('doctorID', $id)
            ->where('date', $currentMonth);
            ->first();
        
        return $shifts;
    }
    
    // 取得當月所有醫師的各項班數
    public function getCurrentMonthShifts() {
        $currentMonth = date('Y-m')
            
        $shifts = DB::table('ShiftsPerMonth')
            ->where('date', $currentMonth)
            ->orderBy('doctorID')
            ->get();
        
        return $shifts;
    }
}
