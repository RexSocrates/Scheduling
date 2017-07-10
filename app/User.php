<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use DB;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;
    
    protected $table = "Doctor";
    protected $primaryKey = 'doctorID';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password', 'name', 'level', 'major', 'location', 'identity'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    // 回傳目前登入之使用者ID
    public function getCurrentUserID() {
        return Auth::id();
    }
    
    // 取得排班人員列表
    public function getAdminList() {
        $list = DB::table('Doctor')
            ->where('identity', 'Admin')
            ->get();
        
        return $list;
    }
    
    // 取得所有醫生列表(manager only)
    public function getDoctorList() {
        $doctors = DB::table('Doctor')
            ->orderBy('doctorID')
            ->get();
        
        return $doctors;
    }
    
    // 取得目前在職的醫生列表
    public function getAtWorkDoctors() {
        $doctors = DB::table('Doctor')
            ->where('resigned', false)
            ->get();
        
        return $doctors;
    }
    
    // 透過醫生ID取得單一醫生資訊
    public function getDoctorInfoByID($id) {
        $doctor = DB::table('Doctor')
            ->where('doctorID', $id)
            ->first();
        
        return $doctor;
    }
    
    // 一般醫師更新個人資訊
    public function updatePersonalInfo($id, $data) {
        $rows = DB::table('Doctor')
            ->where('doctorID', $id)
            ->update([
                'email' => $data['email'],
                'name' => $data['name'],
            ]);
    }
    
    // 更新指定ID的使用者資訊
    public function updateUserWithSpecificID($id, $data) {
        $rows = DB::table('Doctor')
            ->where('doctorID', $id)
            ->update([
                'email' => $data['email'],
                'name' => $data['name'],
                'level' => $data['level'],
                'major' => $data['major'],
                'location' => $data['location'],
                'identity' => $data['identity'],
            ]);
        
        return $rows;
    }
    
    
    
    // 系統管理人員更新醫師排班資訊
    public function updateShifts($id, $data) {
        $rows = DB::table('Doctor')
            ->where('doctorID', $id)
            ->update([
                'mustOnDutyTotalShifts' => $data['mustOnDutyTotalShifts'],
                'mustOnDutyMedicalShifts' => $data['mustOnDutyMedicalShifts'],
                'mustOnDutySurgicalShifts' => $data['mustOnDutySurgicalShifts'],
                'mustOnDutyTaipeiShifts' => $data['mustOnDutyTaipeiShifts'],
                'mustOnDutyTamsuiShifts' => $data['mustOnDutyTamsuiShifts']
            ]);
        
        return $rows;
    }
    
    // 醫生離職
    public function resign($id) {
        $rows = DB::table('Doctor')
            ->where('doctorID', $id)
            ->update([
                'resigned' => true
            ]);
        
        return $rows;
    }
    
    // 測試項目
    private function testing1($id, $columnName, $newValue) {
        $rows = DB::table('Doctor')
            ->where('doctorID', $id)
            ->update([
                $columnName => $newValue
            ]);
        
        return $rows;
    }
}
