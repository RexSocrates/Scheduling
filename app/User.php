<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use DB;

class User extends Authenticatable
{
    use Notifiable;
    
    protected $table = "Doctor";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    // 取得所有醫生列表(須進行身份確認)
    public function getDoctorList() {
        $doctors = DB::table('Doctor')
            orderBy('doctorID')
            ->get();
        
        return $doctors;
    }
    
    // 透過醫生ID取得單一醫生資訊
    public function getDoctorInforByID($id) {
        $doctor = DB::table('Doctor')->where('doctorID', $id)-first();
        
        return $doctor;
    }
    
    //更新醫生資訊
}
