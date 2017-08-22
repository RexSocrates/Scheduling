<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use App\User;
use App\Remark;
use App\Announcement;
use App\ShiftCategory;
use App\Reservation;
use App\DoctorAndReservation;
use App\Schedule;
use App\ShiftRecords;

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
    
    public function processDateStr($dateStr) {
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


     public function shiftFirstEditionAddShifts(Request $request){
            //$data = $request->all();

            //$scheduleID1 = $data['scheduleID_1'];
            //$scheduleID2 = $data['scheduleID_2'];

            $scheduleID1=6;
            $scheduleID2=1;

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
    
}
