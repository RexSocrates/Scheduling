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
        $remark = DB::table('Remarks')
            ->where('remarkSerial', $serial)
            ->first();
        
        return $remark;
    }
    
    
    // 新增備註
    public function addRemark($doctorID,$remark){
    	$addRemark = DB::table("Remark")-> insertGetId([
                'doctorID' => $doctorID,
    			'remark' => $remark
                    
    		]);

    	return $addRemark;
    }
}
