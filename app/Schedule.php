<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

use App\ShiftRecords;
use App\Reservation;
use App\User;

class Schedule extends Model
{
	protected $table = 'Schedule';


    // public function test1($month){
    //         $info = DB::select('call usp_FillShift(?)',
    //                array($month));

    //         return $info;
    // }
   

    public function callProcedure(){
//        $procedureMonthStr="2018-01";
        
        $dateStr = date('Y-m');
        $dateArr = explode('-', $dateStr);
        $year = intval($dateArr[0]);
        $month = intval($dateArr[1]);
        
        if($month == 12) {
            $year += 1;
            $month = 1;
        }else {
            $month += 1;
        }
        
        $monthStr = '';
        if($month < 10) {
            $monthStr = '0'.$month;
        }else {
            $monthStr = $month;
        }
        $resMonth = $year.$monthStr;
        
        $info=DB::select('CALL usp_FillShift(?)',
                  array($resMonth));
        return $info;
    }

    //取得所有初版班表資訊
    public function getFirstSchedule() {
        
        $schedule = DB::table('Schedule')
            ->whereNotNull('doctorID')
            ->get();
        
        return $schedule;
    }

    //取得所有正式班表資訊
	public function getSchedule() {
        $schedule = DB::table('Schedule')
            ->whereNotNull('doctorID')
            ->where('confirmed',1)
            ->get();
        
        return $schedule;
    }


    //透過班ID取得單一班表資訊
    public function getScheduleDataByID($scheduleID) {
        $schedule = DB::table('Schedule')
            ->where('scheduleID', $scheduleID)
            ->first();
        
        return $schedule;
    }

    //計算班ID取得單一班表資訊
    public function countScheduleDataByDateAndSessionID($date,$session) {
        $count = DB::table('Schedule')
            ->whereNotNull('doctorID')
            ->where('schCategorySerial', $session)
            ->where('date', 'like', $date.'%')
            ->count();
        
        return $count;
    }

     //透過班ID取得單一班表資訊
    public function getScheduleDataByDateAndSessionID($date,$categoryID) {
        $schedule = DB::table('Schedule')
            ->whereNotNull('doctorID')
            ->where('schCategorySerial', $categoryID)
            ->where('date', 'like', $date.'%')
            ->first();
        
        return $schedule;
    }

     //透過班ID取得單一班表資訊 doctor is null
    public function getScheduleDataByDateAndSessionIDWhenDoctorIDisNull($date,$session) {
        $schedule = DB::table('Schedule')
            ->where('schCategorySerial', $session)
            ->where('date', $date)
            ->first();
        
        return $schedule;
    }

    //計算月份班數
    public function getScheduleDataByDate($date) {
        $count = DB::table('Schedule')
            ->whereNotNull('doctorID')
            ->where('date', 'like', $date.'%')
            ->count();
        
        return $count;
    }

    //取得醫生班表藉由日期
    public function getDoctorScheduleDataByDate($date) {
        $schedule = DB::table('Schedule')
            ->whereNotNull('doctorID')
            ->where('date', 'like', $date.'%')
            ->get();
        
        return $schedule;
    }

     //查看目前登入的醫生班表資訊
    public function getScheduleByCurrentDoctorID()
    {
        $user = new User();
        $id = $user->getCurrentUserID();
        $doctorScheduleList = DB::table('Schedule')
                    ->where("doctorID",$id)
                    ->whereNotNull('doctorID')
                    ->get();
         
        return $doctorScheduleList;
    }
    
    //透過醫生ID 取得所有正式上班資料
    public function getScheduleByDoctorID($id) {
        $schedule = DB::table('Schedule')
            ->whereNotNull('doctorID')
            ->where('doctorID', $id)
            ->where('confirmed',1)
            ->get();
        
        return $schedule;
    }

    //透過醫生ID 取得所有初版上班資料
    public function getFirstEditionScheduleByDoctorID($id) {
        $schedule = DB::table('Schedule')
            ->where('doctorID', $id)
            ->get();
        
        return $schedule;
    }

