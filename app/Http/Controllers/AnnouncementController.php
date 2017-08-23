<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// import model
use App\Announcement;
use App\User;

class AnnouncementController extends Controller
{
    // 列出公告頁面
    public function getAnnouncementPage() {
        $announcementObj = new Announcement();
        
        $announcements = $announcementObj->getAnnouncements();
        
        return view('pages.index', [
            'announcements' => $announcements
        ]);
    }
    
    // 新增公告
    public function addAnnouncement(Request $request) {
        $data = $request->all();
        
        $announcementObj = new Announcement();
        $userObj = new User();
        
        $announcementData = [
            'doctorID' => $userObj->getCurrentUserID(),
            'title' => $data['title'],
            'content' => $data['content']
        ];
        
        $announcementObj->addAnnouncement($announcementData);
        
        return redirect('announcement');
    }
}
