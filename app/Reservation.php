<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;
use App\User;
class Reservation extends Model
{

//    public $primaryKey = "resSerial";
//    public $timestamps = false;
//    protected $table = 'Reservation';
    //protected $table = 'DoctorAndReservation';
    
    protected $table = "Reservation";
    public $primaryKey = "resSerial";
    public $timestamps = false;
    

    //查看 預班資訊
    public function reservationList()
    {
    	$reservation = DB::table('Reservation')->get();

    	return $reservation;
    }
    
    // 取得單一 reservation
    public function getReservationBySerial($serial) {
        $res = DB::table('Reservation')
            ->where('resSerial', $serial)
            ->first();
        
        return $res;
    }
    
    // 取得次月所有預約的on班，不包含行政與教學班
    public function getNextMonthOnReservation() {
        // 取出次月時間字串
        $currentDate = date('Y-m');
        $dateArr = explode('-', $currentDate);
        
        $year = (int)$dateArr[0];
        $month = (int)$dateArr[1];
        
        if($month == 12) {
            $year += 1;
        }
        $month = ($month + 1) % 12;
        
        if($month <= 9) {
            $month = '0'.$month;
        }
        
        $nextMonthStr = $year.'-'.$month.'%';
        
        $reservations = DB::table('Reservation')
            ->where('date', 'like', $nextMonthStr)
            ->whereIn('categorySerial', [3, 4, 5, 6])
            ->orderBy('date')
            ->get();
        
        return $reservations;
    }
    
    // 取得次月所有預約的off班
    public function getNextMonthOffReservation() {
        // 取出次月時間字串
        $currentDate = date('Y-m');
        $dateArr = explode('-', $currentDate);
        
        $year = (int)$dateArr[0];
        $month = (int)$dateArr[1];
        
        if($month == 12) {
            $year += 1;
        }
        $month = ($month + 1) % 12;
        
        if($month <= 9) {
            $month = '0'.$month;
        }
        
        $nextMonthStr = $year.'-'.$month.'%';
        
        $reservations = DB::table('Reservation')
            ->where('date', 'like', $nextMonthStr)
            ->where('categorySerial', 7)
            ->orderBy('date')
            ->get();
        
        return $reservations;
    }
    
    // 取得 on班 預班資訊
    public function getOnReservation() {
        $reservationList = DB::table('Reservation')
            ->whereIn('categorySerial', [1, 2, 3, 4, 5, 6])
            ->get();
        
        return $reservationList;
    }
    
    // 取得 off班 預班資訊
    public function getOffReservation() {
        $reservationList = DB::table('Reservation')
            ->where('categorySerial', 0)
            ->get();
        
        return $reservationList;
    }

    //查看 登入中的使用者的預班資訊
    public function getReservationByID()
    {
        $user = new User();
        $id = $user->getCurrentUserID();
        
        $doctorData = DB::table('DoctorAndReservation')
            ->where("doctorID",$id)
            ->get();

        $arr = array();
        foreach ($doctorData as $doctorDatum ) {
            $arr[] = $doctorDatum->resSerial;
            
        }
        $data=DB::table('Reservation')
            ->whereIn("resSerial",$arr)
            ->get();
        return $data;

    }
    
    //查看 次月登入中的使用者的預班資訊
    public function getNextMonthReservationByID()
    {
        $user = new User();
        $id = $user->getCurrentUserID();
        
        $doctorData = DB::table('DoctorAndReservation')
            ->where("doctorID",$id)
            ->get();

        $arr = array();
        foreach ($doctorData as $doctorDatum ) {
            $arr[] = $doctorDatum->resSerial;
            
        }
        
        // 取出次月預約
        $currentDate = date('Y-m');
        $dateArr = explode('-', $currentDate);
        
        $year = (int)$dateArr[0];
        $month = (int)$dateArr[1];
        
        if($month == 12) {
            $year += 1;
        }
        $month = ($month + 1) % 12;
        
        if($month <= 9) {
            $month = '0'.$month;
        }
        
        $nextMonthStr = $year.'-'.$month.'%';
        
        $data=DB::table('Reservation')
            ->whereIn("resSerial",$arr)
            ->where('date', 'like', $nextMonthStr)
            ->get();
        return $data;

     }

