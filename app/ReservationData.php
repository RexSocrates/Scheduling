<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class ReservationData extends Model
{


    // 透過ID更新時間
    public function updateDate($month,$startDate,$endDate) {
        $affectedRows = DB::table('ReservationData')
            ->where('month', $month)
            ->update([
                'startDate' =>$startDate,
                'endDate' => $endDate,
                'status'=>1
            ]);
        
        return $affectedRows;
    }

    // 新增一筆時間資料
    public function addDate($month,$startDate,$endDate) {
        DB::table('ReservationData')->insert([
            'month' => $month,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'status'=>1
        ]);
    }
    
    public function countMonth($month) {
        $count=DB::table('ReservationData')
            ->where('month',$month)
            ->count();
        
        return $count;  
        
    }

    // month 格式範例 : 2017-09
    public function getDate($month) {
        $date = DB::table('ReservationData')
            ->where('month',$month)
            ->first();
        
        return $date;
    }

    public function setFirstScheduleAnnounceStatus(){
        $month=date('Y-m');

        $affectedRows = DB::table('ReservationData')
            ->where('month', $month)
            ->update([
                'status'=>2
            ]);
        return $affectedRows;
    }

    public function setScheduleAnnounceStatus(){
        $month=date('Y-m');
        $affectedRows = DB::table('ReservationData')
            ->where('month', $month)
            ->update([
                'status'=>3
            ]);
        return $affectedRows;
    }


    public function getStatus($month){

        $status = DB::table('ReservationData')
            ->where('month', $month)
            ->first();

        return $status;
    }
}
