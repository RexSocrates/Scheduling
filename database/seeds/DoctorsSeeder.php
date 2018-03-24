<?php

use Illuminate\Database\Seeder;

class DoctorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('Doctor')->insertGetId([
            'doctorID' => 2,
            'email' => 'fake2@gmail.com',
            'password' => 'password',
            'name' => '張國頌',
            'level' => 'S1',
            'major' => 'Surgical',
            'location' => '台北',
            'identity' => 'General',
            'mustOnDutyTotalShifts' => 10,
            'mustOnDutyMedicalShifts' => 0,
            'mustOnDutySurgicalShifts' => 10,
            'mustOnDutyTaipeiShifts' => 4,
            'mustOnDutyTamsuiShifts' => 6,
            'mustOnDutyDayShifts' => 10,
            'mustOnDutyNightShifts' => 0,
            'currentOfficialLeaveHours' => 0,
            'currentShiftHours' => 0,
            'resigned' => 0
        ]);
        
        DB::table('Doctor')->insertGetId([
            'doctorID' => 3,
            'email' => 'fake3@gmail.com',
            'password' => 'password',
            'name' => '沈靜宜',
            'level' => 'S1',
            'major' => 'All',
            'location' => '台北',
            'identity' => 'General',
            'mustOnDutyTotalShifts' => 15,
            'mustOnDutyMedicalShifts' => 11,
            'mustOnDutySurgicalShifts' => 4,
            'mustOnDutyTaipeiShifts' => 9,
            'mustOnDutyTamsuiShifts' => 6,
            'mustOnDutyDayShifts' => 0,
            'mustOnDutyNightShifts' => 15,
            'currentOfficialLeaveHours' => 0,
            'currentShiftHours' => 0,
            'resigned' => 0
        ]);
        
        DB::table('Doctor')->insertGetId([
            'doctorID' => 4,
            'email' => 'fake4@gmail.com',
            'password' => 'password',
            'name' => '張國頌',
            'level' => 'S1',
            'major' => 'All',
            'location' => '台北',
            'identity' => 'General',
            'mustOnDutyTotalShifts' => 15,
            'mustOnDutyMedicalShifts' => 0,
            'mustOnDutySurgicalShifts' => 10,
            'mustOnDutyTaipeiShifts' => 4,
            'mustOnDutyTamsuiShifts' => 9,
            'mustOnDutyDayShifts' => 10,
            'mustOnDutyNightShifts' => 0,
            'currentOfficialLeaveHours' => 0,
            'currentShiftHours' => 0,
            'resigned' => 0
        ]);
        
        DB::table('Doctor')->insertGetId([
            'doctorID' => 5,
            'email' => 'fake5@gmail.com',
            'password' => 'password',
            'name' => '簡定國',
            'level' => 'S1',
            'major' => 'All',
            'location' => '淡水',
            'identity' => 'General',
            'mustOnDutyTotalShifts' => 10,
            'mustOnDutyMedicalShifts' => 3,
            'mustOnDutySurgicalShifts' => 7,
            'mustOnDutyTaipeiShifts' => 6,
            'mustOnDutyTamsuiShifts' => 4,
            'mustOnDutyDayShifts' => 10,
            'mustOnDutyNightShifts' => 0,
            'currentOfficialLeaveHours' => 0,
            'currentShiftHours' => 0,
            'resigned' => 0
        ]);
        
        DB::table('Doctor')->insertGetId([
            'doctorID' => 6,
            'email' => 'fake6@gmail.com',
            'password' => 'password',
            'name' => '解晉一',
            'level' => 'S1',
            'major' => 'Medical',
            'location' => '台北',
            'identity' => 'General',
            'mustOnDutyTotalShifts' => 15,
            'mustOnDutyMedicalShifts' => 15,
            'mustOnDutySurgicalShifts' => 0,
            'mustOnDutyTaipeiShifts' => 9,
            'mustOnDutyTamsuiShifts' => 6,
            'mustOnDutyDayShifts' => 15,
            'mustOnDutyNightShifts' => 0,
            'currentOfficialLeaveHours' => 0,
            'currentShiftHours' => 0,
            'resigned' => 0
        ]);
        
        DB::table('Doctor')->insertGetId([
            'doctorID' => 7,
            'email' => 'fake7@gmail.com',
            'password' => 'password',
            'name' => '黃書田',
            'level' => 'S1',
            'major' => 'All',
            'location' => '台北',
            'identity' => 'General',
            'mustOnDutyTotalShifts' => 15,
            'mustOnDutyMedicalShifts' => 4,
            'mustOnDutySurgicalShifts' => 11,
            'mustOnDutyTaipeiShifts' => 9,
            'mustOnDutyTamsuiShifts' => 6,
            'mustOnDutyDayShifts' => 8,
            'mustOnDutyNightShifts' => 7,
            'currentOfficialLeaveHours' => 0,
            'currentShiftHours' => 0,
            'resigned' => 0
        ]);
        
        DB::table('Doctor')->insertGetId([
            'doctorID' => 8,
            'email' => 'fake8@gmail.com',
            'password' => 'password',
            'name' => '莊錦康',
            'level' => 'S1',
            'major' => 'Medical',
            'location' => '台北',
            'identity' => 'General',
            'mustOnDutyTotalShifts' => 15,
            'mustOnDutyMedicalShifts' => 15,
            'mustOnDutySurgicalShifts' => 0,
            'mustOnDutyTaipeiShifts' => 9,
            'mustOnDutyTamsuiShifts' => 6,
            'mustOnDutyDayShifts' => 13,
            'mustOnDutyNightShifts' => 2,
            'currentOfficialLeaveHours' => 0,
            'currentShiftHours' => 0,
            'resigned' => 0
        ]);
        
        DB::table('Doctor')->insertGetId([
            'doctorID' => 9,
            'email' => 'fake9@gmail.com',
            'password' => 'password',
            'name' => '邱毓惠',
            'level' => 'S1',
            'major' => 'Medical',
            'location' => '台北',
            'identity' => 'General',
            'mustOnDutyTotalShifts' => 15,
            'mustOnDutyMedicalShifts' => 11,
            'mustOnDutySurgicalShifts' => 4,
            'mustOnDutyTaipeiShifts' => 9,
            'mustOnDutyTamsuiShifts' => 6,
            'mustOnDutyDayShifts' => 13,
            'mustOnDutyNightShifts' => 2,
            'currentOfficialLeaveHours' => 0,
            'currentShiftHours' => 0,
            'resigned' => 0
        ]);
        
        
        DB::table('Doctor')->insertGetId([
            'doctorID' => 10,
            'email' => 'fake10@gmail.com',
            'password' => 'password',
            'name' => '林峰',
            'level' => 'S1',
            'major' => 'Medical',
            'location' => '台北',
            'identity' => 'General',
            'mustOnDutyTotalShifts' => 15,
            'mustOnDutyMedicalShifts' => 15,
            'mustOnDutySurgicalShifts' => 0,
            'mustOnDutyTaipeiShifts' => 9,
            'mustOnDutyTamsuiShifts' => 6,
            'mustOnDutyDayShifts' => 13,
            'mustOnDutyNightShifts' => 2,
            'currentOfficialLeaveHours' => 0,
            'currentShiftHours' => 0,
            'resigned' => 0
        ]);
        
        DB::table('Doctor')->insertGetId([
            'doctorID' => 11,
            'email' => 'fake11@gmail.com',
            'password' => 'password',
            'name' => '簡立仁',
            'level' => 'S1',
            'major' => 'All',
            'location' => '淡水',
            'identity' => 'General',
            'mustOnDutyTotalShifts' => 15,
            'mustOnDutyMedicalShifts' => 11,
            'mustOnDutySurgicalShifts' => 4,
            'mustOnDutyTaipeiShifts' => 6,
            'mustOnDutyTamsuiShifts' => 9,
            'mustOnDutyDayShifts' => 8,
            'mustOnDutyNightShifts' => 7,
            'currentOfficialLeaveHours' => 0,
            'currentShiftHours' => 0,
            'resigned' => 0
        ]);
        
        DB::table('Doctor')->insertGetId([
            'doctorID' => 12,
            'email' => 'fake12@gmail.com',
            'password' => 'password',
            'name' => '劉恩睿',
            'level' => 'S1',
            'major' => 'All',
            'location' => '淡水',
            'identity' => 'General',
            'mustOnDutyTotalShifts' => 15,
            'mustOnDutyMedicalShifts' => 11,
            'mustOnDutySurgicalShifts' => 4,
            'mustOnDutyTaipeiShifts' => 6,
            'mustOnDutyTamsuiShifts' => 9,
            'mustOnDutyDayShifts' => 7,
            'mustOnDutyNightShifts' => 8,
            'currentOfficialLeaveHours' => 0,
            'currentShiftHours' => 0,
            'resigned' => 0
        ]);
        
        DB::table('Doctor')->insertGetId([
            'doctorID' => 13,
            'email' => 'fake13@gmail.com',
            'password' => 'password',
            'name' => '陳長志',
            'level' => 'S1',
            'major' => 'Surgical',
            'location' => '台北',
            'identity' => 'General',
            'mustOnDutyTotalShifts' => 10,
            'mustOnDutyMedicalShifts' => 0,
            'mustOnDutySurgicalShifts' => 10,
            'mustOnDutyTaipeiShifts' => 4,
            'mustOnDutyTamsuiShifts' => 6,
            'mustOnDutyDayShifts' => 10,
            'mustOnDutyNightShifts' => 0,
            'currentOfficialLeaveHours' => 0,
            'currentShiftHours' => 0,
            'resigned' => 0
        ]);
        
        DB::table('Doctor')->insertGetId([
            'doctorID' => 14,
            'email' => 'fake14@gmail.com',
            'password' => 'password',
            'name' => '馮嚴毅',
            'level' => 'S1',
            'major' => 'All',
            'location' => '台北',
            'identity' => 'General',
            'mustOnDutyTotalShifts' => 15,
            'mustOnDutyMedicalShifts' => 11,
            'mustOnDutySurgicalShifts' => 4,
            'mustOnDutyTaipeiShifts' => 9,
            'mustOnDutyTamsuiShifts' => 6,
            'mustOnDutyDayShifts' => 8,
            'mustOnDutyNightShifts' => 7,
            'currentOfficialLeaveHours' => 0,
            'currentShiftHours' => 0,
            'resigned' => 0
        ]);
        
        DB::table('Doctor')->insertGetId([
            'doctorID' => 15,
            'email' => 'fake15@gmail.com',
            'password' => 'password',
            'name' => '鄭耀銘',
            'level' => 'S1',
            'major' => 'Surgical',
            'location' => '淡水',
            'identity' => 'General',
            'mustOnDutyTotalShifts' => 14,
            'mustOnDutyMedicalShifts' => 0,
            'mustOnDutySurgicalShifts' => 14,
            'mustOnDutyTaipeiShifts' => 6,
            'mustOnDutyTamsuiShifts' => 9,
            'mustOnDutyDayShifts' => 7,
            'mustOnDutyNightShifts' => 7,
            'currentOfficialLeaveHours' => 0,
            'currentShiftHours' => 0,
            'resigned' => 0
        ]);
        
        DB::table('Doctor')->insertGetId([
            'doctorID' => 16,
            'email' => 'fake16@gmail.com',
            'password' => 'password',
            'name' => '陳楷宏',
            'level' => 'S1',
            'major' => 'All',
            'location' => '淡水',
            'identity' => 'General',
            'mustOnDutyTotalShifts' => 15,
            'mustOnDutyMedicalShifts' => 11,
            'mustOnDutySurgicalShifts' => 4,
            'mustOnDutyTaipeiShifts' => 6,
            'mustOnDutyTamsuiShifts' => 9,
            'mustOnDutyDayShifts' => 0,
            'mustOnDutyNightShifts' => 15,
            'currentOfficialLeaveHours' => 0,
            'currentShiftHours' => 0,
            'resigned' => 0
        ]);
        
        DB::table('Doctor')->insertGetId([
            'doctorID' => 17,
            'email' => 'fake17@gmail.com',
            'password' => 'password',
            'name' => '張文瀚',
            'level' => 'S1',
            'major' => 'Surgical',
            'location' => '台北',
            'identity' => 'General',
            'mustOnDutyTotalShifts' => 4,
            'mustOnDutyMedicalShifts' => 0,
            'mustOnDutySurgicalShifts' => 4,
            'mustOnDutyTaipeiShifts' => 0,
            'mustOnDutyTamsuiShifts' => 4,
            'mustOnDutyDayShifts' => 4,
            'mustOnDutyNightShifts' => 0,
            'currentOfficialLeaveHours' => 0,
            'currentShiftHours' => 0,
            'resigned' => 0
        ]);
        
        DB::table('Doctor')->insertGetId([
            'doctorID' => 18,
            'email' => 'fake18@gmail.com',
            'password' => 'password',
            'name' => '鄧立明',
            'level' => 'S1',
            'major' => 'Surgical',
            'location' => '台北',
            'identity' => 'General',
            'mustOnDutyTotalShifts' => 15,
            'mustOnDutyMedicalShifts' => 0,
            'mustOnDutySurgicalShifts' => 15,
            'mustOnDutyTaipeiShifts' => 9,
            'mustOnDutyTamsuiShifts' => 6,
            'mustOnDutyDayShifts' => 9,
            'mustOnDutyNightShifts' => 6,
            'currentOfficialLeaveHours' => 0,
            'currentShiftHours' => 0,
            'resigned' => 0
        ]);
        
        DB::table('Doctor')->insertGetId([
            'doctorID' => 19,
            'email' => 'fake19@gmail.com',
            'password' => 'password',
            'name' => '劉良嶸',
            'level' => 'S1',
            'major' => 'All',
            'location' => '台北',
            'identity' => 'General',
            'mustOnDutyTotalShifts' => 15,
            'mustOnDutyMedicalShifts' => 11,
            'mustOnDutySurgicalShifts' => 4,
            'mustOnDutyTaipeiShifts' => 9,
            'mustOnDutyTamsuiShifts' => 6,
            'mustOnDutyDayShifts' => 8,
            'mustOnDutyNightShifts' => 7,
            'currentOfficialLeaveHours' => 0,
            'currentShiftHours' => 0,
            'resigned' => 0
        ]);
        
        DB::table('Doctor')->insertGetId([
            'doctorID' => 20,
            'email' => 'fake20@gmail.com',
            'password' => 'password',
            'name' => '謝尚霖',
            'level' => 'S1',
            'major' => 'All',
            'location' => '台北',
            'identity' => 'General',
            'mustOnDutyTotalShifts' => 14,
            'mustOnDutyMedicalShifts' => 10,
            'mustOnDutySurgicalShifts' => 4,
            'mustOnDutyTaipeiShifts' => 8,
            'mustOnDutyTamsuiShifts' => 6,
            'mustOnDutyDayShifts' => 7,
            'mustOnDutyNightShifts' => 7,
            'currentOfficialLeaveHours' => 0,
            'currentShiftHours' => 0,
            'resigned' => 0
        ]);
        
        DB::table('Doctor')->insertGetId([
            'doctorID' => 21,
            'email' => 'fake21@gmail.com',
            'password' => 'password',
            'name' => '柳志翰',
            'level' => 'S1',
            'major' => 'All',
            'location' => '淡水',
            'identity' => 'General',
            'mustOnDutyTotalShifts' => 15,
            'mustOnDutyMedicalShifts' => 11,
            'mustOnDutySurgicalShifts' => 4,
            'mustOnDutyTaipeiShifts' => 6,
            'mustOnDutyTamsuiShifts' => 9,
            'mustOnDutyDayShifts' => 7,
            'mustOnDutyNightShifts' => 8,
            'currentOfficialLeaveHours' => 0,
            'currentShiftHours' => 0,
            'resigned' => 0
        ]);
        
        DB::table('Doctor')->insertGetId([
            'doctorID' => 22,
            'email' => 'fake22@gmail.com',
            'password' => 'password',
            'name' => '王樹林',
            'level' => 'S1',
            'major' => 'Surgical',
            'location' => '台北',
            'identity' => 'General',
            'mustOnDutyTotalShifts' => 15,
            'mustOnDutyMedicalShifts' => 0,
            'mustOnDutySurgicalShifts' => 15,
            'mustOnDutyTaipeiShifts' => 9,
            'mustOnDutyTamsuiShifts' => 6,
            'mustOnDutyDayShifts' => 8,
            'mustOnDutyNightShifts' => 7,
            'currentOfficialLeaveHours' => 0,
            'currentShiftHours' => 0,
            'resigned' => 0
        ]);
        
        DB::table('Doctor')->insertGetId([
            'doctorID' => 23,
            'email' => 'fake23@gmail.com',
            'password' => 'password',
            'name' => '陳心堂',
            'level' => 'S1',
            'major' => 'All',
            'location' => '台北',
            'identity' => 'General',
            'mustOnDutyTotalShifts' => 15,
            'mustOnDutyMedicalShifts' => 11,
            'mustOnDutySurgicalShifts' => 4,
            'mustOnDutyTaipeiShifts' => 9,
            'mustOnDutyTamsuiShifts' => 6,
            'mustOnDutyDayShifts' => 8,
            'mustOnDutyNightShifts' => 7,
            'currentOfficialLeaveHours' => 0,
            'currentShiftHours' => 0,
            'resigned' => 0
        ]);
        
        DB::table('Doctor')->insertGetId([
            'doctorID' => 24,
            'email' => 'fake24@gmail.com',
            'password' => 'password',
            'name' => '龔律至',
            'level' => 'S1',
            'major' => 'All',
            'location' => '台北',
            'identity' => 'General',
            'mustOnDutyTotalShifts' => 8,
            'mustOnDutyMedicalShifts' => 6,
            'mustOnDutySurgicalShifts' => 2,
            'mustOnDutyTaipeiShifts' => 4,
            'mustOnDutyTamsuiShifts' => 4,
            'mustOnDutyDayShifts' => 3,
            'mustOnDutyNightShifts' => 5,
            'currentOfficialLeaveHours' => 0,
            'currentShiftHours' => 0,
            'resigned' => 0
        ]);
        
        DB::table('Doctor')->insertGetId([
            'doctorID' => 25,
            'email' => 'fake25@gmail.com',
            'password' => 'password',
            'name' => '蔡維德',
            'level' => 'S1',
            'major' => 'All',
            'location' => '台北',
            'identity' => 'Admin',
            'mustOnDutyTotalShifts' => 6,
            'mustOnDutyMedicalShifts' => 4,
            'mustOnDutySurgicalShifts' => 2,
            'mustOnDutyTaipeiShifts' => 0,
            'mustOnDutyTamsuiShifts' => 6,
            'mustOnDutyDayShifts' => 6,
            'mustOnDutyNightShifts' => 0,
            'currentOfficialLeaveHours' => 0,
            'currentShiftHours' => 0,
            'resigned' => 0
        ]);
        
        DB::table('Doctor')->insertGetId([
            'doctorID' => 26,
            'email' => 'fake26@gmail.com',
            'password' => 'password',
            'name' => '黃明源',
            'level' => 'S1',
            'major' => 'All',
            'location' => '台北',
            'identity' => 'General',
            'mustOnDutyTotalShifts' => 5,
            'mustOnDutyMedicalShifts' => 4,
            'mustOnDutySurgicalShifts' => 1,
            'mustOnDutyTaipeiShifts' => 3,
            'mustOnDutyTamsuiShifts' => 2,
            'mustOnDutyDayShifts' => 5,
            'mustOnDutyNightShifts' => 0,
            'currentOfficialLeaveHours' => 0,
            'currentShiftHours' => 0,
            'resigned' => 0
        ]);
        
        DB::table('Doctor')->insertGetId([
            'doctorID' => 27,
            'email' => 'fake27@gmail.com',
            'password' => 'password',
            'name' => '劉哲宏',
            'level' => 'S1',
            'major' => 'All',
            'location' => '淡水',
            'identity' => 'General',
            'mustOnDutyTotalShifts' => 15,
            'mustOnDutyMedicalShifts' => 11,
            'mustOnDutySurgicalShifts' => 4,
            'mustOnDutyTaipeiShifts' => 6,
            'mustOnDutyTamsuiShifts' => 9,
            'mustOnDutyDayShifts' => 8,
            'mustOnDutyNightShifts' => 7,
            'currentOfficialLeaveHours' => 0,
            'currentShiftHours' => 0,
            'resigned' => 0
        ]);
        
        DB::table('Doctor')->insertGetId([
            'doctorID' => 28,
            'email' => 'fake28@gmail.com',
            'password' => 'password',
            'name' => '林柏蓁',
            'level' => 'S1',
            'major' => 'All',
            'location' => '台北',
            'identity' => 'General',
            'mustOnDutyTotalShifts' => 15,
            'mustOnDutyMedicalShifts' => 11,
            'mustOnDutySurgicalShifts' => 4,
            'mustOnDutyTaipeiShifts' => 9,
            'mustOnDutyTamsuiShifts' => 6,
            'mustOnDutyDayShifts' => 8,
            'mustOnDutyNightShifts' => 7,
            'currentOfficialLeaveHours' => 0,
            'currentShiftHours' => 0,
            'resigned' => 0
        ]);
        
        DB::table('Doctor')->insertGetId([
            'doctorID' => 29,
            'email' => 'fake29@gmail.com',
            'password' => 'password',
            'name' => '蘇柏樺',
            'level' => 'S1',
            'major' => 'All',
            'location' => '淡水',
            'identity' => 'General',
            'mustOnDutyTotalShifts' => 15,
            'mustOnDutyMedicalShifts' => 11,
            'mustOnDutySurgicalShifts' => 4,
            'mustOnDutyTaipeiShifts' => 6,
            'mustOnDutyTamsuiShifts' => 9,
            'mustOnDutyDayShifts' => 8,
            'mustOnDutyNightShifts' => 7,
            'currentOfficialLeaveHours' => 0,
            'currentShiftHours' => 0,
            'resigned' => 0
        ]);
        
        DB::table('Doctor')->insertGetId([
            'doctorID' => 30,
            'email' => 'fake30@gmail.com',
            'password' => 'password',
            'name' => '華伯堅',
            'level' => 'S1',
            'major' => 'All',
            'location' => '台北',
            'identity' => 'General',
            'mustOnDutyTotalShifts' => 15,
            'mustOnDutyMedicalShifts' => 11,
            'mustOnDutySurgicalShifts' => 4,
            'mustOnDutyTaipeiShifts' => 9,
            'mustOnDutyTamsuiShifts' => 6,
            'mustOnDutyDayShifts' => 7,
            'mustOnDutyNightShifts' => 8,
            'currentOfficialLeaveHours' => 0,
            'currentShiftHours' => 0,
            'resigned' => 0
        ]);
        
        DB::table('Doctor')->insertGetId([
            'doctorID' => 31,
            'email' => 'fake31@gmail.com',
            'password' => 'password',
            'name' => '黃明堃',
            'level' => 'S1',
            'major' => 'All',
            'location' => '淡水',
            'identity' => 'General',
            'mustOnDutyTotalShifts' => 15,
            'mustOnDutyMedicalShifts' => 11,
            'mustOnDutySurgicalShifts' => 4,
            'mustOnDutyTaipeiShifts' => 6,
            'mustOnDutyTamsuiShifts' => 9,
            'mustOnDutyDayShifts' => 8,
            'mustOnDutyNightShifts' => 7,
            'currentOfficialLeaveHours' => 0,
            'currentShiftHours' => 0,
            'resigned' => 0
        ]);
        
        DB::table('Doctor')->insertGetId([
            'doctorID' => 32,
            'email' => 'fake32@gmail.com',
            'password' => 'password',
            'name' => '黃蘭綺',
            'level' => 'S1',
            'major' => 'Medical',
            'location' => '淡水',
            'identity' => 'General',
            'mustOnDutyTotalShifts' => 15,
            'mustOnDutyMedicalShifts' => 0,
            'mustOnDutySurgicalShifts' => 15,
            'mustOnDutyTaipeiShifts' => 6,
            'mustOnDutyTamsuiShifts' => 9,
            'mustOnDutyDayShifts' => 13,
            'mustOnDutyNightShifts' => 2,
            'currentOfficialLeaveHours' => 0,
            'currentShiftHours' => 0,
            'resigned' => 0
        ]);
        
        DB::table('Doctor')->insertGetId([
            'doctorID' => 33,
            'email' => 'fake33@gmail.com',
            'password' => 'password',
            'name' => '蔡宜勳',
            'level' => 'S1',
            'major' => 'All',
            'location' => '台北',
            'identity' => 'General',
            'mustOnDutyTotalShifts' => 15,
            'mustOnDutyMedicalShifts' => 11,
            'mustOnDutySurgicalShifts' => 4,
            'mustOnDutyTaipeiShifts' => 9,
            'mustOnDutyTamsuiShifts' => 6,
            'mustOnDutyDayShifts' => 0,
            'mustOnDutyNightShifts' => 15,
            'currentOfficialLeaveHours' => 0,
            'currentShiftHours' => 0,
            'resigned' => 0
        ]);
        
        DB::table('Doctor')->insertGetId([
            'doctorID' => 34,
            'email' => 'fake34@gmail.com',
            'password' => 'password',
            'name' => '黃章喜',
            'level' => 'S1',
            'major' => 'Medical',
            'location' => '台北',
            'identity' => 'General',
            'mustOnDutyTotalShifts' => 15,
            'mustOnDutyMedicalShifts' => 0,
            'mustOnDutySurgicalShifts' => 15,
            'mustOnDutyTaipeiShifts' => 9,
            'mustOnDutyTamsuiShifts' => 6,
            'mustOnDutyDayShifts' => 0,
            'mustOnDutyNightShifts' => 15,
            'currentOfficialLeaveHours' => 0,
            'currentShiftHours' => 0,
            'resigned' => 0
        ]);
        
        DB::table('Doctor')->insertGetId([
            'doctorID' => 35,
            'email' => 'fake35@gmail.com',
            'password' => 'password',
            'name' => '余宗儒',
            'level' => 'S1',
            'major' => 'All',
            'location' => '台北',
            'identity' => 'General',
            'mustOnDutyTotalShifts' => 15,
            'mustOnDutyMedicalShifts' => 11,
            'mustOnDutySurgicalShifts' => 4,
            'mustOnDutyTaipeiShifts' => 9,
            'mustOnDutyTamsuiShifts' => 6,
            'mustOnDutyDayShifts' => 7,
            'mustOnDutyNightShifts' => 8,
            'currentOfficialLeaveHours' => 0,
            'currentShiftHours' => 0,
            'resigned' => 0
        ]);
        
        DB::table('Doctor')->insertGetId([
            'doctorID' => 36,
            'email' => 'fake36@gmail.com',
            'password' => 'password',
            'name' => '鄭婓茵',
            'level' => 'S1',
            'major' => 'All',
            'location' => '台北',
            'identity' => 'General',
            'mustOnDutyTotalShifts' => 15,
            'mustOnDutyMedicalShifts' => 11,
            'mustOnDutySurgicalShifts' => 4,
            'mustOnDutyTaipeiShifts' => 9,
            'mustOnDutyTamsuiShifts' => 6,
            'mustOnDutyDayShifts' => 13,
            'mustOnDutyNightShifts' => 2,
            'currentOfficialLeaveHours' => 0,
            'currentShiftHours' => 0,
            'resigned' => 0
        ]);
        
        DB::table('Doctor')->insertGetId([
            'doctorID' => 37,
            'email' => 'fake37@gmail.com',
            'password' => 'password',
            'name' => '蘇昱彰',
            'level' => 'S1',
            'major' => 'All',
            'location' => '台北',
            'identity' => 'General',
            'mustOnDutyTotalShifts' => 15,
            'mustOnDutyMedicalShifts' => 11,
            'mustOnDutySurgicalShifts' => 4,
            'mustOnDutyTaipeiShifts' => 9,
            'mustOnDutyTamsuiShifts' => 6,
            'mustOnDutyDayShifts' => 9,
            'mustOnDutyNightShifts' => 6,
            'currentOfficialLeaveHours' => 0,
            'currentShiftHours' => 0,
            'resigned' => 0
        ]);
        
        DB::table('Doctor')->insertGetId([
            'doctorID' => 38,
            'email' => 'fake38@gmail.com',
            'password' => 'password',
            'name' => '陳邦彥',
            'level' => 'S1',
            'major' => 'All',
            'location' => '淡水',
            'identity' => 'General',
            'mustOnDutyTotalShifts' => 15,
            'mustOnDutyMedicalShifts' => 11,
            'mustOnDutySurgicalShifts' => 4,
            'mustOnDutyTaipeiShifts' => 6,
            'mustOnDutyTamsuiShifts' => 9,
            'mustOnDutyDayShifts' => 8,
            'mustOnDutyNightShifts' => 7,
            'currentOfficialLeaveHours' => 0,
            'currentShiftHours' => 0,
            'resigned' => 0
        ]);
        
        DB::table('Doctor')->insertGetId([
            'doctorID' => 39,
            'email' => 'fake39@gmail.com',
            'password' => 'password',
            'name' => '王志平',
            'level' => 'S1',
            'major' => 'All',
            'location' => '台北',
            'identity' => 'General',
            'mustOnDutyTotalShifts' => 15,
            'mustOnDutyMedicalShifts' => 11,
            'mustOnDutySurgicalShifts' => 4,
            'mustOnDutyTaipeiShifts' => 9,
            'mustOnDutyTamsuiShifts' => 6,
            'mustOnDutyDayShifts' => 8,
            'mustOnDutyNightShifts' => 6,
            'currentOfficialLeaveHours' => 0,
            'currentShiftHours' => 0,
            'resigned' => 0
        ]);
        
        DB::table('Doctor')->insertGetId([
            'doctorID' => 40,
            'email' => 'fake40@gmail.com',
            'password' => 'password',
            'name' => '郭建峰',
            'level' => 'S1',
            'major' => 'Medical',
            'location' => '台北',
            'identity' => 'General',
            'mustOnDutyTotalShifts' => 15,
            'mustOnDutyMedicalShifts' => 15,
            'mustOnDutySurgicalShifts' => 0,
            'mustOnDutyTaipeiShifts' => 9,
            'mustOnDutyTamsuiShifts' => 6,
            'mustOnDutyDayShifts' => 8,
            'mustOnDutyNightShifts' => 7,
            'currentOfficialLeaveHours' => 0,
            'currentShiftHours' => 0,
            'resigned' => 0
        ]);
        
        DB::table('Doctor')->insertGetId([
            'doctorID' => 41,
            'email' => 'fake41@gmail.com',
            'password' => 'password',
            'name' => '楊修武',
            'level' => 'S1',
            'major' => 'All',
            'location' => '台北',
            'identity' => 'General',
            'mustOnDutyTotalShifts' => 15,
            'mustOnDutyMedicalShifts' => 11,
            'mustOnDutySurgicalShifts' => 4,
            'mustOnDutyTaipeiShifts' => 9,
            'mustOnDutyTamsuiShifts' => 6,
            'mustOnDutyDayShifts' => 8,
            'mustOnDutyNightShifts' => 7,
            'currentOfficialLeaveHours' => 0,
            'currentShiftHours' => 0,
            'resigned' => 0
        ]);
        
        DB::table('Doctor')->insertGetId([
            'doctorID' => 42,
            'email' => 'fake42@gmail.com',
            'password' => 'password',
            'name' => '林吟憲',
            'level' => 'S1',
            'major' => 'All',
            'location' => '淡水',
            'identity' => 'General',
            'mustOnDutyTotalShifts' => 15,
            'mustOnDutyMedicalShifts' => 11,
            'mustOnDutySurgicalShifts' => 4,
            'mustOnDutyTaipeiShifts' => 6,
            'mustOnDutyTamsuiShifts' => 9,
            'mustOnDutyDayShifts' => 7,
            'mustOnDutyNightShifts' => 8,
            'currentOfficialLeaveHours' => 0,
            'currentShiftHours' => 0,
            'resigned' => 0
        ]);
        
        DB::table('Doctor')->insertGetId([
            'doctorID' => 43,
            'email' => 'fake43@gmail.com',
            'password' => 'password',
            'name' => '張澤霖',
            'level' => 'S1',
            'major' => 'Surgical',
            'location' => '淡水',
            'identity' => 'General',
            'mustOnDutyTotalShifts' => 15,
            'mustOnDutyMedicalShifts' => 15,
            'mustOnDutySurgicalShifts' => 0,
            'mustOnDutyTaipeiShifts' => 6,
            'mustOnDutyTamsuiShifts' => 9,
            'mustOnDutyDayShifts' => 8,
            'mustOnDutyNightShifts' => 7,
            'currentOfficialLeaveHours' => 0,
            'currentShiftHours' => 0,
            'resigned' => 0
        ]);
        
        DB::table('Doctor')->insertGetId([
            'doctorID' => 44,
            'email' => 'fake44@gmail.com',
            'password' => 'password',
            'name' => '王禎毅',
            'level' => 'S1',
            'major' => 'All',
            'location' => '淡水',
            'identity' => 'General',
            'mustOnDutyTotalShifts' => 15,
            'mustOnDutyMedicalShifts' => 11,
            'mustOnDutySurgicalShifts' => 4,
            'mustOnDutyTaipeiShifts' => 6,
            'mustOnDutyTamsuiShifts' => 9,
            'mustOnDutyDayShifts' => 7,
            'mustOnDutyNightShifts' => 8,
            'currentOfficialLeaveHours' => 0,
            'currentShiftHours' => 0,
            'resigned' => 0
        ]);
        
        DB::table('Doctor')->insertGetId([
            'doctorID' => 45,
            'email' => 'fake45@gmail.com',
            'password' => 'password',
            'name' => '邱玟姍',
            'level' => 'S1',
            'major' => 'All',
            'location' => '淡水',
            'identity' => 'General',
            'mustOnDutyTotalShifts' => 15,
            'mustOnDutyMedicalShifts' => 11,
            'mustOnDutySurgicalShifts' => 4,
            'mustOnDutyTaipeiShifts' => 6,
            'mustOnDutyTamsuiShifts' => 9,
            'mustOnDutyDayShifts' => 7,
            'mustOnDutyNightShifts' => 8,
            'currentOfficialLeaveHours' => 0,
            'currentShiftHours' => 0,
            'resigned' => 0
        ]);
        
        DB::table('Doctor')->insertGetId([
            'doctorID' => 46,
            'email' => 'fake46@gmail.com',
            'password' => 'password',
            'name' => '劉蕙慈',
            'level' => 'S1',
            'major' => 'All',
            'location' => '淡水',
            'identity' => 'General',
            'mustOnDutyTotalShifts' => 15,
            'mustOnDutyMedicalShifts' => 11,
            'mustOnDutySurgicalShifts' => 4,
            'mustOnDutyTaipeiShifts' => 6,
            'mustOnDutyTamsuiShifts' => 9,
            'mustOnDutyDayShifts' => 7,
            'mustOnDutyNightShifts' => 8,
            'currentOfficialLeaveHours' => 0,
            'currentShiftHours' => 0,
            'resigned' => 0
        ]);
        
        DB::table('Doctor')->insertGetId([
            'doctorID' => 47,
            'email' => 'fake47@gmail.com',
            'password' => 'password',
            'name' => '總醫師1',
            'level' => 'S1',
            'major' => 'All',
            'location' => '台北',
            'identity' => 'General',
            'mustOnDutyTotalShifts' => 11,
            'mustOnDutyMedicalShifts' => 8,
            'mustOnDutySurgicalShifts' => 3,
            'mustOnDutyTaipeiShifts' => 11,
            'mustOnDutyTamsuiShifts' => 0,
            'mustOnDutyDayShifts' => 11,
            'mustOnDutyNightShifts' => 0,
            'currentOfficialLeaveHours' => 0,
            'currentShiftHours' => 0,
            'resigned' => 0
        ]);
        
        DB::table('Doctor')->insertGetId([
            'doctorID' => 48,
            'email' => 'fake48@gmail.com',
            'password' => 'password',
            'name' => '總醫師2',
            'level' => 'S1',
            'major' => 'All',
            'location' => '台北',
            'identity' => 'General',
            'mustOnDutyTotalShifts' => 8,
            'mustOnDutyMedicalShifts' => 6,
            'mustOnDutySurgicalShifts' => 2,
            'mustOnDutyTaipeiShifts' => 8,
            'mustOnDutyTamsuiShifts' => 0,
            'mustOnDutyDayShifts' => 0,
            'mustOnDutyNightShifts' => 8,
            'currentOfficialLeaveHours' => 0,
            'currentShiftHours' => 0,
            'resigned' => 0
        ]);
        
        DB::table('Doctor')->insertGetId([
            'doctorID' => 49,
            'email' => 'fake49@gmail.com',
            'password' => 'password',
            'name' => '總醫師3',
            'level' => 'S1',
            'major' => 'All',
            'location' => '台北',
            'identity' => 'General',
            'mustOnDutyTotalShifts' => 8,
            'mustOnDutyMedicalShifts' => 6,
            'mustOnDutySurgicalShifts' => 2,
            'mustOnDutyTaipeiShifts' => 8,
            'mustOnDutyTamsuiShifts' => 0,
            'mustOnDutyDayShifts' => 0,
            'mustOnDutyNightShifts' => 8,
            'currentOfficialLeaveHours' => 0,
            'currentShiftHours' => 0,
            'resigned' => 0
        ]);
        
        DB::table('Doctor')->insertGetId([
            'doctorID' => 50,
            'email' => 'fake50@gmail.com',
            'password' => 'password',
            'name' => '李肇雄',
            'level' => 'S1',
            'major' => 'All',
            'location' => '淡水',
            'identity' => 'General',
            'mustOnDutyTotalShifts' => 15,
            'mustOnDutyMedicalShifts' => 11,
            'mustOnDutySurgicalShifts' => 4,
            'mustOnDutyTaipeiShifts' => 6,
            'mustOnDutyTamsuiShifts' => 9,
            'mustOnDutyDayShifts' => 8,
            'mustOnDutyNightShifts' => 7,
            'currentOfficialLeaveHours' => 0,
            'currentShiftHours' => 0,
            'resigned' => 0
        ]);
    }
}
