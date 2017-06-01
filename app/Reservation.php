<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;
class Reservation extends Model
{
    protected $table = 'Reservation';

     public function reservationList()
    {
    	$reservation = DB::table('Reservation')->get();

    	return $reservation;
    	# code...
    }
    
    public function addReservation($isWeekday, $location, $isOn, $remark, $date){

    	$newResSerial = DB::table('Reservation')-> insertGetId([
    				'isWeekday' => $isWeekday,
    				'location' => $location,
    				'isOn' => $isOn,
    				'remark' => $remark,
    				'date' => $date
    		]);

    		return $newResSerial;
    }
    public function updateReservation($id,$isWeekday, $location, $isOn, $remark, $date){

            $resSerial = DB::table('Reservation')->get()->where('resSerial',$id)->update();
                   

            return $resSerial;
    }
    
   }