    //確認當天一位醫生是否有上班 醫生id
    public function checkDocStatus($id,$date){
        $schedule = DB::table('Schedule')
            ->whereNotNull('doctorID')
            ->where('doctorID', $id)
            ->where('date', $date)
            ->count();
        
        return $schedule;
    }

    //確認醫生假日班數 醫生id
    public function checkDocScheduleInWeekend($id){
        $currentMonth = date('Y-m');
        $nextMonth=date("Y-m",strtotime($currentMonth."+1 month"));

        $schedule = DB::table('Schedule')
            ->whereNotNull('doctorID')
            ->where('doctorID', $id)
            ->where('isWeekday', 0)
            ->where('date', 'like', $nextMonth.'%')
            ->count();
        
        return $schedule;
    }

    // 新增一筆上班資料
    public function addSchedule(array $data) {
        $reservation = new Reservation();
        
        $newScheduleID = DB::table('Schedule')->insertGetId([
            'doctorID' => $data['doctorID'],
            'schCategorySerial' => $data['schCategorySerial'],
            'isWeekday' => $data['isWeekday'],
            'location' => $data['location'],
            'date' => $data['date'],
            'endDate' => $reservation->date_add($data['date']),
            'confirmed' => $data['confirmed'],
        ]);
        
        return $newScheduleID;
    }
    


    
    // 透過醫生ID 取得下個月醫生上的所有班
    public function getNextMonthShiftsByID($id) {
        $currentMonth = date('Y-m');
        $nextMonth=date("Y-m",strtotime($currentMonth."+1 month"));
        
        $shifts = DB::table('Schedule')
            ->whereNotNull('doctorID')
            ->where('doctorId', $id)
            ->where('date', 'like', $nextMonth.'%')
            ->orderBy('date')
            ->get();
        
        return $shifts;
    }
    // 透過醫生ID 取得當月醫生上的所有班
    public function getCurrentMonthShiftsByID($id) {
        $currentMonth = date('Y-m');
        
        $shifts = DB::table('Schedule')
            ->whereNotNull('doctorID')
            ->where('doctorId', $id)
            ->where('date', 'like', $currentMonth.'%')
            ->get();
        return $shifts;
    }
    
     // 透過醫生ID 取得當月與下個月醫生上的所有班正式
    public function getCurrentAndNextMonthShiftsByID($id) {
        $currentMonth = date('Y-m');
        
        $shifts = DB::table('Schedule')
            ->whereNotNull('doctorID')
            ->where('doctorId', $id)
            ->where('date', 'like', $currentMonth.'%')
            ->get();
        return $shifts;
    }

    // 透過班ID更新單一個班
    public function updateScheduleByID($scheduleID, array $data) {
        $reservation = new Reservation();
        
        $affectedRows = DB::table('Schedule')
            ->where('scheduleID', $scheduleID)
            ->update([
                'schCategorySerial' => $data['schCategorySerial'],
                'isWeekday' => $data['isWeekday'],
                'location' => $data['location'],
                'date' => $data['date'],
                'endDate' => $reservation->date_add($data['date']),
                'confirmed' => $data['confirmed'],
            ]);
        
        return $affectedRows;
    }

    // 因醫生的變動,導致原本上班的地方醫生變為null
    public function updateScheduleToNullByID($scheduleID) {
        $reservation = new Reservation();
        
        $affectedRows = DB::table('Schedule')
            ->where('scheduleID', $scheduleID)
            ->update([
               'doctorID'=> null,
               'status'=>0
            ]);
        
        return $affectedRows;
    }

//查詢已存在的班,將原本doctorID null,改為有醫生上班
    public function addScheduleInNull($scheduleID, array $data){
        $reservation = new Reservation();
        
        $affectedRows = DB::table('Schedule')
            ->where('scheduleID', $scheduleID)
            ->update([
                'doctorID' => $data['doctorID']
            ]);
        
        return $affectedRows;
    }

