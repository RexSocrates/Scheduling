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

    
}
