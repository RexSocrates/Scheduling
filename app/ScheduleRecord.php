<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class ScheduleRecord extends Model
{
    //
    public function addScheduleRecord($doctorID,$shiftHours){

    	 DB::table('ScheduleRecord')->insert([
            'doctorID' => $doctorID,
            'shiftHours' => $shiftHours,
            'month' => date('Y-m')
        ]);

    }

    public function getScheduleTotoalBydoctorID($doctorID){

    	 $data = DB::table('ScheduleRecord')
    	 	->where('doctorID',$doctorID)
    	 	->sum('shiftHours');
		
		return $data;
    }


}
