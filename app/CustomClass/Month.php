<?php
namespace App\CustomClass;

class Month {
    public $year = 0; // 西洋年份4位數 ex:2017
    public $month = 0; // 月份
    public $daysOfMonth = 0; // 當月的天數
    public $firstDay = 0; // 當月的1號是星期幾，星期一為1，星期日為7
    
    function __construct($year = 0, $month = 0, $daysOfMonth = 0, $firstDay = 0) {        
        $this->year = $year;
        $this->month = $month;
        $this->daysOfMonth = $daysOfMonth;
        $this->firstDay = $firstDay;
    }
    
    public function printData() {
        echo 'Year : '.$this->year.'<br>';
        echo 'Month : '.$this->month.'<br>';
        echo 'Days : '.$this->daysOfMonth.'<br>';
        echo 'First day : '.$this->firstDay.'<br>';
    }
}