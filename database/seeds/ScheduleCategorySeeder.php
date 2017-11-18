<?php

use Illuminate\Database\Seeder;

class ScheduleCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        
        DB::table('ScheduleCategory')->insert([
            'schCategorySerial' => 1,
            'schCategoryName' => '行政',
//            'location' => '',
            'exclusiveMajor' => ''
        ]);
        
        DB::table('ScheduleCategory')->insert([
            'schCategorySerial' => 2,
            'schCategoryName' => '教學',
//            'location' => '',
            'exclusiveMajor' => ''
        ]);
        
        DB::table('ScheduleCategory')->insert([
            'schCategorySerial' => 3,
            'schCategoryName' => '北白急救',
//            'location' => 'Taipei',
            'exclusiveMajor' => 'Surgical'
        ]);
        
        DB::table('ScheduleCategory')->insert([
            'schCategorySerial' => 4,
            'schCategoryName' => '北白發燒',
//            'location' => 'Taipei',
            'exclusiveMajor' => 'Surgical'
        ]);
        
        DB::table('ScheduleCategory')->insert([
            'schCategorySerial' => 5,
            'schCategoryName' => '北白內1',
//            'location' => 'Taipei',
            'exclusiveMajor' => 'Surgical'
        ]);
        
        DB::table('ScheduleCategory')->insert([
            'schCategorySerial' => 6,
            'schCategoryName' => '北白內2',
//            'location' => 'Taipei',
            'exclusiveMajor' => 'Surgical'
        ]);
        
        DB::table('ScheduleCategory')->insert([
            'schCategorySerial' => 7,
            'schCategoryName' => '北白外1',
//            'location' => 'Taipei',
            'exclusiveMajor' => 'Medical'
        ]);
        
        DB::table('ScheduleCategory')->insert([
            'schCategorySerial' => 8,
            'schCategoryName' => '北白外2',
//            'location' => 'Taipei',
            'exclusiveMajor' => 'Medical'
        ]);
        
        DB::table('ScheduleCategory')->insert([
            'schCategorySerial' => 9,
            'schCategoryName' => '淡白內1',
//            'location' => 'Tamsui',
            'exclusiveMajor' => 'Surgical'
        ]);
        
        DB::table('ScheduleCategory')->insert([
            'schCategorySerial' => 10,
            'schCategoryName' => '淡白內2',
//            'location' => 'Tamsui',
            'exclusiveMajor' => 'Surgical'
        ]);
        
        DB::table('ScheduleCategory')->insert([
            'schCategorySerial' => 11,
            'schCategoryName' => '淡白外1',
//            'location' => 'Tamsui',
            'exclusiveMajor' => 'Medical'
        ]);
        
        DB::table('ScheduleCategory')->insert([
            'schCategorySerial' =>12,
            'schCategoryName' => '淡白外1',
//            'location' => 'Tamsui',
            'exclusiveMajor' => 'Medical'
        ]);
        
        DB::table('ScheduleCategory')->insert([
            'schCategorySerial' => 13,
            'schCategoryName' => '北夜急救',
//            'location' => 'Taipei',
            'exclusiveMajor' => 'Surgical'
        ]);
        
        DB::table('ScheduleCategory')->insert([
            'schCategorySerial' => 14,
            'schCategoryName' => '北夜發燒',
//            'location' => 'Taipei',
            'exclusiveMajor' => 'Surgical'
        ]);
        
        DB::table('ScheduleCategory')->insert([
            'schCategorySerial' => 15,
            'schCategoryName' => '北夜內1',
//            'location' => 'Taipei',
            'exclusiveMajor' => 'Surgical'
        ]);
        
        DB::table('ScheduleCategory')->insert([
            'schCategorySerial' => 16,
            'schCategoryName' => '北夜內2',
//            'location' => 'Taipei',
            'exclusiveMajor' => 'Surgical'
        ]);
        
        DB::table('ScheduleCategory')->insert([
            'schCategorySerial' => 17,
            'schCategoryName' => '北夜外1',
//            'location' => 'Taipei',
            'exclusiveMajor' => 'Medical'
        ]);
        
        DB::table('ScheduleCategory')->insert([
            'schCategorySerial' => 18,
            'schCategoryName' => '北夜外2',
//            'location' => 'Taipei',
            'exclusiveMajor' => 'Medical'
        ]);
        
        DB::table('ScheduleCategory')->insert([
            'schCategorySerial' => 19,
            'schCategoryName' => '淡夜內1',
//            'location' => 'Tamsui',
            'exclusiveMajor' => 'Surgical'
        ]);
        
        DB::table('ScheduleCategory')->insert([
            'schCategorySerial' => 20,
            'schCategoryName' => '淡夜內2',
//            'location' => 'Tamsui',
            'exclusiveMajor' => 'Surgical'
        ]);
        
        DB::table('ScheduleCategory')->insert([
            'schCategorySerial' => 21,
            'schCategoryName' => '淡夜外',
//            'location' => 'Tamsui',
            'exclusiveMajor' => 'Medical'
        ]);
        
    }
}
