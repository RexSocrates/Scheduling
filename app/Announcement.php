<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;

class Announcement extends Model
{
    //
    protected $table = 'Announcement';
    
    // 取得所有公告
    public function getAnnouncements() {
        $announcements = DB::table('Announcement')
            ->orderBy('date', 'desc')
            ->get();
        
        return $announcements;
    }
    
    // 透過公告編號取得單一公告
    public function getAnnouncement($serial) {
        $announcement = Db::table('Announcement')
            ->where('announcementSerial', $serial)
            ->first();
        
        return $announcement;
    }
    
    // 新增公告
    public function addAnnouncement($data) {
        $currentMonth = date('Y-m-d');
        
        $newSerial = DB::table('Announcement')->insertGetId([
            'doctorID' => $data['doctorID'],
            'title' => $data['title'],
            'content' => $data['content'],
            'date' => $currentMonth
        ]);
        
        return $newSerial;
    }
}
