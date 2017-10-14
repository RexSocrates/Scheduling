<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// import the class to send a request
use GuzzleHttp\Client;

// 演算法用的model
use App\User;
use App\Reservation;
use App\DoctorAndReservation;
use App\ShiftCategory;

// 導入客製化物件
use App\CustomClass\OnReservation;
use App\CustomClass\OffReservation;
use App\CustomClass\Doctor;
use App\CustomClass\Month;

// import jobs
use App\Jobs\Schedule;
use App\Jobs\Schedule2;

class AlgorithmController extends Controller
{
    // send a GET request
    public function sendGetRequest() {
        $client = new Client(['base_uri' => 'http://0.0.0.0:8080/']);
        $response = $client->request('GET', '');
        
        $body = $response->getBody();
        
        echo $body;
    }
    
    // send a request to the web service
    public function sendRequest() {
        
        
//        $client = new Client(['base_uri' => 'http://0.0.0.0:8080/']);
//        
//        $response = $client->request('POST', '', [
//            'json' => [
//                'onRes' => json_encode($this->getOnReservation()),
//                'offRes' => json_encode($this->getOffReservation()),
//                'doctors' => json_encode($this->getDoctorsInfo()),
//                'monthInfo' => json_encode($this->getMonthInfo())
//            ]
//        ]);
        
        // get response body
//        $body = (string)$response->getBody();
//        echo $body.'<br><br>';
//        $json = json_encode($body);
//        echo print_r($json).'<br><br>'; // data
//        echo gettype($json); // string
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        // 測試：取得資料庫並轉譯為json
        $onResList = $this->getOnReservation();
//        foreach($onResList as $res) {
//            $res->printData();
//        }
        echo '<br>==================================================<br>';
        echo json_encode($onResList);
        
        echo '<br>==================================================<br>';
        
        $offResList = $this->getOffReservation();
//        foreach($offResList as $res) {
//            $res->printData();
//        }
        echo json_encode($offResList);
        
        echo '<br>==================================================<br>';
        
        $doctors = $this->getDoctorsInfo();
//        foreach($doctors as $doctor) {
//            $doctor->printData();
//        }
        
        echo json_encode($doctors);
        
        echo '<br>==================================================<br>';
        
        $monthInfo = $this->getMonthInfo();
//        $monthInfo->printData();
        echo json_encode($monthInfo);
    }
    
    // 測試 schedule job
    public function testScheduleJobs() {
        ini_set('max_execution_time', 0);
        echo 'Header=========================================================<br>';
        $job = new Schedule2();
        
        dispatch($job);
        echo 'Footer=========================================================<br>';
    }
    
    public function testSyntax() {
        $arr = [];
        
        for($i = 0; $i < 10; $i++) {
            array_push($arr, rand(1, 10));
        }
        
        echo 'Arr<br>';
        echo print_r($arr).'<br>';
        
        $arr2 = [];
        foreach($arr as $item) {
            array_push($arr2, $item);
        }
        
        for($i = 0; $i < 10; $i++) {
            array_push($arr2, rand(1, 10));
        }
        
        $arr2[3] = 100;
        
        echo print_r($arr2);
    }
    
    // 取得演算法使用的on班資訊
    private function getOnReservation() {
        $resObj = new Reservation();
        $docAndResObj = new DoctorAndReservation();
        $shiftCateObj = new ShiftCategory();
        
        $onResList = [];
        
        $reservations = $resObj->getNextMonthOnReservation();
        
        foreach($reservations as $res) {
            // 取得當月的第幾天
            $date = $res->date;
            $day = (int)explode('-', $date)[2];
            
            // 取得院區
            $location = '';
            if($res->location == 'Taipei') {
                $location = 'T';
            }else {
                $location = 'D';
            }
            
            // 取得白天或晚上
            $dayOrNight = '';
            $cateInfo = $shiftCateObj->getCategoryInfo($res->categorySerial);
            if($cateInfo['dayOrNight'] == 'day') {
                $dayOrNight = 'd';
            }else {
                $dayOrNight = 'n';
            }
            
            // 有預約此預班的醫生代號
            $doctorsID = $docAndResObj->getDoctorsByResSerial($res->resSerial);
            $doctorArr = [];
            foreach($doctorsID as $doctorObj) {
                array_push($doctorArr, $doctorObj->doctorID);
            }
            
            array_push($onResList, new OnReservation($day, $location, $dayOrNight, $doctorArr));
        }
        
        return $onResList;
    }
    
    // 取得演算法用的off班資訊
    private function getOffReservation() {
        $resObj = new Reservation();
        $docAndResObj = new DoctorAndReservation();
        
        $offResList = [];
        
        $reservations = $resObj->getNextMonthOffReservation();
        
        foreach($reservations as $res) {
            // 取得當月的第幾天
            $date = $res->date;
            $day = (int)explode('-', $date)[2];
            
            // 有預約此預班的醫生代號
            $doctorsID = $docAndResObj->getDoctorsByResSerial($res->resSerial);
            $doctorArr = [];
            foreach($doctorsID as $doctorObj) {
                array_push($doctorArr, $doctorObj->doctorID);
            }
            
            array_push($offResList, new OffReservation($day, $doctorArr));
        }
        
        return $offResList;
    }
    
