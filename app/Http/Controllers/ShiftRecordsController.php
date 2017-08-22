<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

// import model
use App\ShiftRecords;
use App\Schedule;
use App\User;
use App\ScheduleCategory;
use App\Remark;

// import jobs
use App\Jobs\SendAgreeShiftExchangeMail;
use App\Jobs\SendDenyShiftExchangeMail;

class ShiftRecordsController extends Controller
{
    //列出 新增換班 所有換班紀錄  醫生確認換班
    public  function  shiftRecords(Request $request){
        $shiftRecords = new ShiftRecords();
        $schedule = new Schedule();
        $user = new User();

        $currentDoctor = $user->getCurrentUserInfo();

        
        $allShiftData = $shiftRecords->getMoreCheckShiftsRecordsInformation(false);  // 列出所有待確認換班資訊

        $shiftDataByDoctorID = $shiftRecords->getMoreUncheckShiftsRecordsInformation(true); //換班待確認

        $currentDoctorSchedule=$schedule->getScheduleByCurrentDoctorID(); //查看目前登入的醫生班表資訊

         
        //選擇換班醫生
        $doctorName = $user->getAtWorkDoctors();
        $doctorSchedule = $schedule->getScheduleByDoctorID(2); //之後用ajax傳入id




        //換班確認
        return view ("pages.first-edition-shift",array('shiftRecords'=>$allShiftData,'shiftDataByDoctorID'=>$shiftDataByDoctorID,'currentDoctor'=>$currentDoctor,'currentDoctorSchedule'=>$currentDoctorSchedule,'doctorName'=>$doctorName,'doctorSchedule'=>$doctorSchedule));

    } 

    public function doctorInfo(Request $request){
        $data = $request->all();

        $user = new User();

        $doctorID = $data['doctorID'];

        $doctorName = $user->getDoctorInfoByID($doctorID);
        $doctorSchedule = $schedule->getScheduleByDoctorID($doctorID); //之後用ajax傳入id

        return array('doctorName'=>$doctorName,'doctorSchedule'=>$doctorSchedule);

    }

    //醫生確認換班
    public function checkShift($id){
        $shiftRecords = new ShiftRecords();

        $shiftCheck = $shiftRecords->doc2Confirm($id,1);

        return redirect ('first-edition-shift');
    }

    //醫生拒絕換班
    public function rejectShift($id){
        $shiftRecords = new ShiftRecords();

        $shiftCheck = $shiftRecords->doc2Confirm($id,2);

        return redirect ('first-edition-shift');
    }

    //查詢 單一醫生換班紀錄
    public function getShiftRecordsByDoctorID(){
        $shiftRecords = new ShiftRecords();
        $data = $shiftRecords ->getShiftRecordsByDoctorID();

        return view ("getShiftRecordsByDoctorID",array('data' => $data));
    }

    // 初版班表->換班資訊 新增換班
    public function firstEditionShiftAddShifts(){
    		$addShifts = new ShiftRecords();
    		$scheduleID_1 = Input::get('scheduleID_1');
    		$scheduleID_2 = Input::get('scheduleID_2');
    		$schID_1_doctor = Input::get('schID_1_doctor');
    		$schID_2_doctor = Input::get('schID_2_doctor');
            $doc2Confirm = 0;
            $adminConfirm = 0;

    		$newShiftSerial = $addShifts->addShifts($scheduleID_1,$scheduleID_2,$schID_1_doctor,$schID_2_doctor,$doc2Confirm,$adminConfirm);

    		return redirect('first-edition-shift-info'); 

    }


    //調整班表->初版班表 新增換班
   
     public function shiftFirstEditionAddShifts(Request $request){
            $data = $request->all();

            $scheduleID1 = $data['scheduleID_1'];
            $scheduleID2 = $data['scheduleID_2'];

            $scheduleID1=6;
            $scheduleID2=1;

            $schedule = new Schedule();

            $schedule_1_Info = $schedule->getScheduleDataByID($scheduleID1);
            $schedule_2_Info = $schedule->getScheduleDataByID($scheduleID2);

            $shiftInfo = [
            'scheduleID_1' => $schedule_1_Info->scheduleID,
            'scheduleID_2' => $schedule_2_Info->scheduleID,
            'schID_1_doctor' => $schedule_1_Info->doctorID,
            'schID_2_doctor' => $schedule_2_Info->doctorID,
            'doc2Confirm' => '1',
            'adminConfirm' => '1',
            'date' => date('Y-m-d')
        ];

            $shiftRecords = new ShiftRecords();

            $newChangeSerial = $shiftRecords->addShifts($shiftInfo);

            echo "newChangeSerial" .$newChangeSerial;

            //$changeSerial = $shiftRecords->getChangeSerial($scheduleID1,$scheduleID2);

            //$confrimShiftRecord = $schedule->exchangeSchedule($changeSerial); 
            $shiftRecords->doc2Confirm($newChangeSerial,1);
            $shiftRecords->adminConfirm($newChangeSerial,1);


            // $addShifts = new ShiftRecords();
            // $scheduleID_1 = Input::get('scheduleID_1');
            // $scheduleID_2 = Input::get('scheduleID_2');
            // $schID_1_doctor = Input::get('schID_1_doctor');
            // $schID_2_doctor = Input::get('schID_2_doctor');
            // $doc2Confirm = 0;
            // $adminConfirm = 0;

            // $newShiftSerial = $addShifts->addShifts($scheduleID_1,$scheduleID_2,$schID_1_doctor,$schID_2_doctor,$doc2Confirm,$adminConfirm);

    }

