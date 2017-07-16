<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use DB;

class Period extends Model
{
	protected $table = 'Period';

    //查看 班表資訊
	public function PeriodList()
	{
		$period = DB::table('Period')->get();

		return $period;
	}

 //    //查看 新增班表
	// public function addSchedule($isWeekday, $location, $category, $date, $confirmed){
 //        $generatedSerial = 0;

 //        $count = DB::table("Schedule")
 //            -> where('doctorID',$doctorID) 
 //            -> where('periodSerial',$periodSerial) 
 //            -> where('isWeekday',$isWeekday)
 //            -> where('location',$location) 
 //            -> where('category',$category)
 //            -> where('date',$date)
 //            -> where('confirmed',$confirmed)
 //            ->count();
 //        if($count==0){
 //        //新增預班
 //                $generatedSerial = DB::table('Schedule')-> insertGetId([
 //                'doctorID' => $doctorID,
 //                'periodSerial' => $periodSerial,
 //                'isWeekday' => $isWeekday,
 //                'location' => $location,
 //                'category' => $category,
 //                'date' => $date, 
 //                'confirmed' => $confirmed      
 //            ]);
 //        }
 //        else{
 //            //得到預班表id
 //                $generatedSerial = DB::table("Schedule")
 //                -> where('doctorID',$doctorID)
 //                -> where('periodSerial',$periodSerial) 
 //                -> where('isWeekday',$isWeekday)
 //                -> where('location',$location) 
 //                -> where('category',$category)
 //                -> where('date',$date)
 //                -> where('confirmed',$confirmed)
 //                -> value('scheduleID');
 //        }

 //    	return $generatedSerial;
 //    }

    // public function updateSchedule($scheduleID, $doctorID,$isWeekday, $location, $category, $date, $confirmed){

    //     $generatedSerial ＝ 0;

    //     $count = DB::table("Schedule")
    //             -> where('doctorID',$doctorID)
    //             -> where('periodSerial',$periodSerial) 
    //             -> where('isWeekday',$isWeekday)
    //             -> where('location',$location) 
    //             -> where('category',$category)
    //             -> where('date',$date)
    //             -> where('confirmed',$confirmed)
    //             ->count();
    //         if($count==0){
    //             //新增班表
    //             $generatedSerial = DB::table('Schedule')-> insertGetId([
    //             'doctorID' => $doctorID,
    //             'periodSerial' => $periodSerial,
    //             'isWeekday' => $isWeekday,
    //             'location' => $location,
    //             'category' => $category,
    //             'date' => $date, 
    //             'confirmed' => $confirmed  
                    
    //         ]);

    //         }
               
    //         else{
    //             //取得班表id
    //             $generatedSerial = DB::table("Schedule")
    //             -> where('doctorID',$doctorID)
    //             -> where('periodSerial',$periodSerial) 
    //             -> where('isWeekday',$isWeekday)
    //             -> where('location',$location) 
    //             -> where('category',$category)
    //             -> where('date',$date)
    //             -> where('confirmed',$confirmed)
    //             -> value('scheduleID');
    //         }
    //     return $generatedSerial;
    // }

    // public function deleteSchedule($scheduleID){
    //     $generatedSerial = DB::table("Schedule")
    //     $generatedSerial = DB::where('scheduleID','==',  scheduleID) -> delete()

    //     return $generatedSerial;
    // }
}