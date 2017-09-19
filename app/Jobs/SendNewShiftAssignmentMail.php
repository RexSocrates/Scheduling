<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

// import mail
use Mail;
use App\Mail\NewShiftAssignment;

// import model
use App\User;
use App\Schedule;

class SendNewShiftAssignmentMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    // 寄送排班人員新增醫師上班的通知信件
    protected $doctor;
    protected $schedule;
    protected $admin;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($doctorID, $scheduleID)
    {
        //
        $userObj = new User();
        $this->doctor = $userObj->getDoctorInfoByID($doctorID);
        
        $schObj = new Schedule();
        $this->schedule = $schObj->getScheduleDataByID($scheduleID);
        
        $this->admin = $userObj->getAdminList()[0];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        Mail::to($this->doctor->email)
            ->send(new NewShiftAssignment($this->doctor, $this->schdule, $this->admin));
    }
}