    //醫生確認換班
    public function doc2Confirm(){
        $doc2Confirm = Input::get('doc2Confirm');
        $update = new ShiftRecords();
        $serial = Input::get('serial');
        $updatedDoc2Confirm = $update->doc2Confirm($serial,$doc2Confirm);
        
        return redirect('shiftRecords'); 

    }

    //排班人員確認換班
    public function adminConfirm(){
        $changeSerial = Input::get('changeSerial');

        $shiftRecord = new ShiftRecords();
        $adminConfirmNumber = Input::get('adminConfirm');

        $shiftRecord->adminConfirm($changeSerial,$adminConfirmNumber);

        return redirect('shiftRecords'); 

    }

     public function getDataByID() {
        $serial = Input::get('serial');

        return view('doctorCheckShift', array('serial' => $serial) );

    }
    
    // 取得正式班表中的換班資訊
    public function getShiftRecords() {
        $shiftRecordObj = new ShiftRecords();
        $userObj = new User();
        $sheduleObj = new Schedule();
        $schCateObj = new ScheduleCategory();
        
        $confirmedRecords = $shiftRecordObj->checkShiftRecordsList();
        
        $displayConfirmedArr = [];
        
        $allShiftData = $shiftRecordObj->getMoreCheckShiftsRecordsInformation(false);  // 列出所有待確認換班資訊

        // foreach($confirmedRecords as $record) {
        //     $recordDic = [
        //         'changeSerial' => $record->changeSerial,
        //         'applier' => '',
        //         'receiver' => '',
        //         'applyDate' => '',
        //         'sch1Date' => '',
        //         'sch2Date' => '',
        //         'sch1Content' => '',
        //         'sch2Content' => ''
        //     ];
            
        //     $recordDic['applier'] = $userObj->getDoctorInfoByID($record->schID_1_doctor)->name;
        //     $recordDic['receiver'] = $userObj->getDoctorInfoByID($record->schID_2_doctor)->name;
        //     $recordDic['applyDate'] = $record->date;
            
            
        //     $schedule1 = $sheduleObj->getScheduleDataByID($record->scheduleID_1);
        //     $schedule2 = $sheduleObj->getScheduleDataByID($record->scheduleID_2);
        //     $sch1Name = $schCateObj->findScheduleName($schedule1->schCategorySerial);
        //     $sch2Name = $schCateObj->findScheduleName($schedule2->schCategorySerial);
            
        //     $recordDic['sch1Date'] = $schedule1->date;
        //     $recordDic['sch2Date'] = $schedule2->date;
        //     $recordDic['sch1Content'] = $recordDic['applier'].' '.$sch1Name;
        //     $recordDic['sch2Content'] = $recordDic['receiver'].' '.$sch2Name;
            
        //     array_push($displayConfirmedArr, $recordDic);
        // }
        
        // 對方醫師提出申請，但未確認
         $shiftDataByDoctorID = $shiftRecordObj->getMoreUncheckShiftsRecordsInformation(true); //換班待確認
        // $displayUnconfirmedArr = [];
        
        // $displayUnconfirmedRecords = $shiftRecordObj->getUncheckShiftRecordsList();
        
        // foreach($displayUnconfirmedRecords as $record) {
        //     $recordDic = [
        //         'changeSerial' => $record->changeSerial,
        //         'applier' => '',
        //         'receiver' => '',
        //         'applyDate' => '',
        //         'sch1Date' => '',
        //         'sch2Date' => '',
        //         'sch1Content' => '',
        //         'sch2Content' => ''
        //     ];
            
        //     $recordDic['applier'] = $userObj->getDoctorInfoByID($record->schID_1_doctor)->name;
        //     $recordDic['receiver'] = $userObj->getDoctorInfoByID($record->schID_2_doctor)->name;
        //     $recordDic['applyDate'] = $record->date;
            
            
        //     $schedule1 = $sheduleObj->getScheduleDataByID($record->scheduleID_1);
        //     $schedule2 = $sheduleObj->getScheduleDataByID($record->scheduleID_2);
        //     $sch1Name = $schCateObj->findScheduleName($schedule1->schCategorySerial);
        //     $sch2Name = $schCateObj->findScheduleName($schedule2->schCategorySerial);
            
            
        //     $recordDic['sch1Date'] = $schedule1->date;
        //     $recordDic['sch2Date'] = $schedule2->date;
        //     $recordDic['sch1Content'] = $recordDic['applier'].' '.$sch1Name;
        //     $recordDic['sch2Content'] = $recordDic['receiver'].' '.$sch2Name;
            
        //     array_push($displayUnconfirmedRecords, $recordDic);
        // }
        
        return view('pages.schedule-shift-info', [
            'shiftRecords'=>$allShiftData,'shiftDataByDoctorID'=>$shiftDataByDoctorID
        ]);
        
    }
    
