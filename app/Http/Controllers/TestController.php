<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use Mail;
use App\Jobs\SendFakeMail;
use App\Mail\FakeMail;
use App\Mail\FakeMail2;
use App\Mail\FakeMail3;
use App\Mail\FakeMail4;

use App\Jobs\SendFakeMails;

use App\User;
use App\Remark;
use App\Announcement;
use App\ShiftCategory;
use App\Reservation;
use App\DoctorAndReservation;
use App\Schedule;
use App\ShiftRecords;
use App\OfficialLeave;
use App\ScheduleCategory;
use App\ReservationData;
use App\MustOnDutyShiftPerMonth;
use App\ScheduleRecord;

use App\Jobs\SendDeleteShiftMail;
use App\Jobs\SendApplyShiftExchangeMail;



use App\Jobs\Schedule2;

class TestController extends Controller
{
    
    // 印出目前登入的使用者ID
    public function getUserInfo() {
        $user = new User();
        
        echo 'User ID : '.$user->getCurrentUserID();
    }
    
    // 回傳輸入日期的表單
    public function getDateForm() {
        return view('testPage.testDate');
    }
    
    // 測試日期印出格式
    public function getDateValue() {
        $date = Input::get('date');
        
        echo $date;
    }
    
    // 取得在職醫師名單
    public function showAtWorkDoctorList() {
        $user = new User();
        
        $data = ['doctors' => $user->getAtWorkDoctors()];
        
        return view('testPage.doctorAtWorkList', $data);
    }
    
    // 單一醫生離職
    public function resign($id) {
        $user = new User();
        
//        $resignedDoctorID = Input::get('doctorID');
        
        $user->resign($id);
        
        return redirect('testShowAtWorkDoctorList');
    }
    
    // 取得單一醫生所有的排班班數
    public function getShiftForDoctor($id) {
//        echo 'Doctor ID : '.$id;
        $user = new User();
        
        $userData = $user->getDoctorInfoByID($id);
        
        return view('testPage.doctorShifts', ['userData' => $userData]);
    }
    
    // 更新單一醫師的排班資料
    public function updateDoctorShifts(Request $request) {
        $data = $request->all();
        
        $user = new User();
        
        $rows = $user->updateShifts($data['doctorID'], $data);
        
        return redirect('testDoctorList');
    }
    
    public function getTestPage() {
        return view('pages.doctor');
    }
    
    public function addoneDay() {
        $time = strtotime(date('Y-m-d'));
        echo $time.'<br>';
        
        $newformat = date('Y-m-d',$time + 24 * 60 * 60);
        
        echo $newformat;
    }
    
    // 回傳醫生名單頁面
    public function getDoctorList() {
        $user = new User();
        
        $data = [
            'doctors' => $user->getDoctorList(),
            'userName' => $user->getCurrentUserInfo()->name
        ];
        
        return view('pages.doctor', $data);
    }
    
    public function testDateFormat(Request $request) {
        $data = $request->all();
        
        echo 'Date format : '.$data['birthday'];
    }
    
    public function getChartPage() {
        return view('pages.chart');
    }
    
    public function getOfficialLeavePage() {
        return view('pages.officialaffair');
    }
    
    public function reservationSave() {
//        $id = Input::get('field_name');
        
        $remark = new Remark();
        
        $remark->addRemark(100, 'asdfgh');
        
//        echo 'ID : '.$id;
    }
    
    //測試 jQuery 的 AJAX 
    public function postAjaxRequest(Request $request) {
        $requestedData = $request->all();
        
        $annoucement = new Announcement();
        
        $str = 'TYPE:'.gettype($requestedData['date1']);
        
        $data = [
            'doctorID' => $requestedData['num'],
            'title' => $str,
            'content' => $requestedData['date2']
        ];
        
        $annoucement->addAnnouncement($data);
    }
    
