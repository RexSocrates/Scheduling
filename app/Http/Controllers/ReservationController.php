<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\Reservation;
use App\DoctorAndReservation;
use App\ShiftCategory;
use App\Remark;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Dhtmlx\Connector\SchedulerConnector;

use App\User;

// import the model

class ReservationController extends Controller
{
    //查看全部醫師預班班表
    public function reservation() {
        $reservation = new Reservation();
        $doctorName = new User();
        $doctorID = new DoctorAndReservation();
        $reservationData = $reservation->reservationList();
        $resSerial = array();
        foreach ($reservationData as $res) {
          $id = $doctorID->getDoctorsByResSerial($res->resSerial);
            $names  =  array();
                foreach ($id as $personalID) {
                     $doctor = $doctorName->getDoctorInfoByID($personalID->doctorID); 
                     array_push($names, $doctor);
                }     
            array_push($resSerial,array($res,$names));
               // echo $doctor->name;
        }   
        // foreach ($resSerial as $res) {
        //      echo $res[0]->resSerial.'<br>';

        //      foreach($res[1] as $doctor) {
        //         echo $doctor->name.'<br>';
        //      }
        //      echo '<br>';

        // }
       
        return view('pages.reservation-all', array('reservations' => $resSerial));
         //return view('pages.reservation-all', array('reservations' => $reservationData ,'doctors'=> $doctor));
    }

    //為了做查看醫生而做的
     public function showReservation() {
        $reservation = new Reservation();
        $reservationData = $reservation->reservationList();
       
        return view('showReservation', array('reservations' => $reservationData));
    }

    //單一醫生預班資訊 計算尚須上的白夜班 
      public function getReservationByID() {

        $reservation = new Reservation();
        $shiftCategory = new ShiftCategory();
        $user = new User();

        $data = array();

        $reservationData = $reservation->getReservationByID();
        $doctorID = $user->getCurrentUserID();
        $doctorDay = $user->getDoctorInfoByID($doctorID)->mustOnDutyDayShifts;
        $doctorNight = $user->getDoctorInfoByID($doctorID)->mustOnDutyNightShifts;        
        $countDay = $doctorDay-$reservation->amountDayShifts();
        $countNight = $doctorNight-$reservation->amountNightShifts();

        foreach ($reservationData as $res) {
            $name = $shiftCategory->findName($res->categorySerial);
            //$res->categorySerial = $name;
            array_push($data, array($res, $name));
        }

        
        $connector = new SchedulerConnector(null, "PHPLaravel");    
        $connector->configure(new Reservation(),"resSerial","periodSerial,isWeekday,location,isOn,date, endDate,remark,categorySerial");
       // $connector->render_sql("insert into Reservation",'resSerial','date,endDate,categorySerial');
                                         
        //$connector->render();                                       
                
      return view('pages.reservation', array('reservations' => $data,'countDay' => $countDay,
                'countNight' => $countNight ,'doctorDay' =>$doctorDay, 'doctorNight'=> $doctorNight ));
       
      }
    //增加備註
    public  function addRemark(){
        $remark = new Remark();
        $user = new User();
        $doctorID = $user->getCurrentUserID();
        $addRemark = Input::get('remark');
        $remarkData = $remark->addremark($doctorID,$addRemark);

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

    public function getdateAdd(){
        $res = new Reservation();
        $res->date_add();
       
    }
    
    
}
