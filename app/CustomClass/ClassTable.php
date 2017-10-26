<?php
namespace App\CustomClass;

class ClassTable {
    // 創造單一物件的function
    public $year = 0;
    public $month = 0;
    public $date = 0;
    public $day = 0;
    public $class_id = 0;
    public $holiday = 0;
    public $section = 0;
    public $class_sort = 0;
    public $doctor_id = '';
    public $hospital_area = '';
    public $offc = [];
    public $week_num = 0;
    public $reservation = false;
    
    
    function __construct($year = 0, $month = 0, $date = 0, $day = 0, $class_id = 0, $holiday = 0, $section = 0, $class_sort = 0, $doctor_id = '', $hospital_area = '', $offc = [] , $week_num = 0 , $reservation = false) {
        $this->year = $year;                        // 年
        $this->month = $month;                      // 月
        $this->date = $date;                        // 日
        $this->day = $day;                          // 星期
        $this->class_id = $class_id;                // 該班編號
        $this->holiday = $holiday;                  // 是否為假日
        $this->section = $section;                  // 科別
        $this->class_sort = $class_sort;            // 班別(早晚班)
        $this->doctor_id = $doctor_id;              // 醫生ID
        $this->hospital_area = $hospital_area;      // 該班院區
        $this->offc = $offc;                        // 哪位醫師預OFF班
        $this->week_num = $week_num;                // 為本月第幾個星期
        $this->reservation = $reservation;          // 是否為預班，如果為預班=True，預設為False
    }
}