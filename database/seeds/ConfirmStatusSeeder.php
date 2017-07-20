<?php

use Illuminate\Database\Seeder;

class ConfirmStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        
        DB::table('ConfirmStatus')->insert([
            'confirmSerial' => 0,
            'status' => '未確認'
        ]);
        
        DB::table('ConfirmStatus')->insert([
            'confirmSerial' => 1,
            'status' => '已確認'
        ]);
        
        DB::table('ConfirmStatus')->insert([
            'confirmSerial' => 2,
            'status' => '已拒絕'
        ]);
    }
}
