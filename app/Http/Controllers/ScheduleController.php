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
use App\ReservationData;
use App\MustOnDutyShiftPerMonth;
use App\Announcement;
use App\Reservation;

use App\Jobs\SendDeleteShiftMail;
use App\Jobs\SendNewShiftAssignmentMail;
use App\Jobs\SendShiftExchangeMail;
class ScheduleController extends Controller
{
    //查看初版全部班表 
    public function firstSchedule() {
        $schedule = new Schedule();
        $user = new User();
        $shiftRecords = new ShiftRecords(); 
        $scheduleData = $schedule->getFirstSchedule();
        $currentDoctor = $user->getCurrentUserInfo();
        foreach ($scheduleData as $data) {
            $doctorName = $user->getDoctorInfoByID($data->doctorID);
            $data->doctorID = $doctorName->name;
        }
        $currentDoctorSchedule=$schedule->getScheduleByCurrentDoctorID();

        $doctorName = $user->getAtWorkDoctors();

        
        return view('pages.first-edition-all', array('schedule' => $scheduleData , 'doctorName'=>$doctorName));
    }
    
    //初版班表 指定一人 (Ben)
    public function firstEditionAllPersonal() {
        
        return view('pages.first-edition-all-personal');
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

        $doctor = $user->getAtWorkDoctors();
        
        return view('pages.schedule-all', array('schedule' => $scheduleData,'doctorName'=>$doctor));
    }
    
    //初版班表 查詢醫生
     public function firstEditionByDoctorID(Request $request) {
        $data = $request->all();
        $schedule = new Schedule();
        $user = new User();

        $scheduleData = $schedule->getFirstEditionScheduleByDoctorID($data['doctor']);

        foreach ($scheduleData as $data) {
            $doctorName = $user->getDoctorInfoByID($data->doctorID);
            $data->doctorID = $doctorName->name;
        }
        $doctor = $user->getAtWorkDoctors();
       
       
        return view('pages.first-edition-all-personal',array('scheduleData' => $scheduleData,
            'doctor'=> $doctorName, 'allDoctor'=>$doctor));
    }

    //  正式班表  查詢醫生
    public function schedulerPersonal(Request $request){
         $data = $request->all();
        $schedule = new Schedule();
        $user = new User();

        $scheduleData = $schedule->getScheduleByDoctorID($data['doctor']);

        foreach ($scheduleData as $data) {
            $doctorName = $user->getDoctorInfoByID($data->doctorID);
            $data->doctorID = $doctorName->name;
        }
        $doctor = $user->getAtWorkDoctors();
       
       
        return view('pages.schedule-all-personal',array('scheduleData' => $scheduleData,
            'doctor'=> $doctorName, 'allDoctor'=>$doctor));
    }

     //調整班表 初版班表 查詢醫生
    public function shiftFirstEditionByDoctorID(Request $request) {
        $data = $request->all();
        $schedule = new Schedule();
        $user = new User();

        $scheduleData = $schedule->getFirstEditionScheduleByDoctorID($data['doctor']);

        foreach ($scheduleData as $data) {
            $doctorName = $user->getDoctorInfoByID($data->doctorID);
            $data->doctorID = $doctorName->name;
        }
        $doctor = $user->getAtWorkDoctors();
       
       
        return view('pages.shift-first-edition-personal',array('scheduleData' => $scheduleData,
            'doctor'=> $doctorName, 'allDoctor'=>$doctor));
    }



