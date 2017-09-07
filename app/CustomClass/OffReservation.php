<?php
namespace App\CustomClass;

class OffReservation {
    $day = 0;
    doctorsID = [];
    
    function __construct($day = 0, $doctors = []) {
        $this->day = $day;
        $this->doctorsID = $doctors;
    }
}