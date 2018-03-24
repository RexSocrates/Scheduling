<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Remark extends Model
{
    
    
    // 取得所有備註
    public function getRemarks() {
        $remarks = DB::table('Remark')
            ->get();
        
        return $remarks;
    }

    // 取得當月所有備註
    public function getCurrentRemarks() {
        $currentMonth = date('Y-m');
        $remarks = DB::table('Remark')
            ->where('date', 'like', $currentMonth.'%')
            ->get();
        
        return $remarks;
    }

    // 取得所選擇月份所有備註
    public function getRemarksByMonth($month) {
        $remarks = DB::table('Remark')
            ->where('date', 'like', $month.'%')
            ->get();
        
        return $remarks;
    }
    
    // 透過備註編號取得單一備註
    public function getRemarkBySerial($serial) {
        $remark = DB::table('Remark')
            ->where('remarkSerial', $serial)
            ->first();
        
        return $remark;
    }
    
    
    // 新增備註
    public function addRemark($doctorID,$remark){
    	$addRemark = DB::table("Remark")->insertGetId([
            'doctorID' => $doctorID,
    		'remark' => $remark,
            'date' => date('Y-m-d')
        ]);

    	return $addRemark;
    }


    //透過醫生編號找備註
    public function getRemarkByDoctorID($doctorID){
        $remark = DB::table('Remark')
            ->where('doctorID', $doctorID)
            ->first();
        
        return $remark;
    }

    //透過醫生編號找這個月備註
    public function getNextRemarkByDoctorID($doctorID){
        $currentMonth = date('Y-m');

        $remark = DB::table('Remark')
            ->where('doctorID', $doctorID)
            ->where('date', 'like', $currentMonth.'%')
            ->first();
        
        return $remark;
    }
    
    // 修改備註
    public function modifyRemark($serial, $newRemark) {
        DB::table('Remark')
            ->where('remarkSerial', $seriaL)
            ->update([
                'remark' => $newRemark
            ]);

    }
    // 透過醫生id修改備註
    public function modifyRemarkByDoctorID($doctorID, $newRemark) {
        $currentMonth = date('Y-m');

        if($this->haveRemark($doctorID)>0){
            DB::table('Remark')
                ->where('doctorID', $doctorID)
                ->where('date', 'like', $currentMonth.'%')
                ->update([
                    'remark' => $newRemark
                ]);
        }
        else{
           $this->addRemark($doctorID,$newRemark);
        }

    }

    //判斷醫生有沒有備註
    public function haveRemark($doctorID){
        $currentMonth = date('Y-m');

        $amountRemark=DB::table('Remark')
            ->where('doctorID', $doctorID)
            ->where('date', 'like', $currentMonth.'%')
            ->count();

        return $amountRemark;
    }


}
