<?php
namespace App\CustomClass;

class Month {
    private $year = 0; // 西洋年份4位數 ex:2017
    private $month = 0; // 月份
    private $daysOfMonth = 0; // 當月的天數
    private $firstDay = 0; // 當月的1號是星期幾，星期一為1，星期日為7
    
    function __construct($year = 0, $month = 0, $daysOfMonth = 0, $firstDay = 0) {        
        $this->year = $year;
        $this->month = $month;
        $this->daysOfMonth = $daysOfMonth;
        $this->firstDay = $firstDay;
    }
}