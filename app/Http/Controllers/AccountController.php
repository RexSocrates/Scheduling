<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\Reservation;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;




use App\User;

// import the model

class AccountController extends Controller
{
    //
    public function reservation() {
        $reservation = new Reservation();
        $reservationData = $reservation->reservationList();
       
         return view('reservation', array('reservations' => $reservationData));
    }

    public function addReservation(){
    		$addReservation = new Reservation();
    		$isWeekday = Input::get('isWeekday');
    		$location = Input::get('location');
    		$isOn = Input::get('isOn');
    		$remark = Input::get('remark');
    		$date = Input::get('date');

    		$newResSerial = $addReservation->addReservation($isWeekday,$location,$isOn,$remark,$date);

    		 return redirect('reservation'); 

    }
    
     public function deleteReservation($id){
       		$deletereservation= DB::table('Reservation')->where('resSerial',$id)->delete();
       
            return redirect('reservation'); 
     		
        }
       

    public function updateReservation(Request $request,$id){
       		//$updatereservation=DB::table('Reservation')->where('resSerial',$id);
         

    }
    
}