    //查詢已存在的班,將原本doctorID null,改為有醫生上班,正是班表
    public function addFormalScheduleInNull($scheduleID, array $data){
        $reservation = new Reservation();
        
        $affectedRows = DB::table('Schedule')
            ->where('scheduleID', $scheduleID)
            ->update([
                'doctorID' => $data['doctorID'],
                'confirmed' => $data['confirmed']
            ]);
        
        return $affectedRows;
    }
    //更新醫生班表是否有被換班狀態
    public function checkScheduleStatus($scheduleID,$status){
        $affectedRows = DB::table('Schedule')
            ->where('scheduleID', $scheduleID)
            ->update([
                'status' => $status

            ]);
        
    }
    
    // 確認當月班表
    public function confirmSchedule() {
        $currentMonthStr = date('Y-m');
        
        $affectedRows = DB::table('Schedule')
            ->whereNotNull('doctorID')
            ->where('date', 'like', $currentMonthStr.'%')
            ->update([
                'confirmed' => true
            ]);
        
        return $affectedRows;
    }

     // 確認下月班表
    public function confirmNextMonthSchedule() {
        $currentMonth = date('Y-m');
        $nextMonth=date("Y-m",strtotime($currentMonth."+1 month"));
        
        $affectedRows = DB::table('Schedule')
            ->whereNotNull('doctorID')
            ->where('date', 'like', $nextMonth.'%')
            ->update([
                'confirmed' => true
            ]);
        
        return $affectedRows;
    }

    // 透過班ID刪除單一紀錄
    public function deleteScheduleByID($scheduleID) {
        DB::table('Schedule')
            ->where('scheduleID', $scheduleID)
            ->delete();
    }

     // 計算單一醫生下個月總班數
    public function confirmNextMonthScheduleByDoctorID($doctorID) {
        $currentMonth = date('Y-m');
        $nextMonth=date("Y-m",strtotime($currentMonth."+1 month"));
        
        $affectedRows = DB::table('Schedule')
            ->whereNotNull('doctorID')
            ->where('doctorID', $doctorID)
            ->where('date', 'like', $nextMonth.'%')
            ->count();
        
        return $affectedRows;
    }
    
    // 計算各種類的班的數量
    public function countScheduleCategory($shifts) {
        
        $shiftsData = [
            'taipeiDay' => 0,
            'taipeiNight' => 0,
            'tamsuiDay' => 0,
            'tamsuiNight' => 0,
            'others' => 0
        ];
        
        foreach($shifts as $shift) {
            switch($shift->schCategorySerial) {
                case 1 :
                    $shiftsData['others'] += 1;
                    break;
                case 2 :
                    $shiftsData['others'] += 1;
                    break;
                case 3 :
                    $shiftsData['taipeiDay'] += 1;
                    break;
                case 4 :
                    $shiftsData['taipeiDay'] += 1;
                    break;
                case 5 :
                    $shiftsData['taipeiDay'] += 1;
                    break;
                case 6 :
                    $shiftsData['taipeiDay'] += 1;
                    break;
                case 7 :
                    $shiftsData['taipeiDay'] += 1;
                    break;
                case 8 :
                    $shiftsData['taipeiDay'] += 1;
                    break;
                case 9 :
                    $shiftsData['tamsuiDay'] += 1;
                    break;
                case 10 :
                    $shiftsData['tamsuiDay'] += 1;
                    break;
                case 11 :
                    $shiftsData['tamsuiDay'] += 1;
                    break;
                case 12 :
                    $shiftsData['tamsuiDay'] += 1;
                    break;
                case 13 :
                    $shiftsData['taipeiNight'] += 1;
                    break;
                case 14 :
                    $shiftsData['taipeiNight'] += 1;
                    break;
                case 15 :
                    $shiftsData['taipeiNight'] += 1;
                    break;
                case 16 :
                    $shiftsData['taipeiNight'] += 1;
                    break;
                case 17 :
                    $shiftsData['taipeiNight'] += 1;
                    break;
                case 18 :
                    $shiftsData['taipeiNight'] += 1;
                    break;
                case 19 :
                    $shiftsData['tamsuiNight'] += 1;
                    break;
                case 20 :
                    $shiftsData['tamsuiNight'] += 1;
                    break;
                case 21 :
                    $shiftsData['tamsuiNight'] += 1;
                    break;
                default :
                    echo 'Something wrong';
                    break;
            }
        }
        
        return $shiftsData;
    }
    
