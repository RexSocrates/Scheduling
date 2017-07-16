<?php

use Illuminate\Database\Seeder;

class DateTest extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // DB::table('Reservation')-> insertGetId([
        //         'periodSerial' => 22,
        //         'isWeekday' => 0,
        //         'location' => "淡水",
        //         'isOn' => 1,
        //         'categorySerial' => 2, 
        //         'date' => '2017-06-06',
        //         'endDate' => '2017-06-07'
        // ]);
        // DB::table('Reservation')-> insertGetId([
        //         'periodSerial' => 23,
        //         'isWeekday' => 0,
        //         'location' => "淡水",
        //         'isOn' => 1,
        //         'categorySerial' => 4,
        //         'date' => '2017-06-09',
        //         'endDate' => '2017-06-10'
        // ]);
        // DB::table('Reservation')-> insertGetId([
        //         'periodSerial' => 24,
        //         'isWeekday' => 0,
        //         'location' => "淡水",
        //         'isOn' => 1,
        //         'categorySerial' => 5,
        //         'date' => '2017-06-15',
        //         'endDate' => '2017-06-16'
       
        // ]);
        // DB::table('Doctor')-> insert([
        //         'doctorID' => 1,
        //         'email' => "abc@gmail.com",
        //         'password' => "1233",
        //         'name' => "張國頌"
                 
        //  ]);
    //      DB::table('Reservation')-> insertGetId([
    //             'periodSerial' => 22,
    //             'isWeekday' => 0,
    //             'location' => "淡水",
    //             'isOn' => 1,
    //             'categorySerial' => 2, 
    //             'date' => '2017-06-26',
    //             'endDate' => '2017-06-27'
         
    // ]);
    // DB::table('DoctorAndReservation')-> insert([
    //             'resSerial' => 29,
    //             'doctorID' => 2
    //         ]);
         
    // }
         DB::table('Reservation')-> insertGetId([
                'periodSerial' => 22,
                'isWeekday' => 0,
                'location' => "淡水",
                'isOn' => 1,
                'categorySerial' => 2, 
                'date' => '2017-06-18',
                'endDate' => '2017-06-19'
         ]);
          DB::table('DoctorAndReservation')-> insert([
                'resSerial' => 41,
                'doctorID' => 3
         ]);
     
    DB::table('Reservation')-> insertGetId([
                'periodSerial' => 22,
                'isWeekday' => 0,
                'location' => "淡水",
                'isOn' => 1,
                'categorySerial' => 4, 
                'date' => '2017-06-15',
                'endDate' => '2017-06-16'
         ]);
          DB::table('DoctorAndReservation')-> insert([
                'resSerial' => 42,
                'doctorID' => 3
         ]);
     
     DB::table('Reservation')-> insertGetId([
                'periodSerial' => 22,
                'isWeekday' => 0,
                'location' => "淡水",
                'isOn' => 1,
                'categorySerial' => 6, 
                'date' => '2017-06-20',
                'endDate' => '2017-06-21'
         ]);
          DB::table('DoctorAndReservation')-> insert([
                'resSerial' => 43,
                'doctorID' => 3
         ]);
    }   
    
   

}
