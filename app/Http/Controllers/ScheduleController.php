<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\Schedule;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;




use App\User;

// import the model

class ScheduleController extends Controller
{
    //查看全部班表
    public function schedule() {
        $schedule = new schedule();
        $scheduleData = $schedule->scheduleList();
       
         return view('schedule', array('schedule' => $scheduleData));
    }

    //單一月份班表資訊
      public function getScheduleByID() {

         $schedule = new Schedule();
         $scheduleData = $schedule->getScheduleByID();

        return view('getScheduleByID', array('schedule' => $scheduleData));
      }

    //新增班表
    public function addSchedule(){
    		$addSchedule = new Schedule();
            $doctorID = Input::get('doctorID');
            $periodSerial = Input::get('periodSerial');
    		$isWeekday = Input::get('isWeekday');
    		$location = Input::get('location');
    		$category = Input::get('category');
    		$date = Input::get('date');
            $confirmed = Input::get('confirmed');
    		$newscheduleID = $addSchedule->addSchedule($doctorID, $periodSerial, $isWeekday, $location, $category, $date, $confirmed);

    		 return redirect('schedule'); 

    }
    
     public function deleteSchedule($id){
       		$deleteschedule= DB::table('Schedule')->where('scheduleID',$id)->delete();
       
            return redirect('schedule'); 
     		
        }
       
    //更新班表
    public function updateSchedule(){
        $serial = Input::get('serial');
        $updateSchedule = new schedule();
        $doctorID = Input::get('doctorID');
        $periodSerial = Input::get('periodSerial');
        $isWeekday = Input::get('isWeekday');
        $location = Input::get('location');
        $category = Input::get('category');
        $date = Input::get('date');
        $confirmed = Input::get('confirmed');
        $update = $updateSchedule->updateSchedule($doctorID, $periodSerial, $isWeekday, $location, $category, $date, $confirmed);
        
        return redirect('reservation');
       	
    }
    
}