<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

use App\User;
use App\ScheduleCategory;
use App\ShiftRecords;
use App\Schedule;


class ScheduleController extends Controller
{
    //查看初版全部班表 
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

        $currentDoctorSchedule=$schedule->getScheduleByCurrentDoctorID();

        
        return view('pages.first-edition-all', array('schedule' => $scheduleData));
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

       // $data = $shiftRecords->getMoreCheckShiftsRecordsInformation(false); 

        
        return view('pages.schedule-all', array('schedule' => $scheduleData));
    }
    // 初版班表 個人
    public function firstEditionSchedule() {
        $schedule = new Schedule();
        $scheduleCategory = new ScheduleCategory();
        $user = new User();

        $scheduleData = $schedule->getScheduleByDoctorID($user->getCurrentUserID());
        
        $displayData = [];

        foreach ($scheduleData as $data) {
            $singleData = [
                'date' => $data->date,
                'endDate' => $data->endDate,
                'categoryName' => $scheduleCategory->findScheduleName($data->schCategorySerial)
            ];
            
            array_push($displayData, $singleData);
        }

        
        return view('pages.first-edition', [
            'schedule' => $displayData
        ]);
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
    public function addSchedule(Request $request){
        $data = $request->all();
        
        $doctorID = $data['id'];
        $startDate = $data['date'];
        $categoryID = $data['classification'];
        
        
        $scheduleCategory = new ScheduleCategory();
        
        $categoryInfo = $scheduleCategory->getSchCategoryInfo($categoryID);

        $schInfo = [
              'doctorID' =>$doctorID,
              'schCategorySerial'=>$categoryID,
              'isWeekday' => true,
              'location' => $categoryInfo,
              'date' => $startDate,
              'confirmed'=>1
            ];

        $weekDay = (int)date('N', strtotime($startDate));

        if($weekDay == 6 || $weekDay == 7){
          $schInfo['isWeekday'] = false;
        }

        $schedule = new Schedule();
        $schedule->addSchedule($schInfo);
        
    }
    
    // 刪除預班
    public function deleteReservation(Request $request){
        $data = $request->all();
        
        $docAndRes = new DoctorAndReservation();
        $userObj = new User();
        
        $docAndRes->deleteReservation($data['resSerial'], $userObj->getCurrentUserID());
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

    public function getDoctorInfoByScheduleID(Request $request){

      $data = $request->all();
      $schedule = new Schedule();
      $user = new User();
      $doctor = $schedule->getScheduleDataByID($data['id']);
     
      $id = $doctor->scheduleID;
      $name = $user->getDoctorInfoByID($doctor->doctorID)->name;
      $date = $doctor->date;
      $array = array($id,$name,$date);
      return $array;
      
    }
    public function getDoctorInfoByScheduleIDWhenExchange(Request $request){
      $data = $request->all();

      $schedule = new Schedule();
      $user = new User();

      $doctor = $schedule->getScheduleDataByID($data['id']);
      $doctor2 = $schedule->getScheduleDataByID($data['id2']);

      $name = $user->getDoctorInfoByID($doctor->doctorID)->name;
      $date = $doctor->date;

      $name2 = $user->getDoctorInfoByID($doctor2->doctorID)->name;
      $date2 = $doctor2->date;

      $array = array($name,$date,$name2,$date2);

      return $array;
      
    }
    // 從scheduler 傳回資料後將日期的字串分解
    private function processDateStr($dateStr) {
        $dateArr = explode(' ', $dateStr);
        
        // 判斷月份
        $month = '00';
        switch($dateArr[1]) {
            case 'Jan' :
                $month = '01';
                break;
            case 'Feb' :
                $month = '02';
                break;
            case 'Mar' :
                $month = '03';
                break;
            case 'Apr' :
                $month = '04';
                break;
            case 'May' :
                $month = '05';
                break;
            case 'Jun' :
                $month = '06';
                break;
            case 'Jul' :
                $month = '07';
                break;
            case 'Aug' :
                $month = '08';
                break;
            case 'Sep' :
                $month = '09';
                break;
            case 'Oct' :
                $month = '10';
                break;
            case 'Nov' :
                $month = '11';
                break;
            case 'Dec' :
                $month = '12';
                break;
        }
        
        $day = $dateArr[2];
        $year = $dateArr[3];
        
        return $year.'-'.$month.'-'.$day;
    }
    
}