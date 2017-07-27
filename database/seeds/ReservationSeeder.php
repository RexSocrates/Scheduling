<?php

use Illuminate\Database\Seeder;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('Reservation')->insert([
            'resSerial' => 1,
            'periodSerial' => 1,
            'isWeekday' => true,
            'location' => 'Taipei',
            'isOn' => true,
            'date' => '2017-07-25',
            'endDate' => '2017-07-26',
            'remark' => 'Nothing',
            'categorySerial' => 2
        ]);
        
        DB::table('DoctorAndReservation')->insert([
            'resSerial' => 1,
            'doctorID' => 1
        ]);
    }
}