    // 更新班表醫師
    public function updateDoctorForSchedule($scheduleID, $doctorID) {
        $affectedRows = DB::table('Schedule')
            ->where('scheduleID', $scheduleID)
            ->update([
                'doctorID' => $doctorID
            ]);
        
        return $affectedRows;
    }

    // 將刪除班表的醫生id改為null
    public function deleteDoctorID($scheduleID) {
           DB::table('Schedule')
            ->where('scheduleID', $scheduleID)
            ->update([
                'doctorID' => null,
                'status'=>0
            ]);
        
       
    }
    
    // 換班
    public function exchangeSchedule($changeSerial) {
        $shiftRecord = new ShiftRecords();
        
        $record = $shiftRecord->getShiftRecordByChangeSerial($changeSerial);
        
        $scheduleID_1 = $record->scheduleID_1;
        $scheduleID_2 = $record->scheduleID_2;
        
        // 取出換班的兩位醫生ID
        $doctor1 = $record->schID_1_doctor;
        $doctor2 = $record->schID_2_doctor;
        
        // 兩個上班資訊中的醫師ID互換，原本的上班編號不動
        $this->updateDoctorForSchedule($scheduleID_1, $doctor2);
        $this->updateDoctorForSchedule($scheduleID_2, $doctor1);
        
    }

    //計算醫生已上白班數
    public function totalDayShiftFirstEdition($doctorID){
        $currentMonth = date('Y-m');
        $nextMonth=date("Y-m",strtotime($currentMonth."+1 month"));

        $count = DB::table('Schedule')
        ->whereNotNull('doctorID')
        ->where('doctorID',$doctorID)
        ->where('date', 'like', $nextMonth.'%')
        ->whereIn('schCategorySerial', [3, 4, 5, 6,7,8,10,11,12])
        ->count();

        return $count;
    }
    //計算醫生已上夜班數
    public function totalNightShiftFirstEdition($doctorID){
        $currentMonth = date('Y-m');
        $nextMonth=date("Y-m",strtotime($currentMonth."+1 month"));

        $count = DB::table('Schedule')
        ->whereNotNull('doctorID')
        ->where('doctorID',$doctorID)
        ->where('date', 'like', $nextMonth.'%')
        ->whereIn('schCategorySerial', [13, 14, 15, 16,17,18,19,20,21])
        ->count();

        return $count;
    }

     //計算醫生已上台北數
    public function totalTaipeiShiftFirstEdition($doctorID){
        $currentMonth = date('Y-m');
        $nextMonth=date("Y-m",strtotime($currentMonth."+1 month"));

        $count = DB::table('Schedule')
        ->whereNotNull('doctorID')
        ->where('doctorID',$doctorID)
        ->where('date', 'like', $nextMonth.'%')
        ->whereIn('schCategorySerial', [3,4,5,6,7,8,13, 14, 15, 16,17,18])
        ->count();

        return $count;
    }

     //計算醫生已上淡水數
    public function totalTamsuiShiftFirstEdition($doctorID){
        $currentMonth = date('Y-m');
        $nextMonth=date("Y-m",strtotime($currentMonth."+1 month"));

        $count = DB::table('Schedule')
        ->whereNotNull('doctorID')
        ->where('doctorID',$doctorID)
        ->where('date', 'like', $nextMonth.'%')
        ->whereIn('schCategorySerial', [9,10,11,12,19,20,21])
        ->count();

        return $count;
    }

