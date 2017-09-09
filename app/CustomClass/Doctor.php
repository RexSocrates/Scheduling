<?php
namespace App\CustomClass;

class Doctor {
    
    private $doctorID = 0; // 醫師ID
    private $major = ''; // 專職科別
    private $totalShifts = 0; // 總班數
    private $dayShifts = 0; // 白天班數
    private $nightShifts = 0; // 夜晚班數
    private $weekendShifts = 0; // 假日班數
    private $location = ''; // 所屬院區
    private $taipeiShiftsLimit = 0; // 在台北院區可上的班數的上限
    private $tamsuiShiftsLimit = 0; // 在淡水院區可上的班數的上限
    private $surgicalShifts = 0; // 外科班數
    private $medicalShifts = 0; // 內科班數
    
    // 以下部分在此類別產生
    private $lostShfits = 0; // 沒選上預約的班的數量
    private $otherLocationShifts = []; // 存放每週在非職登院區上班的班數，當月有幾週就給幾個0
    
    public function __construct($doctorDic) {
        $this->doctorID = $doctorDic['doctorID'];
        $this->major = $doctorDic['major'];
        $this->totalShifts = $doctorDic['totalShifts'];
        $this->dayShifts = $doctorDic['dayShifts'];
        $this->nightShifts = $doctorDic['nightShifts'];
        $this->weekendShifts = $doctorDic['weekendShifts'];
        $this->location = $doctorDic['location'];
        $this->taipeiShiftsLimit = $doctorDic['taipeiShiftsLimit'];
        $this->tamsuiShiftsLimit = $doctorDic['tamsuiShiftsLimit'];
        $this->surgicalShifts = $doctorDic['surgicalShifts'];
        $this->medicalShifts = $doctorDic['medicalShifts'];
        
        $this->lostShfits = 0;
        
        $numberOfWeeks = $doctorDic['numberOfWeeks'];
        for($i = 1; $i <= $numberOfWeeks; $i++) {
            array_push($this->otherLocationShifts, 0);
        }
    }
    
    public function printData() {
        echo 'Doctor ID : '.$this->doctorID.'<br>';
        echo '所屬院區 : '.$this->location.'<br>';
        echo '台北院區上班限制 : '.$this->taipeiShiftsLimit.'<br>';
        echo '淡水院區上班限制 : '.$this->tamsuiShiftsLimit.'<br>';
        echo 'Number of weeks : ';
        echo print_r($this->otherLocationShifts).'<br><br>';
    }
}