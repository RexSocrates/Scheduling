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
            ->orderBy('announcementSerial', 'desc')
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
        $newSerial = DB::table('Announcement')->insertGetId([
            'doctorID' => $data['doctorID'],
            'title' => $data['title'],
            'content' => $data['content'],
            'date' => date('Y-m-d')
        ]);
        
        return $newSerial;
    }
    
    // 更新公告
    public function updateAccouncement($data) {
        DB::table('Announcement')
            ->where('announcementSerial', $data['announcementSerial'])
            ->update([
                'title' => $data['title'],
                'content' => $data['content'],
                'date' => date('Y-m-d')
            ]);
    }
    
    // 刪除公告
    public function deleteAnnouncement($serial) {
        DB::table('Announcement')
            ->where('announcementSerial', $serial)
            ->delete();
    }
}
