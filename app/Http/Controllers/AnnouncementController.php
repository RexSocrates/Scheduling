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
        $month=date("m");
        $year = date('Y');
        $startDate = $reservationData->getDate($month)->startDate;
        $endDate = $reservationData->getDate($month)->endDate;

//        foreach($announcements as $obj) {
//            echo 'Serial : '.$obj->announcementSerial.'<br>';
//            echo 'Title : '.$obj->title.'<br>';
//            echo 'Content : '.$obj->content.'<br>';
//            echo '<br>';
//        }
        
        return view('pages.index', [
            'announcements' => $announcements,
            'currentOfficialLeaveHours' => $leavehours,
            'startDate' => $year.'/'.$month.'/'.$startDate,
            'endDate' => $year.'/'.$month.'/'.$endDate,
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
        $announcement = $announcementObj->getAnnouncement($data['serial']);
        
        return [$announcement->announcementSerial, $announcement->title, $announcement->content];
    }
}
