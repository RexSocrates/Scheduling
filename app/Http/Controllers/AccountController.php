<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\Reservation;
use App\DoctorAndReservation;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

use App\User;

// import the model

class AccountController extends Controller
{
    //查看全部醫師預班班表
    public function reservation() {
        $reservation = new Reservation();
        $reservationData = $reservation->reservationList();
       
        return view('reservation', array('reservations' => $reservationData));
    }

    //為了做查看醫生而做的
     public function showReservation() {
        $reservation = new Reservation();
        $reservationData = $reservation->reservationList();
       
        return view('showReservation', array('reservations' => $reservationData));
    }

    //單一醫生預班資訊
      public function getReservationByID() {

         $reservation = new Reservation();
         $reservationData = $reservation->getReservationByID();

        return view('getReservationByID', array('reservations' => $reservationData));
      }


     //查詢 所有醫生指定時段的班數
     public function getDataByResSerial() {
        $serial = Input::get('serial');
        $dAndR = new DoctorAndReservation();
        $doctors = $dAndR->getDoctorsByResSerial($serial);

        return view('getReseverationByPeriodSerial', ['doctors' => $doctors]);
    }

    //查詢 單一時段上班醫生總數
    public function amountInResserial(){
        $serial = Input::get('serial');
        $dAndR = new DoctorAndReservation();
        $count = $dAndR ->amountInResserial($serial);
        echo $count;
    }

    //新增預班
    public function addReservation(){
    	$addReservation = new Reservation();
        $addDoctor = new DoctorAndReservation();
        $periodSerial = Input::get('periodSerial');
    	$isWeekday = Input::get('isWeekday');
    	$location = Input::get('location');
    	$isOn = Input::get('isOn');
    	$remark = Input::get('remark');
    	$date = Input::get('date');
        $doctorID = Input::get('doctorID');
           
    	$newResSerial = $addReservation->addReservation($periodSerial,$isWeekday,$location,$isOn,$remark,$date,$doctorID);
        $addDoctorToTable = $addDoctor->addDoctor($newResSerial); //醫生id

    	return redirect('reservation'); 

    }
    
     public function deleteReservation($id){
       	$deletereservation= DB::table('Reservation')->where('resSerial',$id)->delete();
       
        return redirect('reservation'); 
     		
    }
    
    //更新預班
    public function updateReservation(){
        $serial = Input::get('serial');
       	$updateReservation = new Reservation();
        $updateDoctorReservation = new DoctorAndReservation();
        $periodSerial = Input::get('periodSerial');
        $isWeekday = Input::get('isWeekday');
        $location = Input::get('location');
        $isOn = Input::get('isOn');
        $remark = Input::get('remark');
        $date = Input::get('date');
        $update = $updateReservation->updateReservation($serial,$periodSerial,$isWeekday,$location,$isOn,$remark,$date);
        $updateDoctorReservationToTable = $updateDoctorReservation->doctorUpdateReservation($serial,$update);

        return redirect('reservation');
    }

    public function getDataByID() {
        $serial = Input::geT('serial');
        return view('updateReservation', ['serial' => $serial] );

    }

    
    
}
