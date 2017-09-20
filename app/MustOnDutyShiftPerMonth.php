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
                'mustOnDutyShift' => $data['mustOnDutyShift'] 
            ]);
    }

     public function addOnDutyShift(array $data) {
 
          	DB::table('MustOnDutyShiftPerMonth')->insertGetId([
            'doctorID' => $data['doctorID'],
            'month' => $data['month'],
            'mustOnDutyShift' => $data['mustOnDutyShift']   
        ]);
        
    }

    public function countOnDutyShift(array $data)
    {
        	$count=DB::table('MustOnDutyShiftPerMonth')
            ->where('doctorID', $data['doctorID'])
            ->where('month',$data['month'])
            ->count();
            return $count;
    }

    
}