    //計算醫生已上內科數
    public function totalMedicalShiftFirstEdition($doctorID){
        $currentMonth = date('Y-m');
        $nextMonth=date("Y-m",strtotime($currentMonth."+1 month"));

        $count = DB::table('Schedule')
        ->whereNotNull('doctorID')
        ->where('doctorID',$doctorID)
        ->where('date', 'like', $nextMonth.'%')
        ->whereIn('schCategorySerial', [3,4,13,14,5,6,9,10,15,16,19,20])
        ->count();

        return $count;
    }

    //計算醫生已上外科數
    public function totalSurgicalShiftFirstEdition($doctorID){
        $currentMonth = date('Y-m');
        $nextMonth=date("Y-m",strtotime($currentMonth."+1 month"));

        $count = DB::table('Schedule')
        ->whereNotNull('doctorID')
        ->where('doctorID',$doctorID)
        ->where('date', 'like', $nextMonth.'%')
        ->whereIn('schCategorySerial', [7,8,11,12,17,18,21])
        ->count();

        return $count;
    }

    //計算醫生已上班書
    public function totalShift($doctorID,$month){
        
        //$month=date("Y-m", strtotime('+1 month'));

        $count = DB::table('Schedule')
        ->whereNotNull('doctorID')
        ->where('doctorID',$doctorID)
        ->where('date', 'like', $month.'%')
        ->count();

        return $count;
    }

    //  //計算醫生已上班書
    // public function totalShift($doctorID){
        
    //     $month=date("Y-m");

    //     $count = DB::table('Schedule')
    //     ->whereNotNull('doctorID')
    //     ->where('doctorID',$doctorID)
    //     ->where('date', 'like', $month.'%')
    //     ->count();

    //     return $count;
    // }

    //確認醫生前一天班是否為夜班
     public function getNightScheduleByDoctorIDandDate($doctorID,$date){
        $predate= date("Y-m-d",strtotime($date."-1 day"));

        $preNightcount = DB::table('Schedule')
                ->where('doctorID',$doctorID)
                ->where('date', $predate)
                ->whereIn('schCategorySerial',[13,14,15,16,17,18,19,20,21])
                ->count();

     
        return $preNightcount;

    }

    //確認醫生後一天班是否為白班
     public function geDayScheduleByDoctorIDandDate($doctorID,$date){
        $predate= date("Y-m-d",strtotime($date."+1 day"));

        $preNightcount = DB::table('Schedule')
                ->where('doctorID',$doctorID)
                ->where('date', $predate)
                ->whereIn('schCategorySerial',[1,2,3,4,5,6,7,8,9,10,11,12])
                ->count();

     
        return $preNightcount;

    }


    //確認醫生後一天班是否為白班
     public function getDayScheduleByDoctorIDandDate($doctorID,$date){
        $laterdate= date("Y-m-d",strtotime($date."+1 day"));

        $laterDaycount = DB::table('Schedule')
                ->where('doctorID',$doctorID)
                ->where('date', $laterdate)
                ->whereIn('schCategorySerial',[5,6,7,8,9,10,11,12])
                ->count();

       //  $count=0;
        
       //  if($preNightcount!=0){
       //       $count = DB::table('Schedule')
       //          ->where('doctorID',$doctorID)
       //          ->where('date', $date)
       //          ->whereIn('schCategorySerial',[3,4,5,6,7,8,9,10,11,12])
       //          ->count();

       // }
        return $laterDaycount;

    }

    //列出在當天非上班醫生
    public function getDoctorNotInDateWithoutMajor($date){

       $query = DB::table("Schedule")
                ->select('doctorID')
                ->where('date', 'like',$date)
                ->whereNotNull('doctorID');
                    
       $info = DB::table("Doctor")
                ->whereNotIn('doctorID',($query))
                ->get();


        return $info;
    }
    //列出在當天非上班醫生
    public function getDoctorNotInDate($date, $major){

       $query = DB::table("Schedule")
                ->select('doctorID')
                ->where('date', 'like',$date)
                ->whereNotNull('doctorID');
                    
       $info = DB::table("Doctor")
                ->whereIn('major',[$major,"All"])
                // ->orwhere('major',"All")
                ->whereNotIn('doctorID',($query))
                ->get();


        return $info;
    }

