<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Remark extends Model
{
    //
    public function addRemark($doctorID,$remark){
    	$remark = DB::table("Remark")-> insertGetId([
                'doctorID' => $doctorID,
    			'remark' => $remark
                    
    		]);

    	return redirect("reservation");
    }
}
