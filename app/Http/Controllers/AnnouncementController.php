<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// import model
use App\Announcement;
use App\User;
use App\ReservationData;

class AnnouncementController extends Controller
{
    // 列出公告頁面
    public function getAnnouncementPage() {
        $announcementObj = new Announcement();
        $userObj = new User();
        
        $announcements = $announcementObj->getAnnouncements();
        $leavehours = $userObj->getCurrentUserInfo()->currentOfficialLeaveHours;

        $reservationData = new ReservationData();

        $currentMonth = date('Y-m');
        $nextMonth=date("Y-m",strtotime($currentMonth."+1 month"));

        $count=$reservationData->countMonth($currentMonth);

        if($count==0){
            $startDate="尚未開放";
            $endDate="尚未開放";

        }
        else{
            if($reservationData->countMonth($nextMonth)!=0){
                $startDate = $nextMonth.'-'.$reservationData->getDate($nextMonth)->startDate;
                $endDate = $nextMonth.'-'.$reservationData->getDate($nextMonth)->endDate;
                $status = $reservationData->getDate($nextMonth)->status;
            }
            else{
                $startDate = $currentMonth.'-'.$reservationData->getDate($currentMonth)->startDate;
                $endDate = $currentMonth.'-'.$reservationData->getDate($currentMonth)->endDate;
                $status = $reservationData->getDate($currentMonth)->status;
            }
        }
        
        return view('pages.index', [
            'announcements' => $announcements,
            'currentOfficialLeaveHours' => $leavehours,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'status'=>$status
        ]);
    }
    
    // 新增公告
    public function addOrUpdateAnnouncement(Request $request) {
        $data = $request->all();
        
        $announcementObj = new Announcement();
        $userObj = new User();
        
        $announcementSerial = $data['hiddenSerial'];
        
        if($announcementSerial == -1) {
            // 新增公告
            $announcementData = [
                'doctorID' => $userObj->getCurrentUserID(),
                'title' => $data['title'],
                'content' => $data['content']
            ];
            
            $announcementObj->addAnnouncement($announcementData);
        }else {
            // 更新公告
            $announcementData = [
                'announcementSerial' => $announcementSerial,
                'title' => $data['title'],
                'content' => $data['content']
            ];
            
            $announcementObj->updateAccouncement($announcementData);
        }
        
        
        
        return redirect('index');
    }
    
    // 刪除公告
    public function deleteAnnouncement($serial) {
        $announcementObj = new Announcement();
        
        $announcementObj->deleteAnnouncement($serial);
        
        return redirect('index');
    }
    
    // 接收AJAX的request，取得單一公告
    public function getAnnouncement(Request $request) {
        $data = $request->all();
        
        $announcementObj = new Announcement();
        $userObj = new User();
        $announcement = $announcementObj->getAnnouncement($data['serial']);
        $announcementName = $userObj->getDoctorInfoByID($announcement->doctorID)->name;
        
        return [$announcement->announcementSerial, $announcement->title, $announcement->content, $announcementName, $announcement->date ];
    }
}