    // 取得演算法用的醫生資訊
    private function getDoctorsInfo() {
        $userObj = new User();
        
        $doctors = $userObj->getAtWorkDoctors();
        
        // 演算法用的陣列
        $doctorsList = [];
        $numberOfWeeks = $this->getWeeksOfMonth();
        
        foreach($doctors as $doctor) {
            $doctorDic = [
                'doctorID' => $doctor->doctorID,
                'major' => '',
                'totalShifts' => $doctor->mustOnDutyTotalShifts,
                'dayShifts' => $doctor->mustOnDutyDayShifts,
                'nightShifts' => $doctor->mustOnDutyNightShifts,
                'weekendShifts' => $doctor->weekendShifts,
                'location' => '',
                'taipeiShiftsLimit' => 0,
                'tamsuiShiftsLimit' => 0,
                'surgicalShifts' => $doctor->mustOnDutySurgicalShifts,
                'medicalShifts' => $doctor->mustOnDutyMedicalShifts,
                'numberOfWeeks' => $numberOfWeeks
            ];
            
            // 專職科別
            if($doctor->major == 'All') {
                $doctorDic['major'] = 'all';
            }else if($doctor->major == 'Medical') {
                $doctorDic['major'] = 'med';
            }else {
                $doctorDic['major'] = 'sur';
            }
            
            // 職登院區與各院區上班班數上限
            if($doctor->location == '台北') {
                $doctorDic['location'] = 'T';
                $doctorDic['taipeiShiftsLimit'] = $doctor->mustOnDutyTotalShifts;
                $doctorDic['tamsuiShiftsLimit'] = (int)($doctor->mustOnDutyTotalShifts * 0.5);
            }else {
                $doctorDic['location'] = 'D';
                $doctorDic['tamsuiShiftsLimit'] = $doctor->mustOnDutyTotalShifts;
                $doctorDic['taipeiShiftsLimit'] = (int)($doctor->mustOnDutyTotalShifts * 0.5);
            }
            
            // 扣除自己的測試醫生帳號
            if($doctor->doctorID != 1) {
                array_push($doctorsList, new Doctor($doctorDic));
            }
        }
        
        return $doctorsList;
    }
    // 取得排班月資訊
    private function getMonthInfo() {
        
        $currentDateStr = date('Y-m-d');
        $dateArr = explode('-', $currentDateStr);
        
        // 將年與月轉換為數字
        $year = (int)$dateArr[0];
        $month = (int)$dateArr[1];
        
        // 調整至排班的月份
        $month = ($month + 1) % 12;
        if($month == 1) {
            $year += 1;
        }
        
//        echo 'Year : '.$year.'<br>';
//        echo 'Month : '.$month.'<br>';
        
        // 計算當月有幾天，取得排班次月第一日後往前推一天
        $theMonthAfter = ($month + 1) % 12;
        $nextMonthFirstDay = '';
        if($theMonthAfter == 1) {
            $nextMonthFirstDay = ($year + 1).'-'.$theMonthAfter.'-01';
        }else {
            $nextMonthFirstDay = $year.'-'.$theMonthAfter.'-01';
        }
        
        $lastDayOfMonth = date('Y-m-d', strtotime($nextMonthFirstDay.'-1 day'));
//        echo 'The last day of the scheduling month : '.$lastDayOfMonth.'<br>';
        
        $daysOfMonth = (int)(explode('-', $lastDayOfMonth)[2]);
//        echo 'Days of the scheduling month : '.$daysOfMonth.'<br>';
        
        // 取得1號是星期幾
        $firstDay = date('N', strtotime($year.'-'.$month.'-01'));
//        echo 'The day of first day in the month : '.$firstDay.'<br>';
        
        return new Month($year, $month, $daysOfMonth, $firstDay);
    }
    
    // 計算排班當月有幾週
    private function getWeeksOfMonth() {
        $currentDateStr = date('Y-m-d');
        $dateArr = explode('-', $currentDateStr);
        
        // 將年與月轉換為數字
        $year = (int)$dateArr[0];
        $month = (int)$dateArr[1];
        
        // 調整至排班的月份
        $month = ($month + 1) % 12;
        if($month == 1) {
            $year += 1;
        }
        
        // 計算當月有幾天，取得排班次月第一日後往前推一天
        $theMonthAfter = ($month + 1) % 12;
        $nextMonthFirstDay = '';
        if($theMonthAfter == 1) {
            $nextMonthFirstDay = ($year + 1).'-'.$theMonthAfter.'-01';
        }else {
            $nextMonthFirstDay = $year.'-'.$theMonthAfter.'-01';
        }
        
        $lastDayOfMonth = date('Y-m-d', strtotime($nextMonthFirstDay.'-1 day'));
        $daysOfMonth = (int)(explode('-', $lastDayOfMonth)[2]);
        
        
        $numberOfWeeks = 0;
        $weekStart = true;
        for($i = 1; $i <= $daysOfMonth; $i++) {
            $dateStr = '';
            if($i < 10) {
                $dateStr = $year.'-'.$month.'-0'.$i;
            }else {
                $dateStr = $year.'-'.$month.'-'.$i;
            }
            // monday is 1, sunday is 7
            $weekDay = (int)date('N', strtotime($dateStr));
            
            if($weekDay == 7) {
                // 星期天，一週的結束
                $numberOfWeeks++;
                $weekStart = false;
                
//                echo 'The end of week '.$dateStr.'<br>';
//                echo 'Week number : '.$numberOfWeeks.'<br><br>';
            }
            if($weekDay == 1) {
                // 星期一，一週的開始
                $weekStart = true;
//                echo 'The start of week '.$dateStr.'<br>';
//                echo 'Week number : '.$numberOfWeeks.'<br><br>';
            }
        }
        if($weekStart == true) {
            // 雖然不是完整的一星期，但已涵蓋此一星期
            $numberOfWeeks++;
//            echo 'Last week number : '.$numberOfWeeks.'<br>';
        }
        
        return $numberOfWeeks;
    }
}