     //列出在當天非上班日期
    public function getDateNotInDate($scheduleID){


         $info = DB::select('call usp_AvailableShift(?,?)',
                   array($scheduleID,''));

        return $info;          

    }
    
    // //列出在當天非上班日期
    // public function getDateNotInDate($scheduleID){


    //      $info = DB::select('call usp_AvailableShiftDoctorNotNull(?,?)',
    //                array($scheduleID,''));


    //     return $info;          

    // }

     public function getDateNotInDateNotNull($scheduleID, $date){

        $info = DB::select('call usp_AvailableShiftDoctorNotNull(?,?)',
                   array($scheduleID,$date));
        // $query = DB::table("Schedule")
        //         ->select('date')
        //         ->where('date', 'like',$yearMonth.'%')
        //         ->where('doctorID',$doctorID)
        //         ->whereNotNull('doctorID');

        // $query2 = DB::table("Doctor")
        //         ->select('doctorID')
        //         ->whereIn('major',[$major,"All"]);

        // $info = DB::table("Schedule")
        //         ->whereNotIn('date',($query))
        //         ->where('date', 'like',$yearMonth.'%')
               
        //         ->whereNotNull('doctorID')
        //         ->orderBy('date')
        //         ->distinct()->get(['date']);


        return $info;          

    }

