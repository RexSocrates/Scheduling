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
        if($this->haveRemark($doctorID)>0){
            DB::table('Remark')
                ->where('doctorID', $doctorID)
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
        $amountRemark=DB::table('Remark')
            ->where('doctorID', $doctorID)
            ->count();

        return $amountRemark;
    }
}