    public function testDateString() {
        //Request $request
//        $data = $request->all();
        
        $serial = 5;
//        $serial = $data['serial'];
//        $str = $data['date1'];
        $str = 'Tue Aug 15 2017 00:00:00 GMT+0800 (CST)';
        
        $dateArr = explode(' ', $str);
        
//        echo print_r($arr).'<br>';
//        echo strcmp($arr[0],"Wed");
        
        $shiftCategory = new ShiftCategory();
        
        $categoryInfo = $shiftCategory->getCategoryInfo($serial);
        
        $resInfo = [
            'isWeekday' => true,
            'location' => $categoryInfo['location'],
            'isOn' => $categoryInfo['isOn'],
            'date' => $this->processDateStr($str),
            'categorySerial' => $serial
        ];
        
        // 判斷平日/假日
        if(strcmp($dateArr[0],"Sat") == 0 or strcmp($dateArr[0],"Sun") == 0) {
            $resInfo['isWeekday'] = false;
        }
        
        $resObj = new Reservation();
        
        $newSerial = $resObj->addOrUpdateReservation($resInfo);
        
        echo print_r($resInfo).'<br>';
        echo 'Serial : '.$newSerial;
        
        $docAndRes = new DoctorAndReservation();
        $user = new User();
        
        $darData = [
            'resSerial' => $newSerial,
            'doctorID' => $user->getCurrentUserID(),
        ];
        $docAndRes->addDoctor($darData);
    }
    
    public function addDoctorAndResTest() {
        $docAndResObj = new DoctorAndReservation();
        $user = new User();
        
        $data = [
            'resSerial' => 2,
            'doctorID' => $user->getCurrentUserID(),
            'remark' => ''
        ];
        
        $docAndResObj->addDoctor($data);
    }
    
    // public function processDateStr($dateStr) {
    //     $dateArr = explode('-', $dateStr);
        
    //     // 判斷月份
    //     $month = '00';
    //     switch($dateArr[1]) {
    //         case 'Jan' :
    //             $month = '01';
    //             break;
    //         case 'Feb' :
    //             $month = '02';
    //             break;
    //         case 'Mar' :
    //             $month = '03';
    //             break;
    //         case 'Apr' :
    //             $month = '04';
    //             break;
    //         case 'May' :
    //             $month = '05';
    //             break;
    //         case 'Jun' :
    //             $month = '06';
    //             break;
    //         case 'Jul' :
    //             $month = '07';
    //             break;
    //         case 'Aug' :
    //             $month = '08';
    //             break;
    //         case 'Sep' :
    //             $month = '09';
    //             break;
    //         case 'Oct' :
    //             $month = '10';
    //             break;
    //         case 'Nov' :
    //             $month = '11';
    //             break;
    //         case 'Dec' :
    //             $month = '12';
    //             break;
    //     }
        
    //     $day = $dateArr[2];
    //     $year = $dateArr[3];
        
    //     return $year.'-'.$month.'-'.$day;
    // }


