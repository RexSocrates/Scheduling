<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class ShiftsPerMonth extends Model
{
    //
    protected $table = 'ShiftsPerMonth';
    
    // 取得指定醫生單月的各個班數
    public function getShiftsWithDoctorID($id) {
        $shifts = DB::table('ShiftsPerMonth')
            ->where('doctorID', $id)
            // 需測試日期印出的格式
//            ->where('date', Carbon::now());
            ->get();
        
        return shifts;
    }
}
