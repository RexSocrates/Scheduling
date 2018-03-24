<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Dhtmlx\Connector\SchedulerConnector;
use App\Http\Controllers;

// model
use App\Reservation;
use App\DoctorAndReservation;
use App\ShiftCategory;
use App\Remark;
use App\User;
use App\ReservationData;
use App\MustOnDutyShiftPerMonth;
use App\OfficialLeave;

// jobs
use App\Jobs\SendRandomNotificationMail;

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

    //單一醫生預班資訊 
    public function getReservationByID() {
        $reservation = new Reservation();
        $shiftCategory = new ShiftCategory();
        $user = new User();
        $remark = new Remark();
        $reservationData = new ReservationData();

        $data = array();

        
        $month = date('Y-m');
        $nextMonth=date("Y-m",strtotime($month."+1 month"));

        if($reservationData->countMonth($nextMonth)!=0){
            $startDate = $nextMonth."-".$reservationData->getDate($nextMonth)->startDate;
            $endDate = $nextMonth."-".$reservationData->getDate($nextMonth)->endDate;
        }
        else{
            $startDate = $month."-".$reservationData->getDate($month)->startDate;
            $endDate = $month."-".$reservationData->getDate($month)->endDate;
        }

        $reservationData = $reservation->getReservationByID();
        //$reservationData = $reservation->getNextMonthReservationByID();
        
        $doctorID = $user->getCurrentUserID();
        $doctorDay = $user->getDoctorInfoByID($doctorID)->mustOnDutyDayShifts;
        $doctorNight = $user->getDoctorInfoByID($doctorID)->mustOnDutyNightShifts;        
        $countDay = $doctorDay-$reservation->amountDayShifts();
        $countNight = $doctorNight-$reservation->amountNightShifts();
        
        $getDoctorRemark=$remark->getNextRemarkByDoctorID($doctorID);

        foreach ($reservationData as $res) {
            $name = $shiftCategory->findName($res->categorySerial);
            //$res->categorySerial = $name;
            array_push($data, array($res, $name));
        }
        $doctorRemark="";

        if($getDoctorRemark==null){
            $doctorRemark="";
        }
        else{
            $doctorRemark=$getDoctorRemark->remark;
        }
        
        // 取得醫生在排班月份申請的公假
        $modSfhitObj = new MustOnDutyShiftPerMonth();
//        $leaveShifts = $modSfhitObj->getResMonthLeaveShift($doctorID);
        
        
        $leaveObj = new OfficialLeave();
        $leaveShifts = $leaveObj->getResMonthConfirmLeaves();
//        echo 'Leave shifts : '.$leaveShifts.'<br>';
//        echo 'Ans : '..'<br>';
        
        // 取得該醫生的應上總班數，需要先扣掉醫生申請的公假
        $onResLimit = (int)(($user->getCurrentUserInfo()->mustOnDutyTotalShifts - $leaveShifts) * 2 / 3);
        // 可預約的off班數量改為臨床總班數的1/2
        $offResLimit = (int)(($user->getCurrentUserInfo()->mustOnDutyTotalShifts - $leaveShifts) / 2);
        
        // 取得醫生預約的on班與off班數量
        $docAndResObj = new DoctorAndReservation();
        $onResAmount = $onResLimit - $docAndResObj->getNextMonthOnResAmount($user->getCurrentUserID());
        $offResAmount = $offResLimit - $docAndResObj->getNextMonthOffResAmount($user->getCurrentUserID());
        



        return view('pages.reservation', [
            'startDate' => $startDate,
            'endDate' =>  $endDate,
            'reservations' => $data,
            'countDay' => $countDay,
            'countNight' => $countNight,
            'doctorDay' =>$doctorDay,
            'doctorNight'=> $doctorNight,
            'onAmount' => $onResAmount,
            'offAmount' => $offResAmount,
            'remark'=> $doctorRemark,
            'currentdate'=>date("Y-m-d")
        ]);
        
    }

    //計算尚須上的白夜班 
    public function countDay(){
        $user = new User();
        $reservation=new Reservation();

        $doctorID = $user->getCurrentUserID();
        $doctorDay = $user->getDoctorInfoByID($doctorID)->mustOnDutyDayShifts;
        $doctorNight = $user->getDoctorInfoByID($doctorID)->mustOnDutyNightShifts;        
        $countDay = $doctorDay-$reservation->amountDayShifts();
        $countNight = $doctorNight-$reservation->amountNightShifts();

        $array = array($countDay,$countNight);

        return $array;

    }


    public function renderData() {
//        $connector = new SchedulerConnector($Reservation, "PHPLaravel");
//        $connector->configure(new Reservation(), "resSerial", "date, endDate, categorySerial");
//        $connector->render();
        // $connector->render_table('DoctorAndReservation','resSerial','doctorID');
        
        $connector = new SchedulerConnector(null, "PHPLaravel");
//        $connector->configure('Reservation', "resSerial", "date, endDate, categorySerial");
        $connector->configure(new Reservation(), "resSerial", "periodSerial, isWeekday, location, isOn, date, endDate, categorySerial");
        $connector->render();
    }

    //增加備註
    public  function addRemark(){
        $remark = new Remark();
        $user = new User();
        $doctorID = $user->getCurrentUserID();
        
        $addRemark = Input::get('remark');
        
        if($addRemark==null){
            $addRemark="";
        }
        
        $remarkData = $remark->modifyRemarkByDoctorID($doctorID,$addRemark);

        
        return redirect('reservation');
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
    public function addReservation(Request $request){
        $data = $request->all();
        
        $serial = (int)$data['serial'];
        $str = $data['date1'];
        $end = $data['date2'];
        
        $dateArr = explode(' ', $str);
        $endDateArr = explode(' ', $end);

        if( $dateArr[3] % 400 ==0 || (($dateArr[3]%4==0)&&($dateArr[3]%100!=0)) ){
            if($dateArr[1] == 'Feb'){
                $endDateArr[2] =30;
            }
        }
        else {
            if($endDateArr[2] == 1 ){
                if($dateArr[1] == 'Feb'){
                    $endDateArr[2] =29;
                }
                if($dateArr[1] == 'Jan' || $dateArr[1] == 'Mar' || $dateArr[1] == 'May' || $dateArr[1] == 'Jul' || $dateArr[1] == 'Aug' || $dateArr[1] == 'Oct' || $dateArr[1] == 'Dec'){
                    $endDateArr[2] =32;
                }
                if($dateArr[1] == 'Apr' || $dateArr[1] == 'Jun' || $dateArr[1] == 'Sep' || $dateArr[1] == 'Nov'){
                    $endDateArr[2] =31;
                }
            }
        }

        $countDay = abs($endDateArr[2]-$dateArr[2]);

        $shiftCategory = new ShiftCategory();
        
        $categoryInfo = $shiftCategory->getCategoryInfo($serial);
        
        $resObj = new Reservation();
        $docAndRes = new DoctorAndReservation();
        $user = new User();

        $date = $this->processDateStr($str);

        for($i = 1; $i <= $countDay; $i++){

            $resInfo = [
                'isWeekday' => true,
                'location' => $categoryInfo['location'],
                'isOn' => $categoryInfo['isOn'],
                'date' => $date,
                'categorySerial' => $serial
            ];

            if(strcmp($dateArr[0],"Sat") == 0 or strcmp($dateArr[0],"Sun") == 0) {
                $resInfo['isWeekday'] = false;
            }

            $newSerial = $resObj->addOrUpdateReservation($resInfo);

            $darData = [
            'resSerial' => $newSerial,
            'doctorID' =>  $user->getCurrentUserID(),
            ];

            $docAndRes->addDoctor($darData);

            // 遇同一份預班有過多的人時寄送通知信件
            $count = $docAndRes->amountInResserial($newSerial);
        
            if($shiftCategory->exceedLimit($count, $serial)) {
            $this->sendRandomNotificationMail($newSerial);
            }

            $date=date("Y-m-d",strtotime($date."+1 day"));
        }
        
    }
    
    // 刪除預班
    public function deleteReservation(Request $request){
        $data = $request->all();
        
        $docAndRes = new DoctorAndReservation();
        $userObj = new User();
        
        $docAndRes->deleteReservation($data['resSerial'], $userObj->getCurrentUserID());
    }
    
    //更新預班
    public function updateReservation(Request $request){
        $data = $request->all();
        
        $resSerial = (int)$data['resSerial'];
        $categorySerial = (int)$data['categorySerial'];
        $startDateStr = $data['startDate'];
        
        $shiftCategory = new ShiftCategory();
        
        $categoryInfo = $shiftCategory->getCategoryInfo($categorySerial);
        
        $resInfo = [
            'isWeekday' => true,
            'location' => $categoryInfo['location'],
            'isOn' => $categoryInfo['isOn'],
            'date' => $this->processDateStr($startDateStr),
            'categorySerial' => $categorySerial
        ];
        
        $dateArr = explode(' ', $startDateStr);
        
        // 判斷平日/假日
        if(strcmp($dateArr[0],"Sat") == 0 or strcmp($dateArr[0],"Sun") == 0) {
            $resInfo['isWeekday'] = false;
        }
        
        $resObj = new Reservation();
        
        $newSerial = $resObj->addOrUpdateReservation($resInfo);
        
        // Doctor and reservation 的資料更新
        $docAndResObj = new DoctorAndReservation();
        $userObj = new User();
        $docAndResObj->doctorUpdateReservation($resSerial, $newSerial, $userObj->getCurrentUserID());

        // 遇同一份預班有過多的人時寄送通知信件
        $count = $docAndResObj->amountInResserial($newSerial);
        
        if($shiftCategory->exceedLimit($count, $categorySerial)) {
            $this->sendRandomNotificationMail($newSerial);
        }

    }

    public function getDataByID() {
        $serial = Input::get('serial');
        return view('updateReservation', ['serial' => $serial] );

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
    
    // 預約人數過多時寄送通知信件
    public function sendRandomNotificationMail($resSerial) {
        //$job = new SendRandomNotificationMail($resSerial);
        
        //dispatch($job);
    }
}
