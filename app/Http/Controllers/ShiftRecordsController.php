<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ShiftRecords;
use Illuminate\Support\Facades\Input;

class ShiftRecordsController extends Controller
{
    //列出所有換班紀錄
    public  function  shiftRecords(){
         $shiftRecords = new ShiftRecords();
         $shiftRecordsData = $shiftRecords->shiftRecordsList();

         return view ("shiftRecords",array('shiftRecords' => $shiftRecordsData));

    } 

    //新增換班
    public function addShifts(){
    		$addShifts = new ShiftRecords();
    		$scheduleID_1 = Input::get('scheduleID_1');
    		$scheduleID_2 = Input::get('scheduleID_2');
    		$schID_1_doctor = Input::get('schID_1_doctor');
    		$schID_2_doctor = Input::get('schID_2_doctor');
            $created_at = date('Y-m-d:h-m-s'); //????
            $doc2Confirm = 1;
            $adminConfirm = 1;

    		$newShiftSerial = $addShifts->addShifts($scheduleID_1,$scheduleID_2,$schID_2_doctor,$schID_2_doctor,$doc2Confirm,$adminConfirm,$created_at);

    		 return redirect('shiftRecords'); 

    }

    //醫生確認換班
    public function doc2Confirm($id){
        $update = new ShiftRecords();
        $doc2Confirm = Input::get('doc2Confirm');

        $updatedDoc2Confirm = $update->doc2Confirm($id,$doc2Confirm);

         return redirect('shiftRecords'); 

    }

    //排班人員確認換班
    public function adminConfirm($id){
        $update = new ShiftRecords();
        $adminConfirm = Input::get('adminConfirm');

        $updatedDoc2Confirm = $update->doc2Confirm($id,$adminConfirm);

         return redirect('shiftRecords'); 

    }

}
