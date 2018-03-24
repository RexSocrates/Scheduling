<?php
namespace App\CustomClass;

class OffReservation {
    public $day = 0; // 此月的第幾天
    public $doctorsID = []; // 有此預約的醫生ID
    
    function __construct($day = 0, $doctors = []) {
        $this->day = $day;
        $this->doctorsID = $doctors;
    }
    
    // 印出所有資料
    function printData() {
        echo '第幾天：'.$this->day.'<br>';
        echo '醫生：<br>';
        foreach($this->doctorsID as $doctorID) {
            echo 'ID : '.$doctorID.'<br>';
        }
        echo '<br>';
    }
}