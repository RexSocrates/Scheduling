<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

use App\ShiftRecords;
use App\Reservation;

class Schedule extends Model
{
	protected $table = 'Schedule';


    //取得所有初版班表資訊
    public function getFirstSchedule() {
        $currentMonth = date('Y-m');
        
        $schedule = DB::table('Schedule')
            ->whereNotNull('doctorID')
            ->where('date', 'like', date('Y-m', strtotime($currentMonth.' +1 month')).'%')
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

    //透過班ID取得單一班表資訊
    public function countScheduleDataByDateAndSessionID($date,$session) {
        $count = DB::table('Schedule')
            ->whereNotNull('doctorID')
            ->where('schCategorySerial', $session)
            ->where('date', 'like', $date.'%')
            ->count();
        
        return $count;
    }

     //透過班ID取得單一班表資訊
    public function getScheduleDataByDateAndSessionID($date,$session) {
        $schedule = DB::table('Schedule')
            ->whereNotNull('doctorID')
            ->where('schCategorySerial', $session)
            ->where('date', 'like', $date.'%')
            ->first();
        
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
                'doctorID' => null
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
    public function totalShiftFirstEdition($doctorID){
        $currentMonth = date('Y-m');
        $nextMonth=date("Y-m",strtotime($currentMonth."+1 month"));

        $count = DB::table('Schedule')
        ->whereNotNull('doctorID')
        ->where('doctorID',$doctorID)
        ->where('date', 'like', $nextMonth.'%')
        ->whereNotIn('schCategorySerial', [1,2])
        ->count();

        return $count;
    }
}