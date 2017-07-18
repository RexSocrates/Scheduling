<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Schedule extends Model
{
	protected $table = 'Schedule';

    //取得所有班表資訊
	public function getSchedule() {
        $schedule = DB::table('Schedule')
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

    //查看 單一醫生班表資訊
     public function getScheduleByDoctorID()
      {
        $user = new User();
        $id = $user->getCurrentUserID();
        $doctorData = DB::table('Schedule')->where("doctorID",$id)->get();
         
        $arr = array();
        foreach ($doctorData as $doctorDatum ) {
            $arr[] = $doctorDatum->scheduleID;
            
        }
         $data=DB::table('Schedule') -> where("scheduleID",$arr)->get();
         return $data;

     }
    
    
    // 新增一比上班資料
    public function addSchedule(array $date) {
        $newScheduleID = DB::table('Schedule')->insertGetId([
            'doctorID' => $data['doctorID'],
            'shiftName' => $data['shiftName'],
            'categorySerial' => $data['categorySerial'],
            'isWeekday' => $data['isWeekday'],
            'location' => $data['location'],
            'date' => $data['date'],
            'endDate' => $data['endDate'],
            'confirmed' => $data['confirmed'],
        ]);
        
        return $newScheduleID;
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
    
    // 透過班ID更新單一個班
    public function updateScheduleByID($scheduleID, array $data) {
        $affectedRows = DB::table('Schedule')
            ->where('scheduleID', $scheduleID)
            ->update([
                'doctorID' => $data['doctorID'],
                'shiftName' => $data['shiftName'],
                'categorySerial' => $data['categorySerial'],
                'isWeekday' => $data['isWeekday'],
                'location' => $data['location'],
                'date' => $data['date'],
                'endDate' => $data['endDate'],
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
}