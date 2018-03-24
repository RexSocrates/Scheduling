<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class DoctorAndReservation extends Model

{
    //
    protected $table = 'DoctorAndReservation';

    //醫生新增預班
    public function addDoctor($data){
        DB::table('DoctorAndReservation')->insert([
            'resSerial' => $data['resSerial'],
            'doctorID' => $data['doctorID'],
        ]);
    }

    //更新醫生預班資訊
    public function doctorUpdateReservation($oldResSerial,$newResSerial, $doctorID){
        DB::table('DoctorAndReservation')
            ->where('resSerial', $oldResSerial)
            ->where('doctorID',$doctorID)
            ->update(['resSerial' => $newResSerial]);
    }
    
    //查詢 單一時段上班的醫生
    public function getDoctorsByResSerial($serial) {
        $doctors = DB::table('DoctorAndReservation')
            ->where('resSerial', $serial)
            ->get();

        return $doctors;
    }

    //查詢 單一時段上班醫生總數
    public function amountInResserial($serial){
        $count = DB::table('DoctorAndReservation')
            ->where('resSerial', $serial)
            ->count();
        
        return $count;
    }
    //查詢 單一醫生預班的總班數
    public function amountInDoctorReservation($doctorID){
        $count = DB::table('DoctorAndReservation')
            ->where('doctorID', $doctorID)
            ->count();

        return $count;
    }
    
    // 刪除 單一預班
    public function deleteReservation($resSerial, $doctorID) {
        DB::table('DoctorAndReservation')
            ->where('resSerial', $resSerial)
            ->where('doctorID', $doctorID)
            ->delete();
    }
    
    // 回傳單一醫生on班數量
    public function getOnResAmount($doctorID) {
        $resSerials = DB::table('DoctorAndReservation')
            ->where('doctorID', $doctorID)
            ->get();
        
        $serials = [];
        foreach($resSerials as $resSerial) {
            array_push($serials, $resSerial->resSerial);
        }
        
        $amount = DB::table('Reservation')
            ->whereIn('resSerial', $serials)
            ->whereIn('categorySerial', [3, 4, 5, 6])
            ->count();
        
        return $amount;
    }
    
    
    // 回傳單一醫生off班數量
    public function getOffResAmount($doctorID) {
        $resSerials = DB::table('DoctorAndReservation')
            ->where('doctorID', $doctorID)
            ->get();
        
        $serials = [];
        foreach($resSerials as $resSerial) {
            array_push($serials, $resSerial->resSerial);
        }
        
        $amount = DB::table('Reservation')
            ->whereIn('resSerial', $serials)
            ->where('categorySerial', 7)
            ->count();
        
        return $amount;
    }
    
    // 回傳單一醫生次月on班數量
    public function getNextMonthOnResAmount($doctorID) {
        $resSerials = DB::table('DoctorAndReservation')
            ->where('doctorID', $doctorID)
            ->get();
        
        $serials = [];
        foreach($resSerials as $resSerial) {
            array_push($serials, $resSerial->resSerial);
        }
        
        $amount = DB::table('Reservation')
            ->whereIn('resSerial', $serials)
            ->whereIn('categorySerial', [3, 4, 5, 6])
            ->where('date', 'like', $this->getNextMonthString().'%')
            ->count();
        
        return $amount;
    }
    
    
    // 回傳單一醫生次月off班數量
    public function getNextMonthOffResAmount($doctorID) {
        $resSerials = DB::table('DoctorAndReservation')
            ->where('doctorID', $doctorID)
            ->get();
        
        $serials = [];
        foreach($resSerials as $resSerial) {
            array_push($serials, $resSerial->resSerial);
        }
        
        $amount = DB::table('Reservation')
            ->whereIn('resSerial', $serials)
            ->where('categorySerial', 7)
            ->where('date', 'like', $this->getNextMonthString().'%')
            ->count();
        
        return $amount;
    }
    
    private function getNextMonthString() {
        // 取出次月預約
        $currentDate = date('Y-m');
        $dateArr = explode('-', $currentDate);
        
        $year = (int)$dateArr[0];
        $month = (int)$dateArr[1];
        
        if($month == 12) {
            $year += 1;
            $month = 1;
        }else {
            $month += 1;
        }
        
        
        if($month <= 9) {
            $month = '0'.$month;
        }
        
        $nextMonthStr = $year.'-'.$month;
        
        return $nextMonthStr; 
    }
    
}
