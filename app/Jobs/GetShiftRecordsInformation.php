<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Schedule;
Use App\User;
use App\ShiftCategory;

class GetShiftRecordsInformation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $single;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($single)
    {

        //
        $this->single = $single;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $schedule = new Schedule();
        $user = new User();
        $shiftCategory = new ShiftCategory();

        $shiftRecordsData;
        if($this->single) {
            // 只搜尋個人
            $shiftRecordsData = $shiftRecords->getShiftRecordsByDoctorID(); 
        }else {
            $shiftRecordsData = $shiftRecords->shiftRecordsList();
        }

        $dataInschedule = array();

    
        foreach ($shiftRecordsData as $record) {
            $doctor1 = $user->getDoctorInfoByID($record->schID_1_doctor);
            $doctor2 = $user->getDoctorInfoByID($record->schID_2_doctor);

            $schedule1 = $schedule->getScheduleDataByID($record->scheduleID_1);
            $schedule2 = $schedule->getScheduleDataByID($record->scheduleID_2);
            
            $catName1 = $shiftCategory->findName($schedule1->categorySerial);
            $catName2 = $shiftCategory->findName($schedule2->categorySerial);

            $record->schID_1_doctor = $doctor1->name;
            $record->schID_2_doctor = $doctor2->name;
            // $record->categorySerial = $categoryName->categoryName;

            array_push($dataInschedule, array($doctor1->name, $doctor2->name, $schedule1->date, $schedule2->date, $catName1, $catName2));
        }
        return $dataInschedule;
    }
}
