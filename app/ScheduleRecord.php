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

    public function getScheduleBydoctorID($doctorID){

    	 $data = DB::table('ScheduleRecord')
    	 	->where('doctorID',$doctorID)
    	 	->get();
		
		return $data;
    }


}
