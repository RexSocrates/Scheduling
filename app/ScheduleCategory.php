<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;

class ScheduleCategory extends Model
{
    //<?php
    protected $table = "ScheduleCategory";

    public function findScheduleName($serial){
    	$name = DB::table('ScheduleCategory')->where("schCategorySerial",$serial)->first();

    	return $name->schCategoryName;
    
	}

}
