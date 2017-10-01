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

        $month = date("Y-m");
        $nextMonth=date("Y-m",strtotime("+1 month"));
        $reservationData = new ReservationData();

        $count = $reservationData->countMonth($nextMonth);
        $firstSchedule = 0;

        $today = date("Y-m-d");//現在時間
        $m = (int)date('m');

        if($count == 1){
            if($reservationData->getStatus($nextMonth)->status ==1){
                $m = (int)date('m',strtotime("+1 month"));
                $strDate = $reservationData->getDate($nextMonth)->startDate;
                $endDate = $reservationData->getDate($nextMonth)->endDate;
                $status = $reservationData->getDate($nextMonth)->status;
                    if($today<($nextMonth.'-'.$endDate)){
                        $firstSchedule=1;
            }
                    }
    }
        
        else if($reservationData->getStatus($month)->status !=1){
            $m = (int)date('m',strtotime("+1 month"));
            $strDate=1;
            $endDate=10;
            $status=$reservationData->getStatus($month)->status;
            $firstSchedule=1;
        }

        else{
            $strDate = $reservationData->getDate($month)->startDate;
            $endDate = $reservationData->getDate($month)->endDate;
            $status = $reservationData->getDate($month)->status;
            if($today<($month.'-'.$endDate)){
                $firstSchedule=1;
            }
        }

        return view('pages.setting', array('month'=> $m,'strDate'=>$strDate,'endDate'=>$endDate,'status'=>$status,'firstSchedule'=>$firstSchedule));

    }

    public function getDate(){
    	$month=date("Y-m");
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

        $reservationData = new ReservationData();

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

        
        $count = $reservationData->countMonth($yearMonth);

        // if($count==1){
            $status = $reservationData->getStatus($yearMonth)->status;
                if($status !=0 && $status !=1 ){
                    $yearMonth = date('Y-m',strtotime("+1 month"));
                }
        	$reservationData->updateDate($yearMonth,$strDate,$enDate);
            

        //}
        // else{
        // 	$reservationData->addDate($yearMonth,$strDate,$enDate);

        // }

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
        $reservationData = new ReservationData();

        $data=[
            'title'=>"預班已開放",
            'content'=>"開放預班",
            'doctorID'=> $user->getCurrentUserID()
        ];

        $month=date("Y-m",strtotime("+1 month"));

        $reservationData->addDate($month,1,10);

        $announcement->addAnnouncement($data);

    }
}
