<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;
class Reservation extends Model
{
    protected $table = 'Reservation';
    //protected $table = 'DoctorAndReservation';
    

    //查看 預班資訊
     public function reservationList()
    {
    	$reservation = DB::table('Reservation')->get();

    	return $reservation;
    }

    //查看 單一醫生預班資訊
     public function getReservationByID()
      {
           $doctorData = DB::table('DoctorAndReservation')->where("doctorID","1")->get();
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


    //新增預班
    public function addReservation($periodSerial, $isWeekday, $location, $isOn, $remark, $date){
        $generatedSerial = 0;

        $count = DB::table("Reservation")
            -> where('periodSerial',$periodSerial) 
            -> where('isWeekday',$isWeekday)
            -> where('location',$location) 
            -> where('isOn',$isOn)
            -> where('date',$date)
            ->count();
        if($count==0){
            //新增預班
                   
    	            $generatedSerial = DB::table('Reservation')-> insertGetId([
                    'periodSerial' => $periodSerial,
    				'isWeekday' => $isWeekday,
    				'location' => $location,
    				'isOn' => $isOn,
    				'remark' => $remark,
    				'date' => $date,
                    'endDate' => date_add($date),
                    
    		]);

         }
        else{
            //得到預班表id
                $generatedSerial = DB::table("Reservation")
                -> where('periodSerial',$periodSerial) 
                -> where('isWeekday',$isWeekday)
                -> where('location',$location) 
                -> where('isOn',$isOn)
                -> where('date',$date)
                -> value('resSerial');
        }

        return $generatedSerial;

    }

    //更新預班
    public function updateReservation($id, $periodSerial, $isWeekday, $location, $isOn, $remark, $date){
        $generatedSerial＝0;

        $count = DB::table("Reservation")
                -> where('periodSerial',$periodSerial) 
                -> where('isWeekday',$isWeekday)
                -> where('location',$location) 
                -> where('isOn',$isOn)
                -> where('date',$date)
                ->count();
            if($count==0){
                //新增預班
                    $generatedSerial = DB::table('Reservation')-> insertGetId([
                    'periodSerial' => $periodSerial,
                    'isWeekday' => $isWeekday,
                    'location' => $location,
                    'isOn' => $isOn,
                    'remark' => $remark,
                    'date' => $date,
                    'endDate' => date_add($date),

                    
            ]);

            }
            else{
                //取得預班id
                $generatedSerial = DB::table("Reservation")
                -> where('periodSerial',$periodSerial) 
                -> where('isWeekday',$isWeekday)
                -> where('location',$location) 
                -> where('isOn',$isOn)
                -> where('date',$date)
                -> value('resSerial');
            }     

             return $generatedSerial;     
    }
    //日期加一
    public function date_add($date){
        $time = strtotime($date);
        $newdate = date('Y-m-d', $time + 24 * 60* 60);
        return $newdate;
    } 

   //  public function getReservationBySerial($serial) {
   //      $data = DB::table('Reservation')->where('resSerial', $serial)->first();

   //      return $data;
      
   // }

   
}
