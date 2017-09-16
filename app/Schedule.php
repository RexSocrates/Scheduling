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
        $schedule = DB::table('Schedule')
                    ->get();
        
        return $schedule;
    }

    //取得所有正式班表資訊
	public function getSchedule() {
        $schedule = DB::table('Schedule')
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

     //查看目前登入的醫生班表資訊
    public function getScheduleByCurrentDoctorID()
    {
        $user = new User();
        $id = $user->getCurrentUserID();
        $doctorScheduleList = DB::table('Schedule')->where("doctorID",$id)->get();
         
        return $doctorScheduleList;
    }
    
    //透過醫生ID 取得所有正式上班資料
    public function getScheduleByDoctorID($id) {
        $schedule = DB::table('Schedule')
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
            ->where('doctorID', $id)
            ->where('date', $date)
            ->count();
        
        return $schedule;
    }

    //確認醫生假日班數 醫生id
    public function checkDocScheduleInWeekend($id){
        $schedule = DB::table('Schedule')
            ->where('doctorID', $id)
            ->where('isWeekday', 0)
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
            ->where('doctorId', $id)
            ->where('date', 'like', $nextMonth.'%')
            ->get();
        
        return $shifts;
    }
    // 透過醫生ID 取得當月醫生上的所有班
    public function getCurrentMonthShiftsByID($id) {
        $currentMonth = date('Y-m');
        
        $shifts = DB::table('Schedule')
            ->where('doctorId', $id)
            ->where('date', 'like', $currentMonth.'%')
            ->get();
        return $shifts;
    }
    
     // 透過醫生ID 取得當月與下個月醫生上的所有班正式
    public function getCurrentAndNextMonthShiftsByID($id) {
        $currentMonth = date('Y-m');
        
        $shifts = DB::table('Schedule')
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
    protected function updateDoctorForSchedule($scheduleID, $doctorID) {
        $affectedRows = DB::table('Schedule')
            ->where('scheduleID', $scheduleID)
            ->update([
                'doctorID' => $doctorID
            ]);
        
        return $affectedRows;
    }
    
    // 換班
    public function exchangeSchedule($changeSerial) {
        $shiftRecord = new ShiftRecords();
        
        $record = $shiftRecord->getShiftRecordByChangeSerial($changeSerial);
        
        $scheduleID_1 = $record->scheduleID_1;
        $scheduleID_2 = $record->scheduleID_2;
        
        $doctor1 = $record->schID_1_doctor;
        $doctor2 = $record->schID_2_doctor;
        
        $this->updateDoctorForSchedule($scheduleID_1, $doctor2);
        $this->updateDoctorForSchedule($scheduleID_2, $doctor1);
        
    }
}