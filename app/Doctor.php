<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;

class Doctor extends Model
{
    //
    protected $table = 'Doctor';
    
    public function addDoctor($email, $name, $level, $location, $admin) {
        // 新增醫師時，預設的密碼將會是該醫師的生日
        $newID = DB::table('Doctor')->insertGetId([
            'email' => $email,
            'name' => $name,
            'level' => $level,
            'location' => location,
            'identity' => $admin
        ]);
        
        
        return $newID;
    }
}
