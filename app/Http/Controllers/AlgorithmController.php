<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// send a request
use GuzzleHttp\Client;

// 演算法用
use App\Reservation;
use App\DoctorAndReservation;
use App\ShiftCategory;

// import customized class
use App\CustomClass\OnReservation;
use App\CustomClass\OffReservation;

class AlgorithmController extends Controller
{
    //
    // send a request to the web service
    public function sendRequest() {
        $onResList = $this->getOnReservation();
        $offResList = $this->getOffReservation();
        
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
            
            array_push($onResList, new OnReservation($day, $location, $dayOrNight, $doctorsID));
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
            
            array_push($offResList, new OffReservation($day, $doctorsID));
        }
        
        return $offResList;
    }
}
