<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;

class ShiftCategory extends Model
{
    protected $table = "CreateShiftCategory";

    public function findName($serial){
    	$name = DB::table('CreateShiftCategory')->where("categorySerial",$serial)->first();

    	return $name; 


    }
}
