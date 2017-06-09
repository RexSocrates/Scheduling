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
        // $data=DB::table('Reservation') -> whereIn("resSerial",[$doctorData])->get();

        $arr = array();
        foreach ($doctorData as $doctorDatum ) {
            arr[] = $doctorDatum->resSerial;
        }

        $data = $data=DB::table('Reservation') -> whereIn("resSerial",arr)->get();

        return $data;

        // return $data;
       
    }

    // 查詢 所有醫生預班的班數
    public function getReservationBySerial($periodSerial) {
        $data = DB::table('Reservation')
            ->where('periodSerial', $periodSerial)
            ->orderBy('doctorID')
            ->get();
        
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

   //  public function getReservationBySerial($serial) {
   //      $data = DB::table('Reservation')->where('resSerial', $serial)->first();

   //      return $data;
      
   // }

   
}
