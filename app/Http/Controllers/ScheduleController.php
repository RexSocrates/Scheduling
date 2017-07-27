<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

// send a request
use GuzzleHttp\Client;


use App\User;
use App\ScheduleCategory;
use App\ShiftRecords;
use App\Schedule;

class ScheduleController extends Controller
{
    //查看初版全部班表 所有醫生換班紀錄
    public function firstSchedule() {
        $schedule = new Schedule();
        $user = new User();
        $shiftRecords = new ShiftRecords(); 
        $scheduleData = $schedule->getSchedule();

        $currentDoctor = $user->getCurrentUserInfo();

        foreach ($scheduleData as $data) {
            $doctorName = $user->getDoctorInfoByID($data->doctorID);
            $data->doctorID = $doctorName->name;
        }

        $data = $shiftRecords->getMoreShiftsRecordsInformation(false);

        $currentDoctorSchedule=$schedule->getScheduleByCurrentDoctorID();

        $doctorName = $user->getDoctorInfoByID(2);
        $doctorSchedule = $schedule->getScheduleByDoctorID(2); //之後用ajax傳入id
        
        return view('pages.first-edition-all', array('schedule' => $scheduleData,'shiftRecords'=>$data,'currentDoctor'=>$currentDoctor,'currentDoctorSchedule'=>$currentDoctorSchedule,'doctorName'=>$doctorName ,'doctorSchedule'=>$doctorSchedule));
    }

     //查看正式全部班表 
    public function schedule() {
        $schedule = new Schedule();
        $user = new User();
        $shiftRecords = new ShiftRecords(); 
        $scheduleData = $schedule->getSchedule();

        foreach ($scheduleData as $data) {
            $doctorName = $user->getDoctorInfoByID($data->doctorID);
            $data->doctorID = $doctorName->name;
        }

        $data = $shiftRecords->getMoreShiftsRecordsInformation(false);

        
        return view('pages.schedule-all', array('schedule' => $scheduleData,'shiftRecords'=>$data));
    }
    // 初版班表 個人
    public function firstEditionSchedule() {
        $schedule = new Schedule();
         $scheduleCategory = new ScheduleCategory();
         $user = new User();

         $scheduleData = $schedule->getScheduleByDoctorID($user->getCurrentUserID());

         foreach ($scheduleData as $data) {
            $scheduleName = $scheduleCategory->findScheduleName($data->schCategorySerial);
            $data->schCategorySerial =  $scheduleName;
        }

        
        return view('pages.first-edition', array('schedule' => $scheduleData,'shiftRecords'=>$data));
    }

    //單一月份班表資訊
      public function getScheduleByID() {

         $schedule = new Schedule();
         $scheduleData = $schedule->getScheduleByID();

        return view('getScheduleByID', array('schedule' => $scheduleData));
      }

    //查看 單一醫生班表
      public function getScheduleByDoctorID() {

         $schedule = new Schedule();
         $scheduleCategory = new ScheduleCategory();
         $user = new User();

         $scheduleData = $schedule->getScheduleByDoctorID($user->getCurrentUserID());

         foreach ($scheduleData as $data) {
            $scheduleName = $scheduleCategory->findScheduleName($data->schCategorySerial);
            $data->schCategorySerial =  $scheduleName;
        }

        return view('pages.schedule', array('schedule' => $scheduleData));
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