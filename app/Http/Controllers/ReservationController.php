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

        $data = array();

        $reservationData = $reservation->getReservationByID();
        $doctorID = $user->getCurrentUserID();
        $doctorDay = $user->getDoctorInfoByID($doctorID)->mustOnDutyDayShifts;
        $doctorNight = $user->getDoctorInfoByID($doctorID)->mustOnDutyNightShifts;        
        $countDay = $doctorDay-$reservation->amountDayShifts();
        $countNight = $doctorNight-$reservation->amountNightShifts();
        
        $getDoctorRemark=$remark->getRemarkByDoctorID($doctorID);
       

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
        return view('pages.reservation', [
            'reservations' => $data,
            'countDay' => $countDay,
            'countNight' => $countNight,
            'doctorDay' =>$doctorDay,
            'doctorNight'=> $doctorNight,
            'remark'=> $doctorRemark
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

      // public function renderData() {
      //   $connector = new SchedulerConnector(null, "PHPLaravel");
      //   $connector->configure(new Reservation(), "resSerial", "date, endDate, categorySerial");
      //   $connector->render();
      //  // $connector->render_table('DoctorAndReservation','resSerial','doctorID');
       

      // }



    //增加備註
    public  function addRemark(){
        $remark = new Remark();
        $user = new User();
        $doctorID = $user->getCurrentUserID();
        $addRemark = Input::get('remark');
        
        $remarkData = $remark->addRemark($doctorID,$addRemark);

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
        
        $shiftCategory = new ShiftCategory();
        
        $categoryInfo = $shiftCategory->getCategoryInfo($serial);
        
        $resInfo = [
            'isWeekday' => true,
            'location' => $categoryInfo['location'],
            'isOn' => $categoryInfo['isOn'],
            'date' => $this->processDateStr($str),
            'categorySerial' => $serial
        ];
        
        
        $dateArr = explode(' ', $str);
        // 判斷平日/假日
        if(strcmp($dateArr[0],"Sat") == 0 or strcmp($dateArr[0],"Sun") == 0) {
            $resInfo['isWeekday'] = false;
        }
        
        $resObj = new Reservation();
        
        $newSerial = $resObj->addOrUpdateReservation($resInfo);
        
        
        $docAndRes = new DoctorAndReservation();
        $user = new User();
        
        $darData = [
            'resSerial' => $newSerial,
            'doctorID' => $user->getCurrentUserID(),
        ];

        $docAndRes->addDoctor($darData);

        $count = $docAndRes->amountInResserial($newSerial);

        if($serial==3){     //台北白班
            if($count>=2){

            }
        }
        if($serial==4){     //台北夜班
            if($count>=2){
                
            }
        }
        if($serial==5){     //淡水白班
            if($count>=2){
                
            }
        }
        if($serial==3){     //淡水夜班
            if($count>=2){
                
            }
        }
        
    }
    
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

        $count = $docAndRes->amountInResserial($newSerial);

        if($serial==3){     //台北白班
            if($count>=2){

            }
        }
        if($serial==4){     //台北夜班
            if($count>=2){
                
            }
        }
        if($serial==5){     //淡水白班
            if($count>=2){
                
            }
        }
        if($serial==3){     //淡水夜班
            if($count>=2){
                
            }
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
    
    
}
