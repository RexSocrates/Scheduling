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
use App\Reservation;

use App\ReservationData;

use App\ScheduleRecord;


// import jobs
use App\Jobs\SendAgreeShiftExchangeMail;
use App\Jobs\SendDenyShiftExchangeMail;
use App\Jobs\SendShiftExchangeMail;
use App\Jobs\SendApplyShiftExchangeMail;
use App\Jobs\SendShiftExchangingInformMail;
use App\Jobs\SendDenyConfirmedShiftExchangeMail;


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
    
        
        return view ("pages.first-edition-shift",array('shiftRecords'=>$allShiftData,'shiftDataByDoctorID'=>$shiftDataByDoctorID,'currentDoctor'=>$currentDoctor,'currentDoctorSchedule'=>$currentDoctorSchedule,'doctorName'=>$doctorName));

    } 

    public function doctorInfo(Request $request){
        $data = $request->all();

        $user = new User();

        $doctorID = $data['doctorID'];

        $doctorName = $user->getDoctorInfoByID($doctorID);
        $doctorSchedule = $schedule->getScheduleByDoctorID($doctorID); //之後用ajax傳入id

        return array('doctorName'=>$doctorName,'doctorSchedule'=>$doctorSchedule);

    }

    // 檢查這筆換班紀錄的兩筆上班資料是否有被異動過
    public function getShiftRecordsBySerial(Request $request){
        $data = $request->all();
        $serial = $data['id'];
    
        $user = new User();
        $shiftRecordObj = new ShiftRecords();
        $schedule = new Schedule();
        $scheduleCategory = new ScheduleCategory();


        $shiftInfo = $shiftRecordObj->getShiftRecordByChangeSerial($serial); 

        $scheduleID1= $shiftInfo->scheduleID_1;
        $scheduleID2= $shiftInfo->scheduleID_2;

        //判斷醫生1班
        $doctorID1 = $schedule->getScheduleDataByID($scheduleID1)->doctorID;
        $date1 = $schedule->getScheduleDataByID($scheduleID2)->date;
        $categoryID1 =$schedule->getScheduleDataByID($scheduleID2)->schCategorySerial;
        $weekday1 = (int)date('N', strtotime($date1));


        //判斷醫生2班
        $doctorID2 = $schedule->getScheduleDataByID($scheduleID2)->doctorID;
        $date2 = $schedule->getScheduleDataByID($scheduleID1)->date;
        $categoryID2 =$schedule->getScheduleDataByID($scheduleID1)->schCategorySerial;
        $weekday2 = (int)date('N', strtotime($date2));

         //確認當天一位醫生是否有上班 醫生id
        $count1=$schedule->checkDocStatus($doctorID1,$date1);
        $count2=$schedule->checkDocStatus($doctorID2,$date2);

    

        //確認醫生前一天是否為夜班
        $doc1PreNight = $schedule->getNightScheduleByDoctorIDandDate($doctorID1,$date1);
        $doc2PreNight = $schedule->getNightScheduleByDoctorIDandDate($doctorID2,$date2);

        //確認醫生後一天是否為白班
        $doc1LaterDay = $schedule->getDayScheduleByDoctorIDandDate($doctorID1,$date1);
        $doc2LaterDay = $schedule->getDayScheduleByDoctorIDandDate($doctorID2,$date2);

        //判斷在非値登院區班數
        $doc1Location =0;
        $doc2Location =0;
        
        if($schedule->getScheduleDataByID($scheduleID1)->location != $schedule->getScheduleDataByID($scheduleID2)->location){
            if($schedule->getScheduleDataByID($scheduleID2)->location != $user->getDoctorInfoByID($doctorID1)->location){
                $doc1Location = $schedule->getAnotherLocationShifts($doctorID1,$date1);
            }

            if($doctorID2 != ""){
               if($schedule->getScheduleDataByID($scheduleID1)->location != $user->getDoctorInfoByID($doctorID2)->location){
                $doc2Location = $schedule->getAnotherLocationShifts($doctorID2,$date2);
            
            }
        }

        if($doctorID2 == ""){
            $doc2Location = $schedule->getAnotherLocationShifts($doctorID1,$date2);
            
        }
            
        
        }
        
        //判斷醫生科別
        $doc1Major=0;
        $doc2Major=0;

        if($user->getDoctorInfoByID($doctorID1)->major != "All"){
            if($scheduleCategory->getSchCategoryMajor($categoryID1) != $scheduleCategory->getSchCategoryMajor($categoryID2)){
                if($user->getDoctorInfoByID($doctorID1)->major != $scheduleCategory->getSchCategoryMajor($categoryID1)){
                    $doc1Major=1;
                }
                if($doctorID2 != null){
                    if($user->getDoctorInfoByID($doctorID2)->major != $scheduleCategory->getSchCategoryMajor($categoryID2)){
                        $doc2Major=2;
                    }
                }
                if($doctorID2 == null){
                    $doc2Major=0;
                }

            }
        }

        $doc1Night=0;

        if($doc1PreNight != 0 and ($categoryID1==3 or $categoryID1==4 or $categoryID1==5 or $categoryID1==6 or $categoryID1==7 or $categoryID1==8 or $categoryID1==9 or $categoryID1==10 or $categoryID1==11 or $categoryID1==12)){
            $laterdate=date("Y-m-d",strtotime($date1."-1 day"));
                if($laterdate == $date2){
                    $doc1Night=0;
                }   
                else{
                    $doc1Night=1;
                } 
        }
        

        $doc2Night=0;

        if($doctorID2 != ""){
            if($doc2PreNight != 0 and ($categoryID2==3 or $categoryID2==4 or $categoryID2==5 or $categoryID2==6 or $categoryID2==7 or $categoryID2==8 or $categoryID2==9 or $categoryID2==10 or $categoryID2==11 or $categoryID2==12)){
            $predate=date("Y-m-d",strtotime($date2."-1 day"));
            if($predate == $date1){
                $doc2Night=0;
            }   
            else{
                $doc2Night=1;
            }   
            
         }
        }

         if($doctorID2 == ""){
            $doc2PreNight = $schedule->getNightScheduleByDoctorIDandDate($doctorID1,$date2);
            if($doc2PreNight != 0 and ($categoryID2==3 or $categoryID2==4 or $categoryID2==5 or $categoryID2==6 or $categoryID2==7 or $categoryID2==8 or $categoryID2==9 or $categoryID2==10 or $categoryID2==11 or $categoryID2==12)){
            // if($scheduleCategory->getSchCategoryTime($categoryID1) == $scheduleCategory->getSchCategoryTime($categoryID2) ){
            //     $doc2Night=0;
            // }

            // else{
            if($predate == $date1){
                $doc2Night=0;
            }   
            else{
                $doc2Night=1;
            } 
                
            // }
            }
        }


        $doc1Day=0;

        if($doc1LaterDay != 0 and ($categoryID1==13 or $categoryID1==14 or $categoryID1==15 or $categoryID1==16 or $categoryID1==17 or $categoryID1==18 or $categoryID1==19 or $categoryID1==20 or $categoryID1==21)){
            $predate=date("Y-m-d",strtotime($date2."-1 day"));
            if($predate == $date1){
                $doc1Day=0;
            }   
            else{
                $doc1Day=1;
            }        
          
        }

        $doc2Day=0;
        if($doctorID2 != ""){
            if($doc2LaterDay != 0 and ($categoryID2==13 or $categoryID2==14 or $categoryID2==15 or $categoryID2==16 or $categoryID2==17 or $categoryID2==18 or $categoryID2==19 or $categoryID2==20 or $categoryID2==21)){
            $laterdate=date("Y-m-d",strtotime($date2."+1 day"));
                if($laterdate == $date1){
                    $doc2Day=0;
                 }   
                else{
                    $doc2Day=1;
                 } 
            
               
            // }
        }
     }
     if($doctorID2 != ""){
        $doc2LaterDay = $schedule->getDayScheduleByDoctorIDandDate($doctorID1,$date2);
            if($doc2LaterDay != 0 and ($categoryID2==13 or $categoryID2==14 or $categoryID2==15 or $categoryID2==16 or $categoryID2==17 or $categoryID2==18 or $categoryID2==19 or $categoryID2==20 or $categoryID2==21)){
                if($laterdate == $date1){
                    $doc2Day=0;
                }   
                else{
                    $doc2Day=1;
                 } 
        }
     }

        $doc2 = null;
        if($doctorID2!=null){
            $doc2 = $user->getDoctorInfoByID($doctorID2)->name;
        }
        else{
             $doc2 = $user->getDoctorInfoByID($doctorID1)->name;
        }

        $status = 1; //代表true
        if($doctorID1 == $shiftInfo->schID_1_doctor &&  $doctorID2 == $shiftInfo->schID_2_doctor){
            // 表示兩筆上班資料都沒有其他異動
            $status=1;
        }
        else{
            $status=2;
        }


        $countDic=[
            "scheduleID_1"=>$scheduleID1,
            "scheduleID_2"=>$scheduleID2,
            "count1"=>$count1,
            "count2"=>$count2,
            "doc1"=>$user->getDoctorInfoByID($doctorID1)->name,
            "doc2"=>$doc2,
            'date1'=>$date1,
            'date2'=>$date2,
            'doc1Night' => $doc1Night,
            'doc2Night' => $doc2Night,
            'doc1Day' => $doc1Day,
            'doc2Day' => $doc2Day,
            'doc1Location'=>$doc1Location,
            'doc2Location'=>$doc2Location,
            'doc1Major'=>$doc1Major,
            'doc2Major'=>$doc2Major,
            'status'=>$status,
            'date1Month' =>date('Y-m',strtotime($date1)),
            'date2Month' =>date('Y-m',strtotime($date2))
        ];

        
        $countArr=[];
        array_push($countArr,$countDic);

        return $countArr;
    }
    
    // 依據使用者選擇的月份顯示換班資訊
    public function getShiftByMonth(Request $request){
        $data = $request->all();
//        $month = str_replace(' ', '', $data['month']);
//        $month = '2017-09';
        $month = $data['month'];
        
        // 依照月份取得排班人員已經認可的換班資訊
        $shiftRecordObj = new ShiftRecords();
        $shiftRecordsData = $shiftRecordObj->getShiftRecordsByMonth($month);
        
        // 建立顯示資料使用的model
        $userObj = new User();
        $schCateObj = new ScheduleCategory();
        $scheduleObj = new Schedule();
        
        // 將資料庫資料轉換為顯示用的資料
        $recordData = [];
        foreach($shiftRecordsData as $record) {
            // 取得醫生資料
            $doctor1 = $userObj->getDoctorInfoByID($record->schID_1_doctor);
            $doctor2 = $userObj->getDoctorInfoByID($record->schID_2_doctor);
            
            // 取得上班資料
            $schedule1 = $scheduleObj->getScheduleDataByID($record->scheduleID_1);
            $schedule2 = $scheduleObj->getScheduleDataByID($record->scheduleID_2);
            
            // 取得上班種類名稱
            $sch1Name = $schCateObj->getSchCateName($schedule1->schCategorySerial);
            $sch2Name = $schCateObj->getSchCateName($schedule2->schCategorySerial);
            
            array_push($recordData, [
                $doctor1->name,
                $doctor2->name,
                $schedule1->date,
                $schedule2->date,
                $sch1Name,
                $sch2Name,
                $record->changeSerial,
                $record->date
            ]);
        }
        
        return $recordData;
    }

 // 依據使用者選擇的月份顯示換班資訊 暫時沒用到
    public function getUncheckShiftByMonth(Request $request){
        $data = $request->all();

        $month = $data['month'];
        
        // 依照月份取得排班人員已經認可的換班資訊
        $shiftRecordObj = new ShiftRecords();
        $shiftRecordsData = $shiftRecordObj->getUncheckShiftRecordsByMonth($month);
        
        // 建立顯示資料使用的model
        $userObj = new User();
        $schCateObj = new ScheduleCategory();
        $scheduleObj = new Schedule();
        
        // 將資料庫資料轉換為顯示用的資料
        $recordData = [];
        foreach($shiftRecordsData as $record) {
            // 取得醫生資料
            $doctor1 = $userObj->getDoctorInfoByID($record->schID_1_doctor);
            $doctor2 = $userObj->getDoctorInfoByID($record->schID_2_doctor);
            
            // 取得上班資料
            $schedule1 = $scheduleObj->getScheduleDataByID($record->scheduleID_1);
            $schedule2 = $scheduleObj->getScheduleDataByID($record->scheduleID_2);
            
            // 取得上班種類名稱
            $sch1Name = $schCateObj->getSchCateName($schedule1->schCategorySerial);
            $sch2Name = $schCateObj->getSchCateName($schedule2->schCategorySerial);


            
            array_push($recordData, [
                $doctor1->name,
                $doctor2->name,
                $schedule1->date,
                $schedule2->date,
                $sch1Name,
                $sch2Name,
                $record->changeSerial,
                $record->date,
                $record->adminConfirm
            ]);
        }
        
        return $recordData;
    }

    //醫生確認換班
    public function checkShift(Request $request){
        $data = $request->all();
        $id = $data['id'];
        
        $shiftRecords = new ShiftRecords();

        $shiftCheck = $shiftRecords->doc2Confirm($id,1);

        $shiftRecords->getShiftRecordByChangeSerial($id);

        $applier = $shiftRecords->schID_1_doctor;
        $receiver = $shiftRecords->schID_2_doctor;
        $applier_ScheduleID = $shiftRecords->scheduleID_1;
        $receiver_ScheduleID = $shiftRecords->scheduleID_2;

        //$job = new SendAgreeShiftExchangeMail($applier,$receiver,$applier_ScheduleID,$receiver_ScheduleID);

        //dispatch($job);

        return redirect ('schedule-shift-info');
    }

    //醫生拒絕換班
    public function rejectShift($id){
        $shiftRecords = new ShiftRecords();
        $schedule = new Schedule();

        $shiftCheck = $shiftRecords->doc2Confirm($id,2);

        $applier = $shiftRecords->schID_1_doctor;
        $receiver = $shiftRecords->schID_2_doctor;

        $scheduleID_1=$shiftRecords->getShiftRecordByChangeSerial($id)->scheduleID_1;
        $scheduleID_2=$shiftRecords->getShiftRecordByChangeSerial($id)->scheduleID_2;

        $schedule->checkScheduleStatus($scheduleID_1,0);
        $schedule->checkScheduleStatus($scheduleID_2,0);

        //$job = new SendDenyShiftExchangeMail($applier,$receiver);

        //dispatch($job);

        return redirect ('schedule-shift-info');
    }

    //查詢 單一醫生換班紀錄
    public function getShiftRecordsByDoctorID(){
        $shiftRecords = new ShiftRecords();
        $data = $shiftRecords ->getShiftRecordsByDoctorID();

        return view ("getShiftRecordsByDoctorID",array('data' => $data));
    }



    // 初版班表->換班資訊 新增換班
    public function firstEditionShiftAddShifts(Request $request){
        $data = $request->all();

        $scheduleID1 = (int)$data['scheduleID_1']; //提出
        $scheduleID2 = (int)$data['scheduleID_2']; // 要換

        $schedule = new Schedule();

        $schedule_1_Info = $schedule->getScheduleDataByID($scheduleID1);
        $schedule_2_Info = $schedule->getScheduleDataByID($scheduleID2);

        $shiftInfo = [
            'scheduleID_1' => $schedule_1_Info->scheduleID,
            'scheduleID_2' => $schedule_2_Info->scheduleID,
            'schID_1_doctor' => $schedule_1_Info->doctorID,
            'schID_2_doctor' => $schedule_2_Info->doctorID,
            'doc2Confirm' => 0,
            'adminConfirm' => 0,
            'date' => date('Y-m-d')
        ];

        $schedule_1_Date = $schedule_1_Info->date;

        $shiftRecords = new ShiftRecords();

        $newChangeSerial = $shiftRecords->addShifts($shiftInfo);

        $schedule->checkScheduleStatus($scheduleID1,1);
        $schedule->checkScheduleStatus($scheduleID2,1);
        // $receiver = $schedule_2_Info->doctorID; 
        // $applier = $schedule_1_Info->doctorID;
        // $applier_ScheduleID = $schedule_1_Info->scheduleID;
        // $receiver_ScheduleID = $schedule_2_Info->scheduleID;

        //$job = new SendApplyShiftExchangeMail($newChangeSerial);

        //dispatch($job);


    }

     // 正式班表->換班資訊 新增換班
    public function scheduleEditionShiftAddShifts(){
        $addShifts = new ShiftRecords();
        $scheduleID_1 = Input::get('scheduleID_1');
        $scheduleID_2 = Input::get('scheduleID_2');
        $schID_1_doctor = Input::get('schID_1_doctor');
        $schID_2_doctor = Input::get('schID_2_doctor');
        $doc2Confirm = 0;
        $adminConfirm = 0;

        $data = [
            'scheduleID_1' => $scheduleID_1,
            'scheduleID_2' => $scheduleID_2,
            'schID_1_doctor' => $schID_1_doctor,
            'schID_2_doctor' => $schID_2_doctor,
            'doc2Confirm' => '0',
            'adminConfirm' => '0',
            'date' => date('Y-m-d')
        ];

        $newShiftSerial = $addShifts->addShifts($data);

        return redirect('schedule-shift-info'); 

    }

    //調整班表->初版班表 確認換班狀態
    public function checkDoc1ShiftStatus(Request $request){
        $data = $request->all();

        $scheduleID1 = (int)$data['scheduleID_1'];
        $scheduleID2 = (int)$data['scheduleID_2'];

        $schedule = new Schedule();
        $user =new User();
        $reservation = new Reservation();
        $scheduleCategory = new ScheduleCategory();


        //判斷醫生1班
        $doctorID1 = $schedule->getScheduleDataByID($scheduleID1)->doctorID;//2
        $date1 = $schedule->getScheduleDataByID($scheduleID2)->date;
        $categoryID1 =$schedule->getScheduleDataByID($scheduleID2)->schCategorySerial;
        $weekday1 = (int)date('N', strtotime($date1));


        //判斷醫生2班
        $doctorID2 = $schedule->getScheduleDataByID($scheduleID2)->doctorID;
        $date2 = $schedule->getScheduleDataByID($scheduleID1)->date;
        $categoryID2 =$schedule->getScheduleDataByID($scheduleID1)->schCategorySerial;
        $weekday2 = (int)date('N', strtotime($date2));

        //確認當天一位醫生是否有上班 醫生id
        $count1=$schedule->checkDocStatus($doctorID1,$date1);
        $count2=$schedule->checkDocStatus($doctorID2,$date2);

        //確認醫生假日班數
        $doc1weekend = $schedule->checkDocScheduleInWeekend($doctorID1);
        $doc2weekend = $schedule->checkDocScheduleInWeekend($doctorID2);

        //確認醫生是否有off班
        $doc1off = $reservation->getResrvationByDateandDoctorID($doctorID1,$date1);
        $doc2off = $reservation->getResrvationByDateandDoctorID($doctorID2,$date2);

        //確認醫生前一天是否為夜班
        $doc1PreNight = $schedule->getNightScheduleByDoctorIDandDate($doctorID1,$date1);
        $doc2PreNight = $schedule->getNightScheduleByDoctorIDandDate($doctorID2,$date2);

        //確認醫生後一天是否為白班
        $doc1LaterDay = $schedule->getDayScheduleByDoctorIDandDate($doctorID1,$date1);
        $doc2LaterDay = $schedule->getDayScheduleByDoctorIDandDate($doctorID2,$date2);

        //判斷在非値登院區班數
        $doc1Location =0;
        $doc2Location =0;
        
        if($schedule->getScheduleDataByID($scheduleID1)->location != $schedule->getScheduleDataByID($scheduleID2)->location){
            if($schedule->getScheduleDataByID($scheduleID2)->location != $user->getDoctorInfoByID($doctorID1)->location){
                $doc1Location = $schedule->getAnotherLocationShifts($doctorID1,$date1);
            }

            if($doctorID2 != ""){
               if($schedule->getScheduleDataByID($scheduleID1)->location != $user->getDoctorInfoByID($doctorID2)->location){
                $doc2Location = $schedule->getAnotherLocationShifts($doctorID2,$date2);
            
            }
        }

        if($doctorID2 == ""){
            $doc2Location = $schedule->getAnotherLocationShifts($doctorID1,$date2);
            
        }
            
        
        }
        
        //判斷醫生科別
        $doc1Major=0;
        $doc2Major=0;

        if($user->getDoctorInfoByID($doctorID1)->major != "All"){
            if($scheduleCategory->getSchCategoryMajor($categoryID1) != $scheduleCategory->getSchCategoryMajor($categoryID2)){
                if($user->getDoctorInfoByID($doctorID1)->major != $scheduleCategory->getSchCategoryMajor($categoryID1)){
                    $doc1Major=1;
                }
                if($doctorID2 != null){
                    if($user->getDoctorInfoByID($doctorID2)->major != $scheduleCategory->getSchCategoryMajor($categoryID2)){
                        $doc2Major=2;
                    }
                }
                if($doctorID2 == null){
                    $doc2Major=0;
                }

            }
        }

        $doc1Night=0;

        if($doc1PreNight != 0 and ($categoryID1==3 or $categoryID1==4 or $categoryID1==5 or $categoryID1==6 or $categoryID1==7 or $categoryID1==8 or $categoryID1==9 or $categoryID1==10 or $categoryID1==11 or $categoryID1==12)){
            $laterdate=date("Y-m-d",strtotime($date1."-1 day"));
                if($laterdate == $date2){
                    $doc1Night=0;
                }   
                else{
                    $doc1Night=1;
                } 
        }
        

        $doc2Night=0;

        if($doctorID2 != ""){
            if($doc2PreNight != 0 and ($categoryID2==3 or $categoryID2==4 or $categoryID2==5 or $categoryID2==6 or $categoryID2==7 or $categoryID2==8 or $categoryID2==9 or $categoryID2==10 or $categoryID2==11 or $categoryID2==12)){
            $predate=date("Y-m-d",strtotime($date2."-1 day"));
            if($predate == $date1){
                $doc2Night=0;
            }   
            else{
                $doc2Night=1;
            }   
            
         }
        }

         if($doctorID2 == ""){
            $doc2PreNight = $schedule->getNightScheduleByDoctorIDandDate($doctorID1,$date2);
            if($doc2PreNight != 0 and ($categoryID2==3 or $categoryID2==4 or $categoryID2==5 or $categoryID2==6 or $categoryID2==7 or $categoryID2==8 or $categoryID2==9 or $categoryID2==10 or $categoryID2==11 or $categoryID2==12)){
            // if($scheduleCategory->getSchCategoryTime($categoryID1) == $scheduleCategory->getSchCategoryTime($categoryID2) ){
            //     $doc2Night=0;
            // }

            // else{
            if($predate == $date1){
                $doc2Night=0;
            }   
            else{
                $doc2Night=1;
            } 
                
            // }
            }
        }


        $doc1Day=0;

        if($doc1LaterDay != 0 and ($categoryID1==13 or $categoryID1==14 or $categoryID1==15 or $categoryID1==16 or $categoryID1==17 or $categoryID1==18 or $categoryID1==19 or $categoryID1==20 or $categoryID1==21)){
            $predate=date("Y-m-d",strtotime($date2."-1 day"));
            if($predate == $date1){
                $doc1Day=0;
            }   
            else{
                $doc1Day=1;
            }        
          
        }

        $doc2Day=0;
        if($doctorID2 != ""){
            if($doc2LaterDay != 0 and ($categoryID2==13 or $categoryID2==14 or $categoryID2==15 or $categoryID2==16 or $categoryID2==17 or $categoryID2==18 or $categoryID2==19 or $categoryID2==20 or $categoryID2==21)){
            $laterdate=date("Y-m-d",strtotime($date2."+1 day"));
                if($laterdate == $date1){
                    $doc2Day=0;
                 }   
                else{
                    $doc2Day=1;
                 } 
            
               
            // }
        }
     }
     if($doctorID2 != ""){
        $doc2LaterDay = $schedule->getDayScheduleByDoctorIDandDate($doctorID1,$date2);
            if($doc2LaterDay != 0 and ($categoryID2==13 or $categoryID2==14 or $categoryID2==15 or $categoryID2==16 or $categoryID2==17 or $categoryID2==18 or $categoryID2==19 or $categoryID2==20 or $categoryID2==21)){
                if($laterdate == $date1){
                    $doc2Day=0;
                }   
                else{
                    $doc2Day=1;
                 } 
        }
     }

        $doc2 = null;
        if($doctorID2!=null){
            $doc2 = $user->getDoctorInfoByID($doctorID2)->name;
        }
        else{
             $doc2 = $user->getDoctorInfoByID($doctorID1)->name;
        }

        $countDic=[
            "scheduleID_1"=>$scheduleID1,
            "scheduleID_2"=>$scheduleID2,
            "count1"=>$count1,
            "count2"=>$count2,
            "doc1"=>$user->getDoctorInfoByID($doctorID1)->name,
            "doc2"=>$doc2,
            'date1'=>$date1,
            'date2'=>$date2,
            'weekday1'=>$weekday1,
            'weekday2'=>$weekday2,
            'doc1weekend'=> $doc1weekend,
            'doc2weekend' => $doc2weekend,
            'doc1off' => $doc1off,
            'doc2off' => $doc2off,
            'doc1Night' => $doc1Night,
            'doc2Night' => $doc2Night,
            'doc1Day' => $doc1Day,
            'doc2Day' => $doc2Day,
            'doc1Location'=>$doc1Location,
            'doc2Location'=>$doc2Location,
            'doc1Major'=>$doc1Major,
            'doc2Major'=>$doc2Major,
            'date1Month' =>date('Y-m',strtotime($date1)),
            'date2Month' =>date('Y-m',strtotime($date2))

        ];

        
        $countArr=[];
        array_push($countArr,$countDic);

        return $countArr;
        
    }

    //調整班表->初版班表 確認換班狀態
    public function checkDoc2ShiftStatus(Request $request){
        $data = $request->all();

        $scheduleID1 = (int)$data['scheduleID_1'];
        $scheduleID2 = (int)$data['scheduleID_2'];

        $schedule = new Schedule();

        //判斷醫生1班
        $doctorID2 = $schedule->getScheduleDataByID($scheduleID2)->doctorID;
        $date2 = $schedule->getScheduleDataByID($scheduleID1)->date;

        $count=$schedule->checkDocStatus($doctorID2,$date2);

        return $count;
        
    }
    //調整班表->初版班表 新增換班
    public function shiftFirstEditionAddShifts(Request $request){
        $data = $request->all();

        $scheduleID1 = (int)$data['scheduleID_1'];
        $scheduleID2 = (int)$data['scheduleID_2'];

        $schedule = new Schedule();

        $schedule_1_Info = $schedule->getScheduleDataByID($scheduleID1);
        $schedule_2_Info = $schedule->getScheduleDataByID($scheduleID2);


       

        //只有換班
        if($schedule_2_Info->doctorID==""){
            $schInfo = [
              'doctorID' =>$schedule_1_Info->doctorID
            ];
            
            $schedule->addScheduleInNull($schedule_2_Info->scheduleID,$schInfo);
            $schedule->updateScheduleToNullByID($schedule_1_Info->scheduleID);
            $newScheduleID=$schedule_2_Info->scheduleID;

            //$job = new SendShiftExchangeMail($schedule_1_Info->doctorID,$schedule_1_Info->scheduleID,$newScheduleID);
             //dispatch($job);
            
        }

        //醫生換班
        else{

        $doctor1 = $schedule_1_Info->doctorID;
        $doctor2 = $schedule_2_Info->doctorID;

        $shiftInfo = [
            'scheduleID_1' => $schedule_1_Info->scheduleID,
            'scheduleID_2' => $schedule_2_Info->scheduleID,
            'schID_1_doctor' => $doctor1,
            'schID_2_doctor' => $doctor2,
            'doc2Confirm' => 1,
            'adminConfirm' => 1,
            'date' => date('Y-m-d')
        ];

        $schedule_1_Date = $schedule_1_Info->date;

        $shiftRecords = new ShiftRecords();

        $newChangeSerial = $shiftRecords->addShifts($shiftInfo);

        $shiftRecords->doc2Confirm($newChangeSerial,1);
        $shiftRecords->adminConfirm($newChangeSerial,1);

        $schedule->checkScheduleStatus($scheduleID1,2);
        $schedule->checkScheduleStatus($scheduleID2,2);

        $user = new User();

        $oldscheduleID1 = $schedule_1_Info->scheduleID;
        $newscheduleID1 = $schedule_2_Info->scheduleID;
        $oldscheduleID2 = $schedule_2_Info->scheduleID;
        $newscheduleID2 = $schedule_1_Info->scheduleID;

        //$job1 = new SendShiftExchangeMail($doctor1,$oldscheduleID1,$newscheduleID1);
        //$job2 = new SendShiftExchangeMail($doctor2,$oldscheduleID2,$newscheduleID2);

        //dispatch($job1);
        //dispatch($job2);
        // $schedule->checkScheduleStatus($scheduleID1,2); //更改顏色
        // $schedule->checkScheduleStatus($scheduleID2,2); //更改顏色
        
        $schedule->exchangeSchedule($newChangeSerial);
           
        }
       
        
        //return redirect('shift-first-edition');
              // return redirect()->action(
                 // 'ShiftRecordsController@shiftFirstEdition', ['date' => $schedule_1_Date]
              // );
            

    }

    //調整班表->初版班表 顯示換班換班
    public function shiftFirstEditionShowShifts(Request $request){
        $data = $request->all();

        $scheduleID1 = (int)$data['scheduleID_1'];
        $scheduleID2 = (int)$data['scheduleID_2'];

        $schedule = new Schedule();

        $schedule_1_Info = $schedule->getScheduleDataByID($scheduleID1);
        $schedule_2_Info = $schedule->getScheduleDataByID($scheduleID2);

        $shiftInfo = [
            'scheduleID_1' => $schedule_1_Info->scheduleID,
            'scheduleID_2' => $schedule_2_Info->scheduleID,
            'schID_1_doctor' => $schedule_1_Info->doctorID,
            'schID_2_doctor' => $schedule_2_Info->doctorID,
            'doc2Confirm' => 1,
            'adminConfirm' => 1,
            'date' => date('Y-m-d')
        ];

        $schedule_1_Date = $schedule_1_Info->date;

        $shiftRecords = new ShiftRecords();

        $newChangeSerial = $shiftRecords->addShifts($shiftInfo);

        $shiftRecords->doc2Confirm($newChangeSerial,1);
        $shiftRecords->adminConfirm($newChangeSerial,1);

           
        //return redirect('shift-first-edition');
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
        
        $allShiftData = $shiftRecordObj->getMoreCheckShiftsRecordsInformationByMonth(false);  // 列出確認換班資訊

        $allRejectShiftData = $shiftRecordObj->getRejectShiftsRecordsInformation(true);  // 列出與自己相關的被拒絕換班資訊

        $currentMonth = date('Y-m-d');
        $nextMonth=date("Y-m",strtotime($currentMonth."+1 month"));

        $currentDoctor = $userObj->getCurrentUserInfo();

        $currentDoctorSchedule=$sheduleObj->getNextMonthShiftsByID($currentDoctor->doctorID); //查看目前登入的醫生班表資訊

        $scheduleArr=[];
        foreach ($currentDoctorSchedule as $schedule) {

                $scheduleID = $schedule->scheduleID;
                $date = $schedule->date;
                $sch=$schCateObj->findScheduleName($schedule->schCategorySerial)->schCategoryName;
                array_push($scheduleArr,array($scheduleID,$date,$sch));
        }

        $date = $sheduleObj->getDateNotInDateNotNull($currentDoctor->doctorID,$currentDoctor->major,$nextMonth);

        $array = array();

        //  //選擇換班醫生
        // $doctorName = $userObj->getAtWorkDoctors();

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
        
        $remarkObj = new Remark();   
        
        $remarks = $remarkObj->getCurrentRemarks();
        
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

        //選擇備註月份
        $monthList = [date('Y-m')];
        for($i = 1; $i <= 11; $i++) {
            array_push($monthList, date('Y-m', strtotime((-1 * $i).' month')));
        }
        
//        $currentMonth = date('Y-m');
//        $preMonth=date("Y-m", strtotime('-1 month'));
//        $beforePreMonth=date("Y-m", strtotime('-2 month'));


        return view('pages.schedule-shift-info', [
            'shiftRecords'=>$allShiftData,
            'shiftDataByDoctorID'=>$shiftDataByDoctorID,
            'currentDoctor'=>$currentDoctor,
            'currentDoctorSchedule'=>$scheduleArr,
            'date'=>$date,
            'allRejectShiftData'=>$allRejectShiftData,
            'remarks'=>$displayRemarksArr,
            'monthList' => $monthList,
//            'currentMonth'=>$currentMonth,
//            'preMonth'=>$preMonth,
//            'beforePreMonth'=>$beforePreMonth
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

        $shiftRecords = $shiftRecordObj->doc2CheckShifts(); //只顯示當月
        
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

            $schedule1 = $sheduleObj->getScheduleDataByID($record->scheduleID_1);
            $schedule2 = $sheduleObj->getScheduleDataByID($record->scheduleID_2);
            $sch1Name = $schCateObj->findScheduleName($schedule1->schCategorySerial)->schCategoryName;
            $sch2Name = $schCateObj->findScheduleName($schedule2->schCategorySerial)->schCategoryName;
            

            $recordDic['applier'] = $userObj->getDoctorInfoByID($record->schID_1_doctor)->name;
            $recordDic['receiver'] = $userObj->getDoctorInfoByID($record->schID_2_doctor)->name;

    
            $recordDic['sch1Content'] = $recordDic['applier'].' '.$sch1Name; 
            $recordDic['sch2Content'] = $recordDic['receiver'].' '.$sch2Name;
           
            $recordDic['applyDate'] = $record->date;
            


            
            $schedule1 = $sheduleObj->getScheduleDataByID($record->scheduleID_1);
            $schedule2 = $sheduleObj->getScheduleDataByID($record->scheduleID_2);
            $sch1Name = $schCateObj->findScheduleName($schedule1->schCategorySerial)->schCategoryName;
            $sch2Name = $schCateObj->findScheduleName($schedule2->schCategorySerial)->schCategoryName;
            

            $recordDic['sch1Date'] = $schedule1->date;
            $recordDic['sch2Date'] = $schedule2->date;
           
            
            
            array_push($displayArr, $recordDic);
        }
       $remarkObj = new Remark();   
        
        $remarks = $remarkObj->getCurrentRemarks();
        
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

       //選擇備註月份
        $monthList = [date('Y-m')];
        for($i = 1; $i <= 11; $i++) {
            array_push($monthList, date('Y-m', strtotime((-1 * $i).' month')));
        }
        
        return view('pages.shift-info', [
            'shiftRecords' => $displayArr,
            'remarks' => $displayRemarksArr,
            'monthList' =>$monthList
        ]);
    }
    
    // 排班人員確認換班
    public function adminAgreeShiftRecord(Request $request) {
        $data = $request->all();
        $serial = $data['id'];

        $shiftRecordObj = new ShiftRecords();
        $schedule = new Schedule();
        $shiftRecordObj->adminConfirm($serial,1);

        // $shiftRecordData = $shiftRecordObj->getShiftRecordByChangeSerial($serial);

        // $applier = $shiftRecordData->schID_1_doctor;
        // $receiver = $shiftRecordData->schID_2_doctor;
        // $applier_ScheduleID = $shiftRecordData->scheduleID_1;
        // $receiver_ScheduleID = $shiftRecordData->scheduleID_2;

        // $job = new SendShiftExchangingInformMail($applier,$receiver,$applier_ScheduleID,$receiver_ScheduleID);
        $scheduleID_1=$shiftRecordObj->getShiftRecordByChangeSerial($serial)->scheduleID_1;
        $scheduleID_2=$shiftRecordObj->getShiftRecordByChangeSerial($serial)->scheduleID_2;

        $schedule->checkScheduleStatus($scheduleID_1,2);
        $schedule->checkScheduleStatus($scheduleID_2,2);

        //$job = new SendShiftExchangingInformMail($serial);

        //dispatch($job);

        // return redirect('shift-info');

    }

    // 排班人員拒絕換班
    public function adminDisagreeShiftRecord($serial){
        $shiftRecordObj = new ShiftRecords();
        $schedule = new Schedule();

        $shiftRecordObj->adminConfirm($serial,2);


        $scheduleID_1=$shiftRecordObj->getShiftRecordByChangeSerial($serial)->scheduleID_1;
        $scheduleID_2=$shiftRecordObj->getShiftRecordByChangeSerial($serial)->scheduleID_2;

        $schedule->checkScheduleStatus($scheduleID_1,0);
        $schedule->checkScheduleStatus($scheduleID_2,0);

        //$job = new SendDenyConfirmedShiftExchangeMail($serial);

        //dispatch($job);

        return redirect('shift-info');

    }
    // 調整班表 初班版表 換班確認 顯示初版班表 調整換班
    public function shiftFirstEdition($date=null){
        $schedule = new Schedule();
        $user = new User();
        $reservationData = new ReservationData();

        $scheduleData = $schedule->getFirstSchedule();

        $doctors = $user->getAtWorkDoctors();
        //$doctorSchedule = $schedule->getScheduleByDoctorID($doctor->doctorID); //之後用ajax傳入id

        foreach ($scheduleData as $data) {
            $doctorName = $user->getDoctorInfoByID($data->doctorID);
            $data->doctorID = $doctorName->name;
        }

        $month = date("Y-m");
        $status=$reservationData->getDate($month)->status;

        $dateArr = explode('-', $date);
        

        return view('pages.shift-first-edition',array(
            'schedule' => $scheduleData,
            'doctorName' => $doctors,
            'status' => $status
        ));

    }
    // 調整班表 正式班表 顯示班表
    public function shiftScheduler($date=null){
        $schedule = new Schedule();
        $user = new User();

        $scheduleData = $schedule->getSchedule();

        $doctor = $user->getAtWorkDoctors();
        //$doctorSchedule = $schedule->getScheduleByDoctorID($doctor->doctorID); //之後用ajax傳入id

        foreach ($scheduleData as $data) {
            $doctorName = $user->getDoctorInfoByID($data->doctorID);
            $data->doctorID = $doctorName->name;
        }

        $dateArr = explode('-', $date);

        return view('pages.shift-scheduler',array(
            'schedule' => $scheduleData,
            'doctorName' => $doctor,
        ));

    }
    
    // 調整班表 初班版表 醫生排班現況(Ben)
    public function firstEditionSituation($date=null){
        
        return view('pages.first-edition-situation');
    }
    
    // 調整班表 初班版表 個人(Ben)
    public function shiftFirstEditionPersonal($date=null){
        
        return view('pages.shift-first-edition-personal');
    }
    
    // 取得積欠班的頁面
    public function getAccumulatedShifts() {
        $scheduleRecord = new ScheduleRecord();
        $user = new User();
        
        $doctorsRecords=$scheduleRecord->getScheduleRecord();

        //月份
        $monthList =[]; 

        $currentMonth= date("Y-m");
        $currentYear = date('Y');

        if($currentMonth <= ($currentYear.'-06')){
            for($i = 1; $i <= 6; $i++) {
                array_push($monthList, date('m', strtotime(($i+2).'month')));
            }
        }
        if($currentMonth >= ($currentYear.'-06')){
            for($i = 7; $i <= 12; $i++) {
                array_push($monthList, date('m', strtotime(($i+2).'month')));
            }
        }
        
        $doctors = $user->getAtWorkDoctors();

        $scheduleRecordArr = []; 

        $shiftHours = [];

        foreach ($doctors as $doctor ) {
           $recordDic =[
                'doctorID' => $doctor->doctorID,
                'doctorName' => $doctor->name,
                'totalShiftHours' => $scheduleRecord->getScheduleTotoalBydoctorID($doctor->doctorID),
                'shiftHours' => ""
            ];

            // $doctorID=$doctor->doctorID;
            // $doctorName=$doctor->name;
            // $totalShiftHours=$scheduleRecord->getScheduleTotoalBydoctorID($doctor->doctorID);

            $hours = $scheduleRecord->getScheduleRecordByDoctorID($doctor->doctorID);
            
            foreach ($hours as $shiftHour) {
                $shiftHours = array($shiftHour->shiftHours);
                 //array_push($scheduleRecordArr,[$shiftHours]);
            }

            array_push($scheduleRecordArr,[$shiftHours,$recordDic]);
            //array_push($scheduleRecordArr,[$doctorID,$doctorName,$totalShiftHours,$shiftHours]);

        }
        
        
        return view('pages.accumulatedShifts', [
             'doctors'=>$doctors,
             'doctorsRecords'=>$scheduleRecordArr,
             'shiftHours'=>$shiftHours,
             'monthList'=>$monthList
         ]);
    }
}
