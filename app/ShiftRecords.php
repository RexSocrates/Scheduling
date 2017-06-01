<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class ShiftRecords extends Model
{
    protected $table = "ShiftRecords";

    public function shiftRecordsList(){
        $shiftRecords = DB::table("ShiftRecords")->get();

         return $shiftRecords;

    }
}
