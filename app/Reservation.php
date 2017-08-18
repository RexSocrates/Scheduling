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

    //查看 單一醫生預班資訊
    public function getReservationByID()
      {
        $user = new User();
        $id = $user->getCurrentUserID();
        
        $doctorData = DB::table('DoctorAndReservation')->where("doctorID",$id)->get();
        //$date=DB::table('Reservation') -> whereIn("resSerial",)->date;

        $arr = array();
        foreach ($doctorData as $doctorDatum ) {
            $arr[] = $doctorDatum->resSerial;
            
        }
         $data=DB::table('Reservation') -> whereIn("resSerial",$arr)->get();
         return $data;

     }

     //計算醫生白天上班總數
    public function amountDayShifts()
      {
        $doctorData = DB::table('DoctorAndReservation')->where("doctorID","1")->get();
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
        $doctorData = DB::table('DoctorAndReservation')->where("doctorID","1")->get();
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

//    //更新預班
//    public function addAndUpdateReservation(array $data){
//        // $periodSerial, $isWeekday, $location, $isOn, $remark, $date
//        $generatedSerial ＝ 0;
//
//        $count = reservationExist($data);
//        
//        if($count==0){
//            // 更新後的資料不存在，因此新增一筆資料
//            $generatedSerial = addReservation($data);
//         }
//        else{
//            //更新後的資料以存在資料庫，得到預班編號
//            $generatedSerial = getReservationSerial($data);
//        }   
//
//        return $generatedSerial;     
//    }
    
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
    
    // 回傳預班編號
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

   //  public function getReservationBySerial($serial) {
   //      $data = DB::table('Reservation')->where('resSerial', $serial)->first();

   //      return $data;
      
   // }

   
}
