<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class DoctorAndReservation extends Model

{
    //
    protected $table = 'DoctorAndReservation';

    //醫生新增預班
    public function addDoctor($resSerial){
    	 $generatedSerial = DB::table('DoctorAndReservation')-> insert([
                    'resSerial' => $resSerial,
    				'doctorID' => '1',
    	]);
    }

    //更新醫生預班資訊
    public function doctorUpdateReservation($oldResSerial,$newResSerial){
    		 DB::table('DoctorAndReservation')
                ->where('resSerial', $oldResSerial)
                ->where('doctorID',"1")
                ->update(['resSerial' => $newResSerial]);

    }
    
    //查詢 單一時段上班的醫生
    public function getDoctorsByResSerial($serial) {
        $doctors = DB::table('DoctorAndReservation')
            ->where('resSerial', $serial)
            ->get();

        return $doctors;
    }

    //查詢 單一時段上班醫生總數
    public function amountInResserial($serial){
        $count = DB::table('DoctorAndReservation')
                ->where('resSerial', $serial)
                ->count();
        return $count;

    }
    //查詢 單一醫生預班的總班數
    public function amountInDoctorReservation(){
        $count = DB::table('DoctorAndReservation')
        ->where('doctorID','1')
        ->count();

        return $count;
    }        
}
