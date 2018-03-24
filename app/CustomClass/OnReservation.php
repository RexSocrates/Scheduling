<?php
namespace App\CustomClass;

class OnReservation {
    public $day = 0; // 此月的第幾天
    public $location = ''; // 此預約的院區
    public $dayOrNight = ''; // 此預約屬於白天或晚上
    public $doctorsID = []; // 有此預約的醫師ID
    
    function __construct($day = 0, $location = '', $dayOrNight = '', $doctors = []) {
        $this->day = $day;
        $this->location = $location;
        $this->dayOrNight = $dayOrNight;
        $this->doctorsID = $doctors;
    }
    
    // 印出所有資料
    function printData() {
        echo '第幾天：'.$this->day.'<br>';
        echo '院區：'.$this->location.'<br>';
        echo '白天/夜晚：'.$this->dayOrNight.'<br>';
        echo '醫生：<br>';
        foreach($this->doctorsID as $doctorID) {
            echo 'ID : '.$doctorID.'<br>';
        }
        echo '<br>';
    }
}