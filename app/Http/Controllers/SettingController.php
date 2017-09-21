<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ReservationData;

class SettingController extends Controller
{
	//傳輸月份
    public function getSettingPage(){


        $nextMonth=date("m");
        $reservationData = new ReservationData();
        $strDate = $reservationData->getDate($nextMonth)->startDate;
        $endDate = $reservationData->getDate($nextMonth)->endDate;


        return view('pages.setting', array('month'=> $nextMonth,'strDate'=>$strDate,'endDate'=>$endDate));

    }

    public function getDate(){
    	$nextMonth=date("m");
        $reservationData = new ReservationData();
        $strDate = $reservationData->getDate($nextMonth)->startDate;
        $endDate = $reservationData->getDate($nextMonth)->endDate;

        $date = [$strDate,$endDate];

        return $date;

    }

    //設定日期
    public function setDate(Request $request){

    	$data = $request->all();

        $endDate = (int)$data['endDate'];
        $startDate = (int)$data['startDate'];
        $yearMonth = date('Y-m');
        $month = date('m');

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
        $count = $reservationData->countMonth($month);

        if($count==1){
        	$reservationData->updateDate($month,$strDate,$enDate);
        }
        else{
        	$reservationData->addDate($month,$strDate,$enDate);
        }

        //echo $month;
        // echo $yearMonth.'-'.$startDate;
        // echo $yearMonth.'-'.$endDate;
        return redirect('setting');

    }
}
