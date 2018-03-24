<?php

use Illuminate\Database\Seeder;

class DoctorAndResSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        
        $record = [];
        for($i = 1; $i <= 100; $i++) {
            $resSerial = 0;
            $doctorID = 0;
            $haveBeenGenerated = false;
            do {
                $resSerial = rand(64, 154);
                $doctorID = rand(2, 50);
                
                for($j = 0; $j < count($record); $j++) {
                    if($record[$j][0] == $resSerial and $record[$j][1] == $doctorID) {
                        $haveBeenGenerated = true;
                    }
                }
            }while($haveBeenGenerated);
            
            DB::table('DoctorAndReservation')->insert([
                'resSerial' => $resSerial,
                'doctorID' => $doctorID
            ]);
            
            array_push($record, [$resSerial, $doctorID]);
        }
        
        
    }
}
