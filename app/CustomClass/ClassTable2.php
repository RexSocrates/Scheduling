<?php
namespace App\CustomClass;

class ClassTable2 {
    // 每一天的所有班為一個物件
    
    // 排班月份的第幾天
    public $day = 0;
    // 陣列儲存行政與教學班以外的班，index 為 1~19
    public $shifts = [];
    
    function __construct($day = 0, $shifts = []) {
        $this->day = $day;
        
        // 確保記憶體位置分開
        for($index = 0; $index < count($shifts); $index++) {
            array_push($this->shifts, $shifts[$index]);
        }
    }
}