     //計算醫生白天上班總數
    public function amountDayShifts()
    {
        $user = new User();
        $doctorData = DB::table('DoctorAndReservation')->where("doctorID",$user->getCurrentUserID())->get();
           //$date=DB::table('Reservation') -> whereIn("resSerial",)->date;

        $arr = array();
        foreach ($doctorData as $doctorDatum ) {
            $arr[] = $doctorDatum->resSerial;
            
        }
         $data=DB::table('Reservation') -> whereIn("resSerial",$arr)->whereIn('categorySerial',[3,5])->count();


         return $data;

     }

     //計算醫生夜班上班總數
    public function amountNightShifts()
    {
        $user = new User();
        $doctorData = DB::table('DoctorAndReservation')->where("doctorID",$user->getCurrentUserID())->get();
        //$date=DB::table('Reservation') -> whereIn("resSerial",)->date;

        $arr = array();
        foreach ($doctorData as $doctorDatum ) {
            $arr[] = $doctorDatum->resSerial;
        }
        $data=DB::table('Reservation') -> whereIn("resSerial",$arr)->whereIn('categorySerial',[4,6])->count();


        return $data;

    }


    // 新增或更新資料庫資料
    public function addOrUpdateReservation(array $data){
        $generatedSerial = 0;

        // 檢查是否有相同資料
        $count = $this->reservationExist($data);
        
        if($count==0){
            //資料庫中沒有相同資料，新增預班
            $generatedSerial = $this->addReservation($data);
         }
        else{
            //資料庫有相同資料，得到預班編號
            $generatedSerial = $this->getReservationSerial($data);
        }

        return $generatedSerial;

    }
    
    //日期加一
    public function date_add($date){
        $time = strtotime($date);
        $newdate = date('Y-m-d', $time + 24 * 60* 60);
        return $newdate;
    }
    
    // 回傳是否有相同預班資料
    public function reservationExist(array $data) {
        $count = DB::table("Reservation")
            ->where('isWeekday',$data['isWeekday'])
            ->where('location',$data['location']) 
            ->where('isOn',$data['isOn'])
            ->where('date',$data['date'])
            ->where('categorySerial', $data['categorySerial'])
            ->count();
        
        return $count;
    }
    
    // 新增預班資料
    public function addReservation(array $data) {
        $generatedSerial = DB::table('Reservation')->insertGetId([
            'isWeekday' => $data['isWeekday'],
            'location' => $data['location'],
            'isOn' => $data['isOn'],
            'date' => $data['date'],
            'endDate' => $this->date_add($data['date']),
            'categorySerial' => $data['categorySerial']
        ]);
        
        return $generatedSerial;
    }
    
    // 比對預班資料回傳預班編號
    public function getReservationSerial(array $data) {
        $res = DB::table("Reservation")
            ->where('isWeekday',$data['isWeekday'])
            ->where('location',$data['location']) 
            ->where('isOn',$data['isOn'])
            ->where('date',$data['date'])
            ->where('categorySerial', $data['categorySerial'])
            ->first();
        
        return $res->resSerial;
    }
    
    // 回傳此預班是否有人預約
    public function resIsMade($serial) {
        $count = DB::table('DoctorAndReservation')
            ->where('resSerial', $serial)
            ->count();
        
        if($count == 0) {
            return false;
        }
        
        return true;
    }

    public function getResrvationByDateandDoctorID($doctorID,$date){
        $resSerial = DB::table('Reservation')
            ->where('date', $date)
            ->where('isOn',0)
            ->get();

        $count=0;

        foreach ($resSerial as $res) {
            $count =  DB::table('DoctorAndReservation')
            ->where('doctorID',$doctorID)
            ->where('resSerial',$res->resSerial)
            ->count();
        }

        return $count;

    }
    
   
}
