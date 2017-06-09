<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class DoctorAndReservation extends Model

{
    //
    protected $table = 'DoctorAndReservation';

    public function addDoctor($resSerial){
    	 $generatedSerial = DB::table('DoctorAndReservation')-> insert([
                    'resSerial' => $resSerial,
    				'doctorID' => '1',
    	]);
    }

    public function doctorUpdateReservation($oldResSerial,$newResSerial){
    		 DB::table('DoctorAndReservation')
                ->where('resSerial', $oldResSerial)
                ->where('doctorID',"1")
                ->update(['resSerial' => $newResSerial]);

    }
    
}
