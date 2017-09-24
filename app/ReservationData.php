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
                'endDate' => $endDate   
            ]);
        
        return $affectedRows;
    }

    // 新增一筆時間資料
    public function addDate($month,$startDate,$endDate) {
        DB::table('ReservationData')->insert([
            'month' => $month,
            'startDate' => $startDate,
            'endDate' => $endDate,
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
}
