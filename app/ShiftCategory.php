<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;

class ShiftCategory extends Model
{
    protected $table = "ShiftCategory";

    // 回傳班別的名稱
    public function findName($serial){
    	$name = DB::table('ShiftCategory')->where("categorySerial",$serial)->first();
        
    	return $name->categoryName;
    }
}