     public function shiftFirstEditionAddShifts(){
            //$data = $request->all();

            //$scheduleID1 = $data['scheduleID_1'];
            //$scheduleID2 = $data['scheduleID_2'];

            $scheduleID1=7;
            $scheduleID2=9;

            $schedule = new Schedule();

            $schedule_1_Info = $schedule->getScheduleDataByID($scheduleID1);
            $schedule_2_Info = $schedule->getScheduleDataByID($scheduleID2);

            $shiftInfo = [
            'scheduleID_1' => $schedule_1_Info->scheduleID,
            'scheduleID_2' => $schedule_2_Info->scheduleID,
            'schID_1_doctor' => $schedule_1_Info->doctorID,
            'schID_2_doctor' => $schedule_2_Info->doctorID,
            'doc2Confirm' => '1',
            'adminConfirm' => '1',
            'date' => date('Y-m-d')
        ];

            $shiftRecords = new ShiftRecords();

            $newChangeSerial = $shiftRecords->addShifts($shiftInfo);

            echo "newChangeSerial" .$newChangeSerial;

            //$changeSerial = $shiftRecords->getChangeSerial($scheduleID1,$scheduleID2);

            //$confrimShiftRecord = $schedule->exchangeSchedule($changeSerial); 
            $shiftRecords->doc2Confirm($newChangeSerial,1);
            $shiftRecords->adminConfirm($newChangeSerial,1);
            $schedule->exchangeSchedule($newChangeSerial);


            // $addShifts = new ShiftRecords();
            // $scheduleID_1 = Input::get('scheduleID_1');
            // $scheduleID_2 = Input::get('scheduleID_2');
            // $schID_1_doctor = Input::get('schID_1_doctor');
            // $schID_2_doctor = Input::get('schID_2_doctor');
            // $doc2Confirm = 0;
            // $adminConfirm = 0;

            // $newShiftSerial = $addShifts->addShifts($scheduleID_1,$scheduleID_2,$schID_1_doctor,$schID_2_doctor,$doc2Confirm,$adminConfirm);

    }
    public function countDay(){
        $user = new User();
        $reservation=new Reservation();

        $doctorID = $user->getCurrentUserID();
        $doctorDay = $user->getDoctorInfoByID($doctorID)->mustOnDutyDayShifts;
        $doctorNight = $user->getDoctorInfoByID($doctorID)->mustOnDutyNightShifts;        
        $countDay = $doctorDay-$reservation->amountDayShifts();
        $countNight = $doctorNight-$reservation->amountNightShifts();

        $array = array('doctorDay'=>$doctorDay,'doctorNight'=>$doctorNight,'countDay'=>$countDay,'countNight'=>$countNight);

        echo print_r($array);

      }
 

    
    
    
    // Algorithm Test
    // 取得 reservation 列表
    public function getReservations($isOn) {
        $resObj = new Reservation();
        
        $resList = [];
        if($isOn) {
            // 取得 on 班預約
            $resList = $resObj->getOnReservation();
        }else {
            // 取得 off 班預約
            $resList = $resObj->getOffReservation();
        }
        
        
        $onReservationList = [];
        foreach($resList as $res) {
            $resData = $this->getReservationObj($res, $isOn);
            
            array_push($onReservationList, $resData);
        }
        
        return $onReservationList;
    }
    
    // Get single reservation On object
    public function getReservationObj($reservation, $isOn) {
        // 取得單一reservation 物件
        $dataDic = [
            'day' => 0,
            'location' => '',
            'dayOrNight' => '',
            'doctors' => []
        ];
        
        //day
        $date = $reservation->date;
        $dateArr = explode('-', $date);
        $dataDic['day'] = (int)$dateArr[2];
        
        //location
        if($isOn) {
            $categorySerial = $reservation->categorySerial;
            $shiftCategoryObj = new ShiftCategory();
            $cateInfo = $shiftCategoryObj->getCategoryInfo($categorySerial);
            
            if(strcmp($cateInfo['location'], 'Taipei')) {
                $dataDic['location'] = 'T';
            }else {
                $dataDic['location'] = 'D';
            }
            
            //dayOrNight
            $dataDic['dayOrNight'] = $cateInfo['dayOrNight'];
        }
        
        // doctors
        $docAndResObj = new DoctorAndReservation();
        $doctors = $docAndResObj->getDoctorsByResSerial($reservation->resSerial);
        
        foreach($doctors as $doctor) {
            array_push($dataDic['doctors'], $doctor->doctorID);
        }
        
        return $dataDic;
    }

 //新增預班
    public function addReservation(){
        //$data = $request->all();
        
        $serial = 8;
        $str = '2017-09-01';
        $end = '2017-09-03';
        
        $dateArr = explode('-', $str);
        $endDateArr = explode('-', $end);
       

        $countDay = ($endDateArr[2]-$dateArr[2])+1;
      

        $shiftCategory = new ShiftCategory();
        
        $categoryInfo = $shiftCategory->getCategoryInfo($serial);
        
       
        $resObj = new Reservation();
        $docAndRes = new DoctorAndReservation();
        $user = new User();
       

        for($i = 1; $i <= $countDay; $i++){

            $day = $dateArr[2];

            $resInfo = [
                'isWeekday' => true,
                'location' => $categoryInfo['location'],
                'isOn' => $categoryInfo['isOn'],
                'date' => $str,
                'categorySerial' => $serial
            ];

            if(strcmp($dateArr[0],"Sat") == 0 or strcmp($dateArr[0],"Sun") == 0) {
                $resInfo['isWeekday'] = false;
            }

            $newSerial = $resObj->addOrUpdateReservation($resInfo);

            $darData = [
            'resSerial' => $newSerial,
            'doctorID' => 3,
            ];

            $docAndRes->addDoctor($darData);

            // 遇同一份預班有過多的人時寄送通知信件
            $count = $docAndRes->amountInResserial($newSerial);
        
            if($shiftCategory->exceedLimit($count, $serial)) {
            $this->sendRandomNotificationMail($newSerial);
            }

           $str=date("Y-m-d",strtotime($str."+1 day"));

           
        }
    
    
        
    }
    

