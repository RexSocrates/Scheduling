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
        $currentMonthStr = date('Y-m')
        
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
}