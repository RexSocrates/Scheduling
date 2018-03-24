<?php

use Illuminate\Database\Seeder;

class ShiftCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * 
     */
    public function run()
    {
        //
        
        DB::table('ShiftCategory')->insert([
            'categorySerial' => 1,
            'categoryName' => '行政'
        ]);
        
        DB::table('ShiftCategory')->insert([
            'categorySerial' => 2,
            'categoryName' => '教學'
        ]);
        
        DB::table('ShiftCategory')->insert([
            'categorySerial' => 3,
            'categoryName' => '台北白班'
        ]);
        
        DB::table('ShiftCategory')->insert([
            'categorySerial' => 4,
            'categoryName' => '台北夜班'
        ]);
        
        DB::table('ShiftCategory')->insert([
            'categorySerial' => 5,
            'categoryName' => '淡水白班'
        ]);
        
        DB::table('ShiftCategory')->insert([
            'categorySerial' => 6,
            'categoryName' => '淡水夜班'
        ]);
        
        DB::table('ShiftCategory')->insert([
            'categorySerial' => 7,
            'categoryName' => 'off班'
        ]);
    }
}