    // 調整班表 正式班表  查詢醫生
    public function shiftSchedulerPersonal(Request $request){
         $data = $request->all();
        $schedule = new Schedule();
        $user = new User();

        $scheduleData = $schedule->getScheduleByDoctorID($data['doctor']);

        foreach ($scheduleData as $data) {
            $doctorName = $user->getDoctorInfoByID($data->doctorID);
            $data->doctorID = $doctorName->name;
        }
        $doctor = $user->getAtWorkDoctors();
       
       
        return view('pages.shift-scheduler-personal',array('scheduleData' => $scheduleData,
            'doctor'=> $doctorName, 'allDoctor'=>$doctor));
    }
    

    
    // 初版班表 個人
    public function firstEditionSchedule() {
        $schedule = new Schedule();
        $scheduleCategory = new ScheduleCategory();
        $user = new User();
        $scheduleData = $schedule->getFirstEditionScheduleByDoctorID($user->getCurrentUserID());
        
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
    //調整班表->新增班 驗證醫生id與off班
    public function confirmscheduleStatus(Request $request){
        $data = $request->all();
        $id = $data['id'];
        $date = $data['date'];
        $categoryID = $data['classification'];

        $schedule = new Schedule();
        $user = new User();
        $reservation = new Reservation();
        //$count = $schedule->checkDocStatus($id,$date);

        $countNight=0;
        if($schedule->getNightScheduleByDoctorIDandDate($id,$date) != 0 and ($categoryID==3 or $categoryID==4 or $categoryID==5 or $categoryID==6 or $categoryID==7 or $categoryID==8 or $categoryID==9 or $categoryID==10 or $categoryID==11 or $categoryID==12)){
            $countNight=1;
        }

        $infoArr=[];
        $info=[
            "doc"=>$user->getDoctorInfoByID($id)->name,
            "date"=>$data['date'],
            "countShedule"=>$schedule->checkDocStatus($id,$date),
            "countOff"=>$reservation->getResrvationByDateandDoctorID($id,$date),
            "countNight"=>$countNight
        ];
        array_push($infoArr,$info);
        
        return $infoArr;
    }
    //調整班表->更新班 驗證 班id
    public function confirmscheduleStatusBySerial(Request $request){
        $data = $request->all();
        $schedule = new Schedule();
        $user = new User();
        $reservation = new Reservation();

        $scheduleID = $data['scheduleID'];
        $date = $data['date']; //移動到哪一天
        $categoryID= $data['classification'];

        $dateStr = $this->processDateStr($date);
        $doctorID = $schedule->getScheduleDataByID($scheduleID)->doctorID;
        $dateInSchedule = $schedule->getScheduleDataByID($scheduleID)->date;
        $docName = $user->getDoctorInfoByID($doctorID)->name;
        $docWeekend = $schedule->checkDocScheduleInWeekend($doctorID);
        $count = $schedule->checkDocStatus($doctorID,$dateStr);
        $weekDay = (int)date('N', strtotime($dateStr));  //移動的
        $weekDayInSchedule = (int)date('N', strtotime($dateInSchedule));
        $countOff = $reservation->getResrvationByDateandDoctorID($doctorID,$dateStr);

        $countNight=0;
        if($schedule->getNightScheduleByDoctorIDandDate($doctorID,$dateStr) != 0 and ($categoryID==3 or $categoryID==4 or $categoryID==5 or $categoryID==6 or $categoryID==7 or $categoryID==8 or $categoryID==9 or $categoryID==10 or $categoryID==11 or $categoryID==12)){
            $countNight=1;
        }

        
        if($schedule->countScheduleDataByDateAndSessionID($dateStr,$categoryID)!=0){
            $scheduleSerial=$schedule->getScheduleDataByDateAndSessionID($dateStr,$categoryID)->scheduleID;
        }
        else{
            $scheduleSerial=0;
        }
        

        $dataArr = [];

        $info = [
            "count"=>$count,
            "docName"=>$docName,
            "docWeekend"=>$docWeekend,
            "weekDay"=>$weekDay,
            "date"=>$dateStr,
            'weekDayInSchedule' => $weekDayInSchedule,
            'dateInSchedule' =>$dateInSchedule,
            'scheduleID'=>$scheduleSerial,
            "countOff"=>$countOff,
            "countNight"=>$countNight
        ];

        array_push($dataArr,$info);

        return $dataArr;
        

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
              'confirmed'=>0
            ];
        $weekDay = (int)date('N', strtotime($startDate));
        if($weekDay == 6 || $weekDay == 7){
          $schInfo['isWeekday'] = false;
        }
        $schedule = new Schedule();
        $scheduleID=$schedule->addSchedule($schInfo);

        $job = new SendNewShiftAssignmentMail($doctorID,$scheduleID);

        dispatch($job);

        
    }
    
