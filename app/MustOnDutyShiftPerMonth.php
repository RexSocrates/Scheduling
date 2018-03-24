<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class MustOnDutyShiftPerMonth extends Model
{
    //

    public function updateOnDutyShift(array $data)
    {
        DB::table('MustOnDutyShiftPerMonth')
            ->where('doctorID', $data['doctorID'])
            ->where('month',$data['month'])
            ->update([
                'mustOnDutyShift' => $data['updateMustOnDutyShift'] 
        ]);
    }

    public function addOnDutyShift(array $data) {
 
        DB::table('MustOnDutyShiftPerMonth')->insertGetId([
            'doctorID' => $data['doctorID'],
            'month' => $data['leaveMonth'],
            'mustOnDutyShift' => $data['mustOnDutyShift']   
        ]);
        
    }

    public function countOnDutyShift(array $data)
    {
        $count=DB::table('MustOnDutyShiftPerMonth')
            ->where('doctorID', $data['doctorID'])
            ->where('month',$data['leaveMonth'])
            ->count();
        return $count;
    }

    public function getOnDutyShift(array $data)
    {
        $info=DB::table('MustOnDutyShiftPerMonth')
            ->where('doctorID', $data['doctorID'])
            ->where('month',$data['leaveMonth'])
            ->first();

        return $info;
    }

    // 取得醫生在排班月份請的公假(包含將公假時數轉換為班數)
    public function getResMonthLeaveShift($doctorID) {
        // 取得排班月的時間
        $resMonthStr = date('Y-m', strtotime(date('Y-m').'+1 month'));
        
//        echo 'Res month str : '.$resMonthStr.'<br>';
        
        $info = DB::table('MustOnDutyShiftPerMonth')
            ->where('doctorID', $doctorID)
            ->where('month', $resMonthStr)
            ->get();
        
        $leaveHours = 0;
        
        if(count($info) > 0) {
            // 這個醫生使用了公假時數，取得申請的時數
            $leaveHours = $info[0]->mustOnDutyShift;
        }
        
        return ($leaveHours / 12);
        
    }
}