    public function getDoctorInDate($scheduleID,$date){
        // $schCategorySerial=[];

         $info = DB::select('call usp_AvailableShift(?,?)',
                   array($scheduleID,$date));

       
            

        // if($major_doctor == "Medical"){
        //      $schCategorySerial=[1,2,3,4,5,6,9,10,13,14,15,16,19,20];
        // }
        // else if($major_doctor == "Surgical"){
        //      $schCategorySerial=[1,2,3,4,7,8,11,12,13,14,17,18,21];
        // }
        // else if($major_doctor == "All"){
        //      $schCategorySerial=[1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21];
        // }

        // if($major_schedule == "All"){

        //     $info = DB::table("Schedule")
        //         ->whereIn("schCategorySerial",$schCategorySerial)
        //         ->where('date', 'like',$date2)
        //         ->get();
        // }
        
        // else{

        //     $query = DB::table("Doctor")
        //         ->select('doctorID')
        //         ->whereIn('major',[$major_schedule,"All"]);
                
                
        //     $info = DB::table("Schedule")
        //         ->where('date', 'like',$date2)
        //         ->whereIn('doctorID',$query)
        //         ->whereIn("schCategorySerial",$schCategorySerial)
        //         ->orwhereNull('doctorID')  
        //         ->whereIn("schCategorySerial",$schCategorySerial)
        //         ->where('date', 'like',$date2)
        //         ->get();

        // }
        

        return $info;          

    }
// public function getDoctorInDate($date1, $date2, $major_schedule, $major_doctor){
//         $schCategorySerial=[];
       
//         if($major_doctor == "Medical"){
//              $schCategorySerial=[1,2,3,4,5,6,9,10,13,14,15,16,19,20];
//         }
//         else if($major_doctor == "Surgical"){
//              $schCategorySerial=[1,2,7,8,11,12,17,18,21];
//         }
//         else if($major_doctor == "All"){
//              $schCategorySerial=[1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21];
//         }
//         if($major_schedule == "All"){
//             $info = DB::table("Schedule")
//                 ->whereIn("schCategorySerial",$schCategorySerial)
//                 ->where('date', 'like',$date2)
//                 ->get();
//         }
//         else{
//             $query = DB::table("Doctor")
//                 ->select('doctorID')
//                 ->whereIn('major',[$major_schedule,"All"]);

//             $query2 = DB::table("Schedule")
//                 ->select('doctorID')
//                 ->where('date','like',$date1);    
                
                
//             $info = DB::table("Schedule")
//                 ->where('date', 'like',$date2)
//                 ->whereIn('doctorID',$query)
                
//                 ->whereIn("schCategorySerial",$schCategorySerial)
                
//                 //->whereNotIn('doctorID',$query2)
//                 ->orwhereNull('doctorID') 
//                 ->whereIn("schCategorySerial",$schCategorySerial)
                
//                 ->where('date', 'like',$date2)

//                 ->get();
//         }
        
//         return $info;          
//     }
     public function getDoctorDateNotNull($scheduleID,$date){
        // $schCategorySerial=[];
       $info = DB::select('call usp_AvailableShiftDoctorNotNull(?,?)',
                   array($scheduleID,$date));


        // if($major_doctor == "Medical"){
        //      $schCategorySerial=[1,2,3,4,5,6,9,10,13,14,15,16,19,20];
        // }
        // else if($major_doctor == "Surgical"){
        //      $schCategorySerial=[1,2,7,8,11,12,17,18,21];
        // }
        // else if($major_doctor == "All"){
        //      $schCategorySerial=[1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21];
        // }


        // if($major_schedule == "All"){
        //     $info = DB::table("Schedule")
        //         ->whereIn("schCategorySerial",$schCategorySerial)
        //         ->whereNotNull('doctorID')
        //         ->where('date', 'like',$date2)
        //         ->get();

        // }

        // else{
        //     $query = DB::table("Doctor")
        //         ->select('doctorID')
        //         ->whereIn('major',[$major_schedule,"All"]);
                
                
        //     $info = DB::table("Schedule")
        //         ->whereIn('doctorID',$query)
        //         ->whereIn("schCategorySerial",$schCategorySerial)
        //         ->where('date', 'like',$date2)
        //         ->get();
        // }


        return $info;   
    }
    
    
    // 檢查一位醫生在當週非職登院區的班數
    public function getAnotherLocationShifts($doctorID, $date) {
        // date 日期格式 : 2017-01-01
        
        // 取得此日期是星期幾
        $week = intval(date('N', strtotime($date)));
        
        // 取得與星期一的差距
        $mondayGap = $week - 1;
        $modayDate = date('Y-m-d', strtotime($date.'-'.$mondayGap.' days'));
        
        // 與星期日的差距
        $sundayGap = 7 - $week;
        $sundayDate = date('Y-m-d', strtotime($date.'+'.$sundayGap.' days'));
        
        // 取得醫師職登院區
        $userObj = new User();
        $doctor = $userObj->getDoctorInfoByID($doctorID);
        
        $doctorLocation = $doctor->location;
        
        // 取得非職登院區
        $anotherLocation = '';
        if($doctorLocation == 'Taipei') {
            $anotherLocation = 'Tamsui';
        }else {
            $anotherLocation = 'Taipei';
        }
        
        // 取得在這一週目前在非職登院區的上班數
        $count = DB::table('Schedule')
            ->whereNotNull('doctorID')
            ->where('doctorID', $doctorID)
            ->where('location', $anotherLocation)
            ->whereBetween('date', [$modayDate, $sundayDate])
            ->count();
        
        return $count;
    }

    public function getDoctorDate(){
        $currentMonth = date('Y-m');
        $nextMonth=date("Y-m",strtotime($currentMonth."+1 month"));
        $count = DB::table('Schedule')
            ->whereNotNull('doctorID')
            ->where('doctorID', 3)
            ->whereNotIn('doctorID', [2])
            ->where('date', 'like', $nextMonth.'%')
            ->get();
        
        return $count;
        
    }
    
    // 從演算法輸入班表，每一次輸入一天的一個班
    public function setSchedule(array $data) {
        $newSerial = DB::table('Schedule')->insertGetId([
            'doctorID' => $data['doctorID'],
            'schCategorySerial' => $data['schCategorySerial'],
            'isWeekday' => $data['isWeekday'],
            'location' => $data['location'],
            'date' => $data['date'],
            'endDate' => $data['endDate'],
            'confirmed' => false,
            'status' => 0
        ]);
    }


    public function test($doctorID,$date){

            $info = DB::select('call usp_AvailableForShift(?,?)',
                   array($doctorID,$date)) ;

            return $info;
    }
    
    


}