    // 刪除預班
    public function deleteReservation(Request $request){
        $data = $request->all();
        
        $docAndRes = new DoctorAndReservation();
        $userObj = new User();
        
        $docAndRes->deleteReservation($data['resSerial'], $userObj->getCurrentUserID());
    }

    //單一醫生的狀況
     public function checkDocScheduleByperson(Request $request){
        $data = $request->all();
        $schedule = new Schedule();
        $user = new User();

        $scheduleID = $data['scheduleID'];

        $doctorID = $schedule->getScheduleDataByID($scheduleID)->doctorID;
        $docWeekend = $schedule->checkDocScheduleInWeekend($doctorID);
        $date = $schedule->getScheduleDataByID($scheduleID)->date;
        $name = $user->getDoctorInfoByID($doctorID)->name;
        $weekDay = (int)date('N', strtotime($date)); 
        $totalShift = $schedule->confirmNextMonthScheduleByDoctorID($doctorID);
        $mustOnDuty = $user->getDoctorInfoByID($doctorID)->mustOnDutyTotalShifts;

        $dataArr = [];

        $info=[
            "docName" =>$name,
            "docWeekend"=>$docWeekend,
            "weekDay"=>$weekDay,
            "totalShift" =>$totalShift,
            "mustOnDuty" => $mustOnDuty
        ];

        array_push($dataArr,$info);

        return $dataArr;

    }

    //刪除班
    public function deleteSchedule(Request $request){
        $data = $request->all();
        $schedule = new Schedule();
        $shiftRecords = new ShiftRecords();
        
        $schedule->deleteDoctorID($data['scheduleID']);
        $shiftRecords->deleteShiftRecord($data['scheduleID']);
        $doctorID = $schedule->getScheduleDataByID($data['scheduleID'])->doctorID;

        // $job = new SendDeleteShiftMail($data['scheduleID'],$doctorID);

        // dispatch($job);

            
    }

    
    public function showScheduleID(Request $request){
        $data = $request->all();
        $id = $data['id'];
        return $id;
    }
    public function showScheduleInfo(Request $request){
        $data = $request->all();
        $scheduleCategory = new ScheduleCategory();
        $str= $data['date'];
        $dateArr = explode(' ', $str);
        $date = $this->processDateStr($str);
        $section_id = $data['section_id'];
        $categoryInfo = $scheduleCategory->getSchCategoryInfo($section_id);
        $info=[
            'date'=> $date,
            'schCategorySerial'=>$section_id,
            'location' => $categoryInfo
        ];
        return $info;
    }
    //更新班表
    public function updateSchedule(Request $request){
        $scheduleCategory = new ScheduleCategory();
        $schedule = new Schedule();
        $data = $request->all();
        $id = $data['id']; //schedule ID
        $sessionID = $data['newSessionID'];
        $newDate = $data['newDate'];


        $doctorID = $schedule->getScheduleDataByID($id)->doctorID;        
        $date = $this->processDateStr($newDate);
        $location = $scheduleCategory->getSchCategoryInfo($sessionID);
        $schInfo = [
              'schCategorySerial'=>$sessionID,
              'isWeekday' => true,
              'location' => $location,
              'date' => $date,
              'confirmed'=>1
            ];

        $weekDay = (int)date('N', strtotime($date));

        if($weekDay == 6 || $weekDay == 7){
          $schInfo['isWeekday'] = false;
        }

        $newScheduleID=$schedule->updateScheduleByID($id,$schInfo);

        $job = new SendShiftExchangeMail($doctorID,$id,$newScheduleID);
        dispatch($job);


    }
    //公布正式班表
    public function announceSchedule(Request $request){
            
        $schedule = new Schedule();
        $reservationData = new ReservationData();
        $user = new User();
        $announcement = new Announcement();

        $schedule->confirmNextMonthSchedule();
        $reservationData->setScheduleAnnounceStatus();

        $data=[
            'title'=>"公布正式班表",
            'content'=>"已公布正式班表",
            'doctorID'=> $user->getCurrentUserID()
        ];

        $announcement->addAnnouncement($data);


    }

