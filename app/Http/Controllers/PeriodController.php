<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\Perior;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;




use App\User;

// import the model

class PeriorController extends Controller
{
    //查看全部上班時段
    public function perior() {
        $perior = new perior();
        $periorData = $perior->periorList();
       
         return view('perior', array('perior' => $periorData));
    }

    //單一上班時段
      public function getPeriorByID() {

         $perior = new perior();
         $periorData = $perior->getPeriorByID();

        return view('getPeriorByID', array('perior' => $periorData));
      }

    // //新增班表
    // public function addSchedule(){
    // 		$addSchedule = new Schedule();
    //         $doctorID = Input::get('doctorID');
    //         $periodSerial = Input::get('periodSerial');
    // 		$isWeekday = Input::get('isWeekday');
    // 		$location = Input::get('location');
    // 		$category = Input::get('category');
    // 		$date = Input::get('date');
    //         $confirmed = Input::get('confirmed');
    // 		$newscheduleID = $addSchedule->addSchedule($doctorID, $periodSerial, $isWeekday, $location, $category, $date, $confirmed);

    // 		 return redirect('schedule'); 

    // }
    
    //  public function deleteReservation($id){
    //    		$deletereservation= DB::table('Reservation')->where('scheduleID',$id)->delete();
       
    //         return redirect('reservation'); 
     		
    //     }
       
    // //更新班表
    // public function updateSchedule(){
    //     $serial = Input::get('serial');
    //     $updateSchedule = new schedule();
    //     $doctorID = Input::get('doctorID');
    //     $periodSerial = Input::get('periodSerial');
    //     $isWeekday = Input::get('isWeekday');
    //     $location = Input::get('location');
    //     $category = Input::get('category');
    //     $date = Input::get('date');
    //     $confirmed = Input::get('confirmed');
    //     $update = $updateSchedule->updateSchedule($doctorID, $periodSerial, $isWeekday, $location, $category, $date, $confirmed);
        
    //     return redirect('reservation');
       	
    // }
    
}