<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use\DB;

class ConfirmStatus extends Model
{
    public function getStatusBySerial($serial){
    	$status=DB::table('ConfirmStatus')
    			->where('confirmSerial', $serial)
    			->first();

    	return $status->status;

    }
}