    public function getDoctorInfoByScheduleID(){
      //$data = $request->all();

      $schedule = new Schedule();
      $user = new User();

      $doctor = $schedule->getScheduleDataByID(7);

     
      $id = $doctor->scheduleID;
      $name = $user->getDoctorInfoByID($doctor->doctorID)->name;
      $date = $doctor->date;

      $array = array($id,$name,$date);

      echo $array[0];
      echo $array[1];
      echo $array[2];
      
    }

    // Doctors data
    public function getDoctors() {
        $userObj = new User();
        
        $doctors = $userObj->getDoctorList();
        
        $doctorSchData = [];
        
        foreach($doctors as $doctor) {
//            $doctorData = [
//                'doctorID' => $doctor->doctorID,
//                'major' => '',
//                'totalShift' => 0,
//                'dayShift' => 0,
//                'nightShift' => 0,
//                'holidayShift' => 0,
//                'location' => '',
//                'maxTaipeiShifts' => 0,
//                'maxDamsuiShifts' => 0,
//                'surgicalShifts' => 0,
//                'medicalShifts' => 0,
//            ];
        }
    }
    
    public function getAAAA() {
        $user = new User();
        
        // 取得該醫生的應上總班數
        $resLimit = (int)(($user->getCurrentUserInfo()->mustOnDutyTotalShifts) * 2 / 3);
        
        // 取得醫生預約的on班與off班數量
        $docAndResObj = new DoctorAndReservation();
        $onResAmount = $resLimit - $docAndResObj->getOnResAmount($user->getCurrentUserID());
        $offResAmount = $resLimit - $docAndResObj->getOffResAmount($user->getCurrentUserID());
        
        echo $onResAmount.'<br>';
        echo $offResAmount;
    }
    public function getDoctorInfoByID(){
        //$data = $request->all();
        $currentMonth = date('Y-m');
        $nextMonth=date("Y-m",strtotime($currentMonth."+1 month"));
        echo $nextMonth;
        // $schedule = new Schedule();
        // $user = new User();
        
        // $doctor = $schedule->getScheduleByDoctorID($data['id']);

        // $array = array();

        // foreach ($doctor as $data) {
        //     $id = $data->scheduleID;
        //     $date = $data->date;
        //     $name = $user->getDoctorInfoByID($data->doctorID)->name;
            
        //     array_push($array, array($id,$name,$date));
        // }

        // return $array;
    }
     public function getChartPageBySelectedID() {
        //$data = $request->all();
        
        
        $userID = 1;
        
        $user = new User();
        $doctor = array();
        
        $selectedtUser = $user->getDoctorInfoByID($userID)->name;
        
        $schedule = new Schedule();
        
        $shifts = $schedule->getCurrentMonthShiftsByID($userID);
        
        $shiftsData = $schedule->countScheduleCategory($shifts);
        
      
        $array = array($selectedtUser,count($shifts),$shiftsData);
       // array_push($doctor, array($selectedtUser, $shiftsData));
        
        echo $array[1];
    }
     public function getOfficialLeavePageById() {
        //$data = $request->all();
        
        $user = new User();

        $doctorID = 1;

        $officialLeave = new OfficialLeave();
        
        $leaves = $officialLeave->getLeavesByDoctorID($doctorID);
        
        $doctorsLeave = array();
        
        foreach($leaves as $leave) {
            $recordDate = $leave->recordDate;
            $confirmingPersonID = $leave->confirmingPersonID;
            $leaveDate = $leave->leaveDate;
            $remark = $leave->remark;
            $leaveHours = $leave->leaveHours;
            
            array_push($doctorsLeave, array($recordDate,$confirmingPersonID,$leaveDate,$remark,$leaveHours));
            //echo $doctorsLeave[0];
        }

            echo $doctorsLeave[1][0];
        // return view('pages.officialaffair', [
        //     'doctorsLeave' => $doctorsLeave
        // ]);
        
    }
    public function getRemarkByMonth(){
        //$data = $request->all();
        $month = '2017-09';

        $remark = new Remark();
        $userObj = new User();

        $remarks = $remark->getRemarksByMonth($month);

        $displayRemarksArr = [];

        foreach($remarks as $remark) {
            $remarkDic = [
                'author' => '',
                'date' => $remark->date,
                'content' => $remark->remark
            ];
            
            $remarkDic['author'] = $userObj->getDoctorInfoByID($remark->doctorID)->name;
            
            array_push($displayRemarksArr, $remarkDic);
        }
        echo $displayRemarksArr[0]['author'];
    }
    //新增班表
    public function addSchedule(){
        //$data = $request->all();
        
        $name = 1;
        $date =  "2017-10-01";
        $categoryID = 8;
       $day = 7;

        
        $scheduleCategory = new ScheduleCategory();
        
        $categoryInfo = $scheduleCategory->getSchCategoryInfo($categoryID);
        
        $user = new User();

        

            $schInfo = [
                'doctorID' =>$name,
                'schCategorySerial'=>$categoryID,
                'isWeekday' => true,
                'location' => $categoryInfo,
                'date' => $date,
                'confirmed'=>1
            ];

            if($day == 7 or $day == 6) {
                $schInfo['isWeekday'] = false;
            }

        $schedule = new Schedule();
        $schedule->addSchedule($schInfo);
        
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

     public function showScheduleID(){
        //$data = $request->all();

        $id = 26;

        return $id;

    }

    public function showScheduleInfo(){
        // $data = $request->all();
        $scheduleCategory = new ScheduleCategory();

        $str= 'Mon Oct 02 2017 00:00:00 GMT+0800 (CST)';
        $dateArr = explode(' ', $str);
        //$date = $this->processDateStr($str);

        $section_id = 3;
        $categoryInfo = $scheduleCategory->getSchCategoryInfo($section_id);

        $info=[
           
            'schCategorySerial'=>$section_id,
            'location' => $categoryInfo
        ];

        return $info;

    }

    //更新班表
    //更新班表
    public function updateSchedule(){

        $scheduleCategory = new ScheduleCategory();

        $sessionID = 2;
        $newDate = "Wed Oct 04 2017 00:00:00 GMT+0800";
        $id = 4;

        $date = $this->processDateStr($newDate);
        $location = $scheduleCategory->getSchCategoryInfo($sessionID);

        $schInfo = [
              'schCategorySerial'=>$sessionID,
              'isWeekday' => true,
              'location' => $location,
              'date' => $newDate,
              'confirmed'=>1
            ];

        $weekDay = (int)date('N', strtotime($date));

        if($weekDay == 6 || $weekDay == 7){
          $schInfo['isWeekday'] = false;
        }

        $schedule = new Schedule();
        $schedule->updateScheduleByID($id,$schInfo);
    }

    //調整班表->新增班 驗證 班id
    public function confirmscheduleStatusBySerial(){
       // $data = $request->all();
        
        $scheduleID = 2;
        $date = "Sun Oct 01 2017 00:00:00 GMT+0800 (CST)";

        $dateStr = $this->processDateStr($date);

        $schedule = new Schedule();
        $doctorID = $schedule->getFirstEditionScheduleByDoctorID($scheduleID)->doctorID;
        $count = $schedule->checkDocStatus($scheduleID,$dateStr);
        
        echo $count;
        //return $count;

    }
     public function checkDoc1ShiftStatus(){
        

        $scheduleID1 = 36;
        $scheduleID2 = 37;

        $schedule = new Schedule();

        //判斷醫生1班
        $doctorID1 = $schedule->getScheduleDataByID($scheduleID1)->doctorID;//2
        $date1 = $schedule->getScheduleDataByID($scheduleID2)->date;

        //判斷醫生1班
        $doctorID2 = $schedule->getScheduleDataByID($scheduleID2)->doctorID;
        $date2 = $schedule->getScheduleDataByID($scheduleID1)->date;

        $count1=$schedule->checkDocStatus($doctorID1,$date1);
        $count2=$schedule->checkDocStatus($doctorID2,$date2);

        $countDic=[
            "count1"=>$count1,
            "count2"=>$count2,

          
        ];
        

        
        $countArr=[];
        array_push($countArr,$countDic);

        
        $date = date('Y-m-d');

        echo  $date;
        //return $countArr;
        
    }
    
    // //公布正式班表
    // public function announceSchedule(){
        
    //     $schedule = new Schedule();

    
    //     $date2 = $schedule->getScheduleDataByID(2)->date;
    //     $weekday2 = (int)date('N', strtotime($date2));

    //     echo $weekday2;
       


 
    // }
     public function firstEditionShiftAddShifts(Request $request){
        $data = $request->all();

        $scheduleID1 = (int)$data['scheduleID_1'];
        $scheduleID2 = (int)$data['scheduleID_2'];

        $schedule = new Schedule();

        $schedule_1_Info = $schedule->getScheduleDataByID($scheduleID1);
        $schedule_2_Info = $schedule->getScheduleDataByID($scheduleID2);

        $shiftInfo = [
            'scheduleID_1' => $schedule_1_Info->scheduleID,
            'scheduleID_2' => $schedule_2_Info->scheduleID,
            'schID_1_doctor' => $schedule_1_Info->doctorID,
            'schID_2_doctor' => $schedule_2_Info->doctorID,
            'doc2Confirm' => 0,
            'adminConfirm' => 0,
            'date' => date('Y-m-d')
        ];

        $schedule_1_Date = $schedule_1_Info->date;

        $shiftRecords = new ShiftRecords();

        $newChangeSerial = $shiftRecords->addShifts($shiftInfo);

    }
    //單一醫生在假日班的狀況
     public function checkDocScheduleInWeekendByperson(){
        $schedule = new Schedule();
        $user = new User();

        $totalShift = $schedule->confirmNextMonthScheduleByDoctorID(3);
        $mustOnDuty = $user->getDoctorInfoByID(3)->mustOnDutyTotalShifts;

        echo $totalShift;
        echo $mustOnDuty;

    }
    
    // 測試刪除醫生上班時間的通知信件寄送工作
    public function deleteDoctorSchedule() {
        $schObj = new Schedule();
        
        $schData = $schObj->getScheduleDataByID(2);
        
        $schObj->deleteDoctorID(2);
        
        $job = new SendDeleteShiftMail($schData->doctorID, $schData->scheduleID);
        
        dispatch($job);
        
        echo 'The job has been put onto the queue';
    }
    
    // 測試申請換班通知信件寄送工作
    public function sendApplyEmailTest() {
        $job = new SendApplyShiftExchangeMail(6);
        dispatch($job);
        
        echo 'The job has been put onto the queue';
    }
    
    // 測試依據月份取得換班資訊
    public function getShiftRecordByMonth() {
        $month = '2017-09';
        
        // 依照月份取得排班人員已經認可的換班資訊
        $shiftRecordObj = new ShiftRecords();
        $shiftRecordsData = $shiftRecordObj->getShiftRecordsByMonth($month);
        
        // 建立顯示資料使用的model
        $userObj = new User();
        $schCateObj = new ScheduleCategory();
        $scheduleObj = new Schedule();
        
        // 將資料庫資料轉換為顯示用的資料
        $recordData = [];
        foreach($shiftRecordsData as $record) {
            // 取得醫生資料
            $doctor1 = $userObj->getDoctorInfoByID($record->schID_1_doctor);
            $doctor2 = $userObj->getDoctorInfoByID($record->schID_2_doctor);
            
            // 取得上班資料
            $schedule1 = $scheduleObj->getScheduleDataByID($record->scheduleID_1);
            $schedule2 = $scheduleObj->getScheduleDataByID($record->scheduleID_2);
            
            // 取得上班種類名稱
            $sch1Name = $schCateObj->getSchCateName($schedule1->schCategorySerial);
            $sch2Name = $schCateObj->getSchCateName($schedule2->schCategorySerial);
            
            array_push($recordData, [
                $doctor1->name,
                $doctor2->name,
                $schedule1->date,
                $schedule2->date,
                $sch1Name,
                $sch2Name,
                $record->changeSerial,
                $record->date
            ]);
        }
        
        return $recordData;
    }

   public function announceSchedule(){
$schedule = new Schedule();
        $user = new User();

        $reservation = new Reservation();
        $scheduleCategory = new ScheduleCategory();
$location=0;
       // if($user->getDoctorInfoByID(7)->location != $scheduleCategory->getSchCategoryInfo(4)){
                 if($schedule->getAnotherLocationShifts(6,"2018-01-12")>=2){
                    $location=1;
                // }


        
         }
     }
         // 公假測試
        public function officialLeave(){
        $schedule = new Schedule();
        $reservationData = new ReservationData();
        $user = new User();
        $announcement = new Announcement();
        $mustOnDutyShiftPerMonth = new MustOnDutyShiftPerMonth();
        $scheduleRecord = new ScheduleRecord();
        $officialLeave = new OfficialLeave();

        $doctorName = $user->getAtWorkDoctors();
        foreach($doctorName as $name){

            $date="2017-12";
           
            $mustOnDutyShiftArr=[
            'doctorID'=>$name->doctorID,
            'leaveMonth'=>$date
            ];

            $count= $mustOnDutyShiftPerMonth->countOnDutyShift($mustOnDutyShiftArr);

            if($count!=0){
                $mustOnDutyTotalShift = $mustOnDutyShiftPerMonth->getOnDutyShift($mustOnDutyShiftArr)->mustOnDutyShift; //應上
                $totalShift=$schedule->totalShift($name->doctorID); //已上
                $shifHours = $mustOnDutyTotalShift-$totalShift; //計算積欠或多餘
                $updateLeaveHours= $user->getDoctorInfoByID($name->doctorID)->currentOfficialLeaveHours-($shifHours*12);
                $officialLeave->updateLeaveHours($name->doctorID,$updateLeaveHours);
                //echo $shifHours;
            }
            else{
                $mustOnDutyTotalShift=$user->getDoctorInfoByID($name->doctorID)->mustOnDutyTotalShifts;
                $totalShift=$schedule->totalShift($name->doctorID); //已上
                $shifHours = $mustOnDutyTotalShift-$totalShift; //計算積欠或多餘
                $updateLeaveHours= $user->getDoctorInfoByID($name->doctorID)->currentOfficialLeaveHours-($shifHours*12);
                $officialLeave->updateLeaveHours($name->doctorID,$updateLeaveHours);
             }

    }
    
        
           
         }
         
    
    public function sch2() {
        $job = new Schedule2();
        
        dispatch($job);
    }
    
    // 取得特定醫師在那一週的非職登院區上班班數
    public function getAnotherLocationShifts() {
        $doctorID = 1;
        $date = '2017-10-06';
        
        echo 'Week number : '.date('W', strtotime($date)).'<br>';
        
        echo '星期：'.date('N', strtotime($date)).'<br>';
        
        $week = intval(date('N', strtotime($date)));
        
        //  get monday
        // 與星期一的差距
        $mondayGap = $week - 1;
        // 顯示星期一的日期
        echo date('Y-m-d', strtotime($date.'-'.$mondayGap.' days')).'<br>';
        
        // get sunday
        // 與星期日的差距
        $sundayGap = 7 - $week;
        echo date('Y-m-d', strtotime($date.'+'.$sundayGap.' days')).'<br>';
    }
    
    public function sendFakeMail() {
        // 提出申請
//        Mail::to('georgelesliemackay0@gmail.com')->send(new FakeMail());
        // 同意申請
//        Mail::to('georgelesliemackay0@gmail.com')->send(new FakeMail2());
        // 排班人員確認申請1
//        Mail::to('georgelesliemackay0@gmail.com')->send(new FakeMail3());
        // 排班人員確認申請2
//        Mail::to('georgelesliemackay0@gmail.com')->send(new FakeMail4());
        
        // 寄送通知信函
        $job = new SendFakeMails();
        echo 'The jobs have been stored to the database';
        
        dispatch($job);
    }
}

