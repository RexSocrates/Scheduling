<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class ScheduleRecord extends Model
{
    //
    public function addScheduleRecord($doctorID,$shiftHours){

        
        $date=date("Y-m", strtotime('-1 month')); //上個月的時間

    	 DB::table('ScheduleRecord')->insert([
            'doctorID' => $doctorID,
            'shiftHours' => $shiftHours,
            'month' => $date
        ]);

    }

    //醫生積欠班數
    public function getScheduleTotoalBydoctorID($doctorID){

        $currentMonth= date("Y-m");
        $currentYear = date('Y');

        if($currentMonth <= ($currentYear.'-06')){
            $date = ($currentYear.'-01');
        }
        if($currentMonth >= ($currentYear.'-06')){
            $date = ($currentYear.'-07');
        }
    	 $data = DB::table('ScheduleRecord')
    	 	->where('doctorID',$doctorID)
            ->whereBetween('month', [$date, $currentMonth])
    	 	->sum('shiftHours');
		
		return $data;
    }

    //醫生積欠班數
    public function getScheduleRecord(){

        $currentMonth= date("Y-m");
        $currentYear = date('Y');

        if($currentMonth <= ($currentYear.'-06')){
            $date = ($currentYear.'-01');
        }
        if($currentMonth >= ($currentYear.'-06')){
            $date = ($currentYear.'-07');
        }
         $data = DB::table('ScheduleRecord')
            ->whereBetween('month', [$date, $currentMonth])
            ->get();
        
        return $data;
    }

 //查詢單一醫生積欠班數
    public function getScheduleRecordByDoctorID($doctorID){

        $currentMonth= date("Y-m");
        $currentYear = date('Y');

        if($currentMonth <= ($currentYear.'-06')){
            $date = ($currentYear.'-01');
        }
        if($currentMonth >= ($currentYear.'-06')){
            $date = ($currentYear.'-07');
        }

         $data = DB::table('ScheduleRecord')
            ->whereBetween('month', [$date, $currentMonth])
            ->where('doctorID',$doctorID)
            
            ->get();
        
        return $data;
    }

    //查詢 單一醫生全部積欠班數
    public function getAllScheduleRecordByDoctorID($doctorID){

         $data = DB::table('ScheduleRecord')
            ->where('doctorID',$doctorID)
            ->get();
        
        return $data;
    }


}