    public function getDoctorInfoByScheduleID(Request $request){
      $data = $request->all();
      $schedule = new Schedule();
      $user = new User();
      $doctor = $schedule->getScheduleDataByID($data['id']);
     
      $doctorID =$doctor->doctorID;
      $id = $doctor->scheduleID;
      $name = $user->getDoctorInfoByID($doctor->doctorID)->name;
      $date = $doctor->date;
      $array = array($id,$name,$date,$doctorID);
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


    public function firstEditionScheduleSituation(){
        $user=new User();
        $mustOnDutyShiftPerMonth = new MustOnDutyShiftPerMonth();
        $schedule = new Schedule();
        $doctorName = $user->getAtWorkDoctors();

        $mustOnDuty=[];

        foreach($doctorName as $name){
        $mustOnDutyArr=[
            'doctorName'=> $name->name,
            'totalShift'=>'',
            'taipei'=>'',
            'tamsui'=>'',
            'day'=>'',
            'night'=>'',
            'medical'=>'',
            'surgical'=>'',
            'weekendShifts'=>4

        ];

        $date= date('Y-m',strtotime("+1 month"));
        $mustOnDutyShiftArr=[
            'doctorID'=>$name->doctorID,
            'leaveMonth'=>$date
        ];

        $count= $mustOnDutyShiftPerMonth->countOnDutyShift($mustOnDutyShiftArr);

        if($count!=0){
            $totalShift = $mustOnDutyShiftPerMonth->getOnDutyShift($mustOnDutyShiftArr)->mustOnDutyShift;
            $mustOnDutyArr['totalShift']=$totalShift;
            if($user->getDoctorInfoByID($name->doctorID)->location == "台北"){
                if($totalShift/ 2== 0){
                    $taipei = (int)$totalShift/2;
                    $mustOnDutyArr['taipei']= ceil($taipei);
                    $mustOnDutyArr['tamsui']=$totalShift-$mustOnDutyArr['taipei'];
                }
                else{
                $taipei = (int)$totalShift/2;
                $mustOnDutyArr['taipei']= ceil($taipei);
                $tamsui=$totalShift-$mustOnDutyArr['taipei'];
                $mustOnDutyArr['tamsui']=(int)$tamsui;
                }
         }

         if($user->getDoctorInfoByID($name->doctorID)->level == "A1" || $user->getDoctorInfoByID($name->doctorID)->level == "A5"){
            if($totalShift /2 == 0){
                $mustOnDutyArr['day'] = $totalShift/2;
                $mustOnDutyArr['night']  = $totalShift- $totalShift/2;
            }
            else{
                $mustOnDutyArr['day'] = floor($totalShift/2);
                $mustOnDutyArr['night']  = $totalShift-$mustOnDutyArr['day'];
            }
         }
         else if($user->getDoctorInfoByID($name->doctorID)->level == "A6" || $user->getDoctorInfoByID($name->doctorID)->level == "S4"){
            if($totalShift /2 == 0){
                $mustOnDutyArr['day'] = ($totalShift/2)+1;
                $mustOnDutyArr['night']  = $totalShift- $mustOnDutyArr['day'];
            }
            else{
                $mustOnDutyArr['day'] = ceil($totalShift/2);
                $mustOnDutyArr['night']  = $totalShift-$mustOnDutyArr['day'];
            }
         }
        
         else if($user->getDoctorInfoByID($name->doctorID)->level == "S5" || $user->getDoctorInfoByID($name->doctorID)->level == "S9"){
            if($totalShift /2 == 0){
                $mustOnDutyArr['day'] = ($totalShift/2)+1;
                $mustOnDutyArr['night']  = $totalShift- $mustOnDutyArr['day'];
            }
            else{
                $mustOnDutyArr['day'] = ceil($totalShift/2)+1;
                $mustOnDutyArr['night']  = $totalShift-$mustOnDutyArr['day'];
            }
         }
         else{
            if($totalShift /2 == 0){
                $mustOnDutyArr['day'] = ($totalShift/2)+2;
                $mustOnDutyArr['night']  = $totalShift- $mustOnDutyArr['day'];
            }
            else{
                $mustOnDutyArr['day'] = (ceil($totalShift/2))+2;
                $mustOnDutyArr['night']  = $totalShift-$mustOnDutyArr['day'];
            }

         }


            $medical=$mustOnDutyShiftPerMonth->getOnDutyShift($mustOnDutyShiftArr)->mustOnDutyShift*11/15;
            $mustOnDutyArr['medical']=ceil($medical);
            $surgical=$mustOnDutyShiftPerMonth->getOnDutyShift($mustOnDutyShiftArr)->mustOnDutyShift-$medical;
            $mustOnDutyArr['surgical']=(int)$surgical;
           
        }

        else{
            $mustOnDutyArr['totalShift']=$user->getDoctorInfoByID($name->doctorID)->mustOnDutyTotalShifts;
            $mustOnDutyArr['taipei']=$user->getDoctorInfoByID($name->doctorID)->mustOnDutyTaipeiShifts;
            $mustOnDutyArr['tamsui']=$user->getDoctorInfoByID($name->doctorID)->mustOnDutyTamsuiShifts;
            $mustOnDutyArr['day']=$user->getDoctorInfoByID($name->doctorID)->mustOnDutyDayShifts;
            $mustOnDutyArr['night']=$user->getDoctorInfoByID($name->doctorID)->mustOnDutyNightShifts;
            $mustOnDutyArr['medical']=$user->getDoctorInfoByID($name->doctorID)->mustOnDutyMedicalShifts;
            $mustOnDutyArr['surgical']=$user->getDoctorInfoByID($name->doctorID)->mustOnDutySurgicalShifts;
        }

        array_push($mustOnDuty,$mustOnDutyArr);
    }

    $onDuty=[];

    if($schedule->getScheduleDataByDate($date) !=0){

        foreach($doctorName as $name){

            $onDutyArr=[
                'doctorName'=> $name->name,
                'totalShift'=>$schedule->totalShiftFirstEdition($name->doctorID),
                'taipei'=>$schedule->totalTaipeiShiftFirstEdition($name->doctorID),
                'tamsui'=>$schedule->totalTamsuiShiftFirstEdition($name->doctorID),
                'day'=> $schedule->totalDayShiftFirstEdition($name->doctorID),
                'night'=>$schedule->totalNightShiftFirstEdition($name->doctorID),
                'medical'=>$schedule->totalMedicalShiftFirstEdition($name->doctorID),
                'surgical'=>$schedule->totalSurgicalShiftFirstEdition($name->doctorID),
                'weekendShifts'=>$schedule->checkDocScheduleInWeekend($name->doctorID),
                'mustTotalShift'=>$user->getDoctorInfoByID($name->doctorID)->mustOnDutyTotalShifts,
                'mustTaipei'=>$user->getDoctorInfoByID($name->doctorID)->mustOnDutyTaipeiShifts,
                'mustTamsui'=>$user->getDoctorInfoByID($name->doctorID)->mustOnDutyTamsuiShifts,
                'mustDay'=>$user->getDoctorInfoByID($name->doctorID)->mustOnDutyDayShifts,
                'mustNight'=>$user->getDoctorInfoByID($name->doctorID)->mustOnDutyNightShifts,
                'mustMedical'=>$user->getDoctorInfoByID($name->doctorID)->mustOnDutyMedicalShifts,
                'mustSurgical'=>$user->getDoctorInfoByID($name->doctorID)->mustOnDutySurgicalShifts

            ];
         array_push($onDuty,$onDutyArr);
        }
    }
    else{

    }
        return view ('pages.first-edition-situation',array('mustOnDuty'=>$mustOnDuty,'onDuty'=>$onDuty));
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