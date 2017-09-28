<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ReservationData;
use\App\User;
use\App\Announcement;

class SettingController extends Controller
{
	//傳輸月份
    public function getSettingPage(){


        $month=date("Y-m",strtotime("+1 month"));
        $reservationData = new ReservationData();

        $count = $reservationData->countMonth($month);

        if($count==0){
            $strDate=1;
            $endDate=10;
            $status=0;

        }
        else{
            $strDate = $reservationData->getDate($month)->startDate;
            $endDate = $reservationData->getDate($month)->endDate;
            $status = $reservationData->getDate($month)->status;
        }


        $m = (int)date('m', strtotime("+1 month"));

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
        $yearMonth = date('Y-m',strtotime("+1 month"));
    
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
        $user = new User();
        $announcement = new Announcement();

        $reservationData->setFirstScheduleAnnounceStatus();

        $data=[
            'title'=>"公布初版班表",
            'content'=>"已公布初版班表",
            'doctorID'=> $user->getCurrentUserID()
        ];

        $announcement->addAnnouncement($data);


        return redirect('setting');
    }

    public function toReservation(){
        $user = new User();
        $announcement = new Announcement();

        $data=[
            'title'=>"預班已開放",
            'content'=>"開放預班",
            'doctorID'=> $user->getCurrentUserID()
        ];

        $announcement->addAnnouncement($data);

    }
}