    // 醫生2確認換班
    public function doctor2AgreeShiftRecord($changeSerial) {
        $shiftRecordObj = new ShiftRecords();
        
        $record = $shiftRecordObj->getShiftRecordByChangeSerial($changeSerial);
        
        $shiftRecordObj->doc2Confirm($changeSerial, 1);
        
        $job = new SendAgreeShiftExchangeMail($record->schID_1_doctor, $record->schID_2_doctor, $record->scheduleID_1, $record->scheduleID_2);
        
        dispatch($job);
    }
    
    // 醫生2拒絕換班
    public function doctor2DenyShiftRecord($changeSerial) {
        $shiftRecordObj = new ShiftRecords();
        $record = $shiftRecordObj->getShiftRecordByChangeSerial($changeSerial);
        
        $shiftRecordObj->doc2Confirm($changeSerial, 2);
        
        $job = new SendDenyShiftExchangeMail($record->schID_1_doctor, $record->schID_2_doctor);
        
        dispatch($job);
    }
    
    // 取得調整班表的換班資訊頁面
    public function adminShiftRecords() {
        $shiftRecordObj = new ShiftRecords();
        
        $userObj = new User();

        $sheduleObj = new Schedule();

        $schCateObj = new ScheduleCategory();

        $shiftRecords = $shiftRecordObj->getRecordsOrderByDate();
        
        $displayArr = [];
        
        foreach($shiftRecords as $record) {
            $recordDic = [
                'changeSerial' => $record->changeSerial,
                'applier' => '',
                'receiver' => '',
                'applyDate' => '',
                'sch1Date' => '',
                'sch2Date' => '',
                'sch1Content' => '',
                'sch2Content' => '',
                'adminConfirm' => $record->adminConfirm
            ];
            
            $recordDic['applier'] = $userObj->getDoctorInfoByID($record->schID_1_doctor)->name;
            $recordDic['receiver'] = $userObj->getDoctorInfoByID($record->schID_2_doctor)->name;
            $recordDic['applyDate'] = $record->date;
            
            
            $schedule1 = $sheduleObj->getScheduleDataByID($record->scheduleID_1);
            $schedule2 = $sheduleObj->getScheduleDataByID($record->scheduleID_2);
            $sch1Name = $schCateObj->findScheduleName($schedule1->schCategorySerial);
            $sch2Name = $schCateObj->findScheduleName($schedule2->schCategorySerial);
            
            $recordDic['sch1Date'] = $schedule1->date;
            $recordDic['sch2Date'] = $schedule2->date;
            $recordDic['sch1Content'] = $recordDic['applier'].' '.$sch1Name;
            $recordDic['sch2Content'] = $recordDic['receiver'].' '.$sch2Name;
            
            array_push($displayArr, $recordDic);
        }
        
        $remarkObj = new Remark();
       
        
        $remarks = $remarkObj->getRemarks();
        
        $displayRemarksArr = [];
        
        foreach($remarks as $remark) {
            $remarkDic = [
                'author' => '',
                'date' => $remark->date,
                'content' => $remark->remark
            ];
            
            $remarkDic['author'] = $userObj->getDoctorInfoByID($remark->doctorID)->name;
            
            array_push($displayRemarksArr, $remarkDic);
        }
        
        return view('pages.shift-info', [
            'shiftRecords' => $displayArr,
            'remarks' => $displayRemarksArr
        ]);
    }
    
    // 排班人員確認換班
    public function adminAgreeShiftRecord($serial) {
        $shiftRecordObj = new ShiftRecords();

        $shiftRecordObj->adminConfirm($serial,1);

        return redirect('shift-info');
    }

    // 調整班表 換班確認 顯示初版班表 調整換班
    public function shiftFirstEdition(){
        $schedule = new Schedule();
        $user = new User();
        $shiftRecords = new ShiftRecords(); 
        $scheduleData = $schedule->getSchedule();

        $doctorName = $user->getDoctorInfoByID(2);
        $doctorSchedule = $schedule->getScheduleByDoctorID(2); //之後用ajax傳入id

        foreach ($scheduleData as $data) {
            $doctorName = $user->getDoctorInfoByID($data->doctorID);
            $data->doctorID = $doctorName->name;
        }

        return view('pages.shift-first-edition',array('schedule' => $scheduleData,'doctorName' => $doctorName,'doctorSchedule'=>$doctorSchedule));

    }

}
