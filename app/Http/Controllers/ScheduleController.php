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
use App\ScheduleRecord;

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
        $reservationData = new ReservationData();
        
        $displayData = [];
        foreach ($scheduleData as $data) {
            $singleData = [
                'date' => $data->date,
                'endDate' => $data->endDate,
                'categoryName' => $scheduleCategory->findScheduleName($data->schCategorySerial)->schCategoryName
            ];
            
            array_push($displayData, $singleData);
        }

        $status = $reservationData->getStatus(date('Y-m'));
        
        return view('pages.first-edition', [
            'schedule' => $displayData,
            'status' => $status
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
            $scheduleName = $scheduleCategory->findScheduleName($data->schCategorySerial)->schCategoryName;
            $data->schCategorySerial =  $scheduleName;
        }
        return view('pages.schedule', array('schedule' => $scheduleData));
    }
    //調整班表->新增班 驗證醫生id與off班
    public function confirmscheduleStatus(Request $request){
        $data = $request->all();
        $id = $data['id']; //doctor id
        $date = $data['date'];
        $categoryID = $data['classification'];

        $schedule = new Schedule();
        $user = new User();
        $reservation = new Reservation();
        $scheduleCategory = new ScheduleCategory();
        //$count = $schedule->checkDocStatus($id,$date);

        $countNight=0;

        
        if($schedule->getNightScheduleByDoctorIDandDate($id,$date) != 0 and ($categoryID==3 or $categoryID==4 or $categoryID==5 or $categoryID==6 or $categoryID==7 or $categoryID==8 or $categoryID==9 or $categoryID==10 or $categoryID==11 or $categoryID==12 )){

            $countNight=1;

        }

        $countDay=0;
        if($schedule->geDayScheduleByDoctorIDandDate($id,$date) != 0 and ($categoryID==13 or $categoryID==14 or $categoryID==15 or $categoryID==16 or $categoryID==17 or $categoryID==18 or $categoryID==19 or $categoryID==20 or $categoryID==21)){


            $countDay=1;
        }

         $location=0;
            if($user->getDoctorInfoByID($id)->location != $scheduleCategory->getSchCategoryInfo($categoryID)){
                if($schedule->getAnotherLocationShifts($id,$date)>=2){
                    $location=1;
                }
            }

        $major=0;
        $major_doctor = "";
        if($categoryID==1 || $categoryID==2){
            $major_doctor=$user->getDoctorInfoByID($id)->major;
        }
        else{
            $major_doctor=$scheduleCategory->getSchCategoryMajor($categoryID);
        }
        if($user->getDoctorInfoByID($id)->major != "All"){
            if($user->getDoctorInfoByID($id)->major != $major_doctor){
                $major=1;
            }
        }  

        $infoArr=[];
        $info=[
            "doc"=>$user->getDoctorInfoByID($id)->name,
            "date"=>$data['date'],
            "countShedule"=>$schedule->checkDocStatus($id,$date),
            "countOff"=>$reservation->getResrvationByDateandDoctorID($id,$date),
            "countNight"=>$countNight,
            "countDay"=>$countDay,
            "location" => $location,
            "major"=>$major
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
        $scheduleCategory = new ScheduleCategory();
        $scheduleID = $data['scheduleID'];
        $date = $data['date']; //移動到哪一天
        $categoryID= $data['classification'];
        $dateStr = $this->processDateStr($date); //移動到哪一天
        $doctorID = $schedule->getScheduleDataByID($scheduleID)->doctorID;
        $dateInSchedule = $schedule->getScheduleDataByID($scheduleID)->date;
        $docName = $user->getDoctorInfoByID($doctorID)->name;
        $docWeekend = $schedule->checkDocScheduleInWeekend($doctorID);
        $count = $schedule->checkDocStatus($doctorID,$dateStr);
        $weekDay = (int)date('N', strtotime($dateStr));  //移動的
        $weekDayInSchedule = (int)date('N', strtotime($dateInSchedule));
        $countOff = $reservation->getResrvationByDateandDoctorID($doctorID,$dateStr);

        $countNight=0;
        $preDate = date("Y-m-d",strtotime($dateStr."-1 day"));
        $laterDate = date("Y-m-d",strtotime($dateStr."+1 day"));

        if($schedule->getNightScheduleByDoctorIDandDate($doctorID,$dateStr) != 0 and ($categoryID==3 or $categoryID==4 or $categoryID==5 or $categoryID==6 or $categoryID==7 or $categoryID==8 or $categoryID==9 or $categoryID==10 or $categoryID==11 or $categoryID==12 )){

            if($preDate == $dateInSchedule){
                $countNight=0;
            }
            else{
                $countNight=1;
            }
            

        }

        $countDay=0;
        if($schedule->getDayScheduleByDoctorIDandDate($doctorID,$dateStr) != 0 and ($categoryID==13 or $categoryID==14 or $categoryID==15 or $categoryID==16 or $categoryID==17 or $categoryID==18 or $categoryID==19 or $categoryID==20 or $categoryID==21  )){
            
             if($laterDate == $dateInSchedule){
                $countDay=0;
            }
            else{
                $countDay=1;
            }
            
        }

        $location=0;
         if($user->getDoctorInfoByID($doctorID)->location != $scheduleCategory->getSchCategoryInfo($categoryID)){
            if($schedule->getScheduleDataByID($scheduleID)->location != $scheduleCategory->getSchCategoryInfo($categoryID)){
                if($schedule->getAnotherLocationShifts($doctorID,$dateStr)>= 2){
                    $location=1;
            }
        }
    }
        $major=0;
        $major_doctor = "";
        if($categoryID==1 || $categoryID==2 ){
                $major_doctor=$user->getDoctorInfoByID($doctorID)->major;
        }
        else{
            $major_doctor=$scheduleCategory->getSchCategoryMajor($categoryID);
        }
        if($user->getDoctorInfoByID($doctorID)->major != "All"){
            if($user->getDoctorInfoByID($doctorID)->major != $major_doctor){
                $major=1;
            }
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
            "countNight"=>$countNight,
            "countDay"=>$countDay,
            'location'=>$location,
            "major"=> $major,
            "yearMonth" =>date('Y-m',strtotime($dateStr)), //被拉到的
            "yearMonthInSchedule" =>date('Y-m',strtotime($dateInSchedule)), //被拉到的
            
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
        $schedule = new Schedule();
        
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

        $count = $schedule->getScheduleDataByDateAndSessionIDWhenDoctorIDisNull($startDate,$categoryID);

        //  if($count!=""){
            $schedule->addFormalScheduleInNull($count->scheduleID,$schInfo);
            $scheduleID=$count->scheduleID;
        // }
        // else{
            //$scheduleID=$schedule->addSchedule($schInfo);

           
        // }
        

         //$job = new SendNewShiftAssignmentMail($doctorID,$scheduleID);

        //dispatch($job);
        
    }

  
    //列出醫生剩餘班數 正式班表
    public function showDoctorInfo(Request $request){
        $user = new User();
        $scheduleCategory = new ScheduleCategory();
        $mustOnDutyShiftPerMonth = new MustOnDutyShiftPerMonth();
        $schedule = new Schedule();

        $data = $request->all();

        $str = $this->processDateStr($data['date']);

        $month = date("Y-m",strtotime($str));

        $doctors="";

        if($data['categorySerial'] == 1 || $data['categorySerial'] == 2){
            $doctors =$schedule->getDoctorNotInDateWithoutMajor($str);
        }

        else{
            $major = $scheduleCategory->getSchCategoryMajor($data['categorySerial']);
      
            $doctors = $schedule->getDoctorNotInDate($str,$major);
        }

        $date= date('Y-m');
        $shiftArr=[];
        
        foreach ($doctors as $doctor) {

            $mustOnDutyMedicalShifts=0;
            $mustOnDutySurgicalShifts=0;

            $mustOnDutyShiftArr=[
            'doctorID'=>$doctor->doctorID,
            'leaveMonth'=>$month
            ];

            $count= $mustOnDutyShiftPerMonth->countOnDutyShift($mustOnDutyShiftArr);
            
            $shiftDic=[
                'totalShift'=>"",
                'doctorID'=>$doctor->doctorID,
                'doctorName' =>$doctor->name,
                
            ];

           
            if($count!=0){
                $shiftDic['totalShift'] = ($mustOnDutyShiftPerMonth->getOnDutyShift($mustOnDutyShiftArr)->mustOnDutyShift)-($schedule->totalShift($doctor->doctorID,$month));
                

           
             }

            else{
                 $shiftDic['totalShift']=($user->getDoctorInfoByID($doctor->doctorID)->mustOnDutyTotalShifts)-($schedule->totalShift($doctor->doctorID,$month));
                
            }    

            
            array_push($shiftArr,$shiftDic);
        }
        
             return $shiftArr;
           
           //array_push($surgicallArr,$totalSurgical);
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
        $shiftRecords = new ShiftRecords();
        $user = new User();

        $data = $request->all();

        $id = $data['id']; //schedule ID
        $sessionID = $data['newSessionID'];
        $newDate = $data['newDate'];
        $date = $this->processDateStr($newDate);

        $sch=$schedule->getScheduleDataByDateAndSessionIDWhenDoctorIDisNull($date,$sessionID);

        $doctorID = $schedule->getScheduleDataByID($id)->doctorID;
        $doctorName = $user->getDoctorInfoByID($doctorID)->name;  
        $oldDate = $schedule->getScheduleDataByID($id)->date;
        $oldSession =$scheduleCategory->findScheduleName($schedule->getScheduleDataByID($id)->schCategorySerial)->schCategoryName;
        $session = $scheduleCategory->findScheduleName($sessionID)->schCategoryName;
        
        $location = $scheduleCategory->getSchCategoryInfo($sessionID);
        $schInfo = [
              'schCategorySerial'=>$sessionID,
              'isWeekday' => true,
              'location' => $location,
              'date' => $date,
              'doctorID'=>$doctorID,
              'confirmed'=>1,
              'status'=>0
            ];

        $weekDay = (int)date('N', strtotime($date));

        if($weekDay == 6 || $weekDay == 7){
          $schInfo['isWeekday'] = false;
        }
        
        $shiftInfo = [
            'scheduleID_1' => $id,
            'scheduleID_2' => $sch->scheduleID,
            'schID_1_doctor' => $doctorID,
            'schID_2_doctor' => $doctorID,
            'doc2Confirm' => 1,
            'adminConfirm' => 1,
            'date' => date('Y-m-d')
        ];
        

            $array = array($doctorName,$oldDate,$oldSession,$date,$session);
        // if($sch!=""){ //有查到資料
        //     // $newScheduleID=$schedule->addSchedule($schInfo);
        //     // $schedule->updateScheduleToNullByID($sch->doctorID);
            $schedule->addScheduleInNull($sch->scheduleID,$schInfo);
            $schedule->updateScheduleToNullByID($id);

            $newChangeSerial = $shiftRecords->addShifts($shiftInfo);
            $newScheduleID=$sch->scheduleID;
            
        //  }

        // else{
        //     $newScheduleID=$schedule->addSchedule($schInfo);
        //     $schedule->updateScheduleToNullByID($sch->doctorID);
        //  }
        
       
        //$newScheduleID=$schedule->updateScheduleByID($id,$schInfo);
        

        //$job = new SendShiftExchangeMail($doctorID,$id,$newScheduleID);
        //dispatch($job);

        return $array;


    }
    //公布正式班表
    public function announceSchedule(Request $request){
            
        $schedule = new Schedule();
        $reservationData = new ReservationData();
        $user = new User();
        $announcement = new Announcement();
        $mustOnDutyShiftPerMonth = new MustOnDutyShiftPerMonth();
        $scheduleRecord = new ScheduleRecord();


        $schedule->confirmNextMonthSchedule();
        $reservationData->setScheduleAnnounceStatus();

        $data=[
            'title'=>"公布正式班表",
            'content'=>"已公布正式班表",
            'doctorID'=> $user->getCurrentUserID()
        ];

        $doctorName = $user->getAtWorkDoctors();

        $month=date("Y-m",strtotime("+1 month"));
        $reservationData->addDate($month,01,10);


    //     foreach($doctorName as $name){

    //         $date= date('Y-m');
           
    //         $mustOnDutyShiftArr=[
    //         'doctorID'=>$name->doctorID,
    //         'leaveMonth'=>$date
    //         ];

    //         $count= $mustOnDutyShiftPerMonth->countOnDutyShift($mustOnDutyShiftArr);

    //         if($count!=0){
    //             $mustOnDutyTotalShift = $mustOnDutyShiftPerMonth->getOnDutyShift($mustOnDutyShiftArr)->mustOnDutyShift; //應上
    //             $totalShift=$schedule->totalShiftFirstEdition($name->doctorID); //已上
    //             $shifHours = $mustOnDutyTotalShift-$totalShift; //計算積欠或多餘
    //             $scheduleRecord->updateLeaveHours($name->doctorID,$shifHours);
    //         }
    //         else{
    //             $mustOnDutyTotalShift=$user->getDoctorInfoByID($name->doctorID)->mustOnDutyTotalShifts;
    //             $totalShift=$schedule->totalShiftFirstEdition($name->doctorID); //已上
    //             $shifHours = $mustOnDutyTotalShift-$totalShift; //計算積欠或多餘
    //             $scheduleRecord->updateLeaveHours($name->doctorID,$shifHours);
    //          }

    // }
   

        $announcement->addAnnouncement($data);


    }
    //換班 彈出式視窗取得醫生1的上班資訊 
    public function getDoctorInfoByScheduleID(Request $request){
      $data = $request->all();
      $schedule = new Schedule();
      $user = new User();
      $scheduleCategory = new ScheduleCategory();
      $doctor = $schedule->getScheduleDataByID($data['id']);
     
      $doctorID =$doctor->doctorID;
      $id = $doctor->scheduleID;
      $name = $user->getDoctorInfoByID($doctor->doctorID)->name;
      $date = $doctor->date;
      $category = $scheduleCategory->findScheduleName($doctor->schCategorySerial)->schCategoryName;
      $array = array($id,$name,$date,$doctorID,$category);
      return $array;
      
    }

     //調整班表->初版班表 彈出式視窗取得醫生2的上班資訊
    public function getDoctorFirstScheduleInfoByID(Request $request){
        $data = $request->all();

        $schedule = new Schedule();
        $user = new User();

        $scheduleID=$data['scheduleID'];
        $doctor = $schedule->getDateNotInDate($scheduleID);
        $array = array();

        foreach ($doctor as $data) {
            //$doctorID = $data->doctorID;
            $date = $data->date;
            //$id =$data->scheduleID;
           
            
            array_push($array, array($date));
        }

        return $array;
    }
    //調整班表->正式班表 彈出式視窗取得醫生2的上班日期
    public function getDoctorScheduleDateByID(Request $request){
        $data = $request->all();

        $schedule = new Schedule();
        $user = new User();

        $scheduleID=$data['scheduleID'];
        $doctor = $schedule->getDateNotInDateNotNull($scheduleID,"");
        $array = array();

        foreach ($doctor as $data) {
            //$doctorID = $data->doctorID;
            $date = $data->date;
            //$id =$data->scheduleID;
           
            
            array_push($array, array($date));
        }

        return $array;
    }

    //調整班表->初版班表 彈出式視窗取得醫生2的上班資訊
    public function getDoctorNameFirstScheduleInfoByID(Request $request){
        $data = $request->all();

        $schedule = new Schedule();

        $scheduleCategory = new ScheduleCategory();
       
        $user = new User();

        // $date1 = $schedule->getScheduleDataByID($data['scheduleID_1'])->date;
        // //$date2 = $schedule->getScheduleDataByID($data['scheduleID_2'])->date;
        // $date2= $data['scheduleID_2'];
        // $schCategorySerial=$schedule->getScheduleDataByID($data['scheduleID_1'])->schCategorySerial;
        // $major_doctor = $user->getDoctorInfoByID($schedule->getScheduleDataByID($data['scheduleID_1'])->doctorID)->major;
        // if($schCategorySerial == 1 || $schCategorySerial ==2){
        //     $major_schedule=$major_doctor;
        // }
        // else{
        //     $major_schedule = $scheduleCategory->getSchCategoryMajor($schCategorySerial);
        // }
        
        
        $scheduleRecord = $schedule->getDoctorInDate($data['scheduleID_1'],$data['scheduleID_2']);
        $array = array();

        
        foreach ($scheduleRecord as $schedule) {

            $scheduleID = $schedule->scheduleID;

            if($schedule->doctorID == null){
                $name="";
            }
            else{
                $name = $user->getDoctorInfoByID($schedule->doctorID)->name;
            }

            $category = $schedule->schCategoryName;
            $date = $schedule->date;
            
            array_push($array, array($scheduleID,$name,$category,$date));
        }

        return $array;
    }


    //調整班表->正式班表 彈出式視窗取得醫生2的上班資訊
    public function getDoctorNameScheduleInfoByID(Request $request){
        $data = $request->all();

        $schedule = new Schedule();

        $scheduleCategory = new ScheduleCategory();
       
        $user = new User();

        // $date1 = $schedule->getScheduleDataByID($data['scheduleID_1'])->date;
        // //$date2 = $schedule->getScheduleDataByID($data['scheduleID_2'])->date;
        // $date2= $data['scheduleID_2'];

        // $schCategorySerial=$schedule->getScheduleDataByID($data['scheduleID_1'])->schCategorySerial;
        
        // $major_doctor = $user->getDoctorInfoByID($schedule->getScheduleDataByID($data['scheduleID_1'])->doctorID)->major;

        // if($schCategorySerial == 1 || $schCategorySerial ==2){
        //     $major_schedule=$major_doctor;
        // }
        // else{
        //     $major_schedule = $scheduleCategory->getSchCategoryMajor($schCategorySerial);
        // }
        
        
        $scheduleRecord = $schedule->getDoctorDateNotNull($data['scheduleID_1'],$data['scheduleID_2']);

        $array = array();

        
        foreach ($scheduleRecord as $schedule) {

            $scheduleID = $schedule->scheduleID;

            if($schedule->doctorID == null){
                $name="";
            }
            else{
                $name = $user->getDoctorInfoByID($schedule->doctorID)->name;
            }

            $category = $schedule->schCategoryName;
            $date = $schedule->date;
            
            array_push($array, array($scheduleID,$name,$category,$date));
        }

        return $array;
    }
     
    //換班資訊 彈出式視窗取得醫生2的上班資訊
    public function  getDoctorScheduleInfoByID(Request $request){
        $data = $request->all();

        $schedule = new Schedule();

        $scheduleCategory = new ScheduleCategory();
       
        $user = new User();

        $date1 = $schedule->getScheduleDataByID($data['scheduleID_1'])->date;
        //$date2 = $schedule->getScheduleDataByID($data['scheduleID_2'])->date;
        $date2= $data['scheduleID_2'];

        $schCategorySerial=$schedule->getScheduleDataByID($data['scheduleID_1'])->schCategorySerial;

        $major="";

        if($schCategorySerial == 1 || $schCategorySerial ==2){
            $major=$user->getDoctorInfoByID($schedule->getScheduleDataByID($data['scheduleID_1'])->doctorID)->major;
        }
        else{
           $major = $scheduleCategory->getSchCategoryMajor($schCategorySerial);
        }
        
        $scheduleRecord = $schedule->getDoctorDateNotNull($date1,$date2,$major);

        $array = array();

        
        foreach ($scheduleRecord as $schedule) {

            $scheduleID = $schedule->scheduleID;
            if($schedule->doctorID == null){
                $name="";
            }
            else{
                $name = $user->getDoctorInfoByID($schedule->doctorID)->name;
            }

            $category = $scheduleCategory->findScheduleName($schedule->schCategorySerial)->schCategoryName;
            $date = $schedule->date;
            
            array_push($array, array($scheduleID,$name,$category,$date));
        }

        return $array;


    }

    //換班資訊 彈出式視窗取得醫生2的上班資訊
    public function  getDoctorScheduleDateByCurrentDoctorID(Request $request){
        $data = $request->all();
        $shiftRecordObj = new ShiftRecords();
        $userObj = new User();
        $sheduleObj = new Schedule();
        $schCateObj = new ScheduleCategory();
        
        $currentDoctor = $userObj->getCurrentUserInfo();

        $currentDoctorSchedule=$sheduleObj->getNextMonthShiftsByID($currentDoctor->doctorID); //查看目前登入的醫生班表資訊

        $currentMonth = date('Y-m-d');
        $nextMonth=date("Y-m",strtotime($currentMonth."+1 month"));



        $date = $sheduleObj->getDateNotInDateNotNull($data['scheduleID'],'');

        $dateArr = [];
        foreach ($date as $d) {
           array_push($dateArr,$d->date);

       }
       
        return $dateArr;

    }

    public function getDoctorInfoByScheduleIDWhenExchange(Request $request){
      $data = $request->all();
      $schedule = new Schedule();
      $user = new User();

      $doctor = $schedule->getScheduleDataByID($data['id']);
      $doctor2 = $schedule->getScheduleDataByID($data['id2']);

      $name = null;

        if($doctor->doctorID == null){
         $name = "";
        }

        else{
        $name = $user->getDoctorInfoByID($doctor->doctorID)->name;
        }

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
            if($user->getDoctorInfoByID($name->doctorID)->location == "Taipei"){
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
                $mustOnDutyArr['night']  = $totalShift-$totalShift/2;
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

        if($user->getDoctorInfoByID($name->doctorID)->major == "All"){
            $medical=$mustOnDutyShiftPerMonth->getOnDutyShift($mustOnDutyShiftArr)->mustOnDutyShift*11/15;
            $mustOnDutyArr['medical']=ceil($medical);
            $surgical=$mustOnDutyShiftPerMonth->getOnDutyShift($mustOnDutyShiftArr)->mustOnDutyShift-$medical;
            $mustOnDutyArr['surgical']=(int)$surgical;
        }
            else if($user->getDoctorInfoByID($name->doctorID)->major == "Medical"){
            $mustOnDutyArr['medical']=$mustOnDutyShiftPerMonth->getOnDutyShift($mustOnDutyShiftArr)->mustOnDutyShift;
            $mustOnDutyArr['surgical']=0;
        }
            else if ($user->getDoctorInfoByID($name->doctorID)->major == "Surgical") {
            $mustOnDutyArr['medical']=0;
            $mustOnDutyArr['surgical']=$mustOnDutyShiftPerMonth->getOnDutyShift($mustOnDutyShiftArr)->mustOnDutyShift;;
        }
           
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
                'totalShift'=>$schedule->totalShift($name->doctorID,$date),
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

    //查詢 單一醫生總積欠班數 
    public function shifHoursByDoctorID(){
        $scheduleRecord = new ScheduleRecord();
        $user = new User();
        $shiftHours =$scheduleRecord->getScheduleTotoalBydoctorID($user->getCurrentUserID());
        
        return $shiftHours;
    }

    //查詢 所有醫生總積欠班數
    public function shifHours(){

        $scheduleRecord = new ScheduleRecord();     
        $user = new User();
        $doctors = $user->getAtWorkDoctors();
        $totalShift=[];
        foreach ($doctors as $doctor) {
            $shiftHours =$scheduleRecord->getScheduleTotoalBydoctorID($doctor->doctorID);
            
             array_push($totalShift,$shiftHours);
        }

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