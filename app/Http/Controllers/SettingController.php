<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ReservationData;

class SettingController extends Controller
{
	//傳輸月份
    public function getSettingPage(){


        $month=date("Y-m");
        $reservationData = new ReservationData();
        $strDate = $reservationData->getDate($month)->startDate;
        $endDate = $reservationData->getDate($month)->endDate;
        $status = $reservationData->getDate($month)->status;
        $m = (int)date('m', strtotime($month));

        return view('pages.setting', array('month'=> $m,'strDate'=>$strDate,'endDate'=>$endDate,'status'=>$status ));

    }

    public function getDate(){
    	$month=date("m");
        $reservationData = new ReservationData();
        $strDate = $reservationData->getDate($month)->startDate;
        $endDate = $reservationData->getDate($month)->endDate;
        

        $date = [$strDate,$endDate];

        return $date;

    }

    //設定日期
    public function setDate(Request $request){

    	$data = $request->all();

        $endDate = (int)$data['endDate'];
        $startDate = (int)$data['startDate'];
        $yearMonth = date('Y-m');
    
        if($startDate<10){
            $strDate='0'.$startDate;
        }
        else{
            $strDate=$startDate;
        }

        if($endDate<10){
            $enDate='0'.$endDate;
        }
        else{
            $enDate=$endDate;
        }

        $reservationData = new ReservationData();
        $count = $reservationData->countMonth($yearMonth);

        if($count==1){
        	$reservationData->updateDate($yearMonth,$strDate,$enDate);
        }
        else{
        	$reservationData->addDate($yearMonth,$strDate,$enDate);
        }

        //echo $month;
        // echo $yearMonth.'-'.$startDate;
        // echo $yearMonth.'-'.$endDate;
        return redirect('setting');

    }

    public function setfirstSchedule(Request $request){

        $reservationData = new ReservationData();

        $reservationData->setFirstScheduleAnnounceStatus();

        return redirect('setting');
    }
}
