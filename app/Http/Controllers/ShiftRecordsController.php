<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ShiftRecords;

class ShiftRecordsController extends Controller
{
    //
    public  function  shiftRecords($id){
         $shiftRecords = new ShiftRecords();
         $shiftRecordsData = $shiftRecords->shiftRecordsList();

         return view ("shiftRecords",array('shiftRecords' => $shiftRecordsData));

    } 
}
