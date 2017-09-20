<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Mail;
use App\Mail\ShiftExchangingInform;

use App\User;
use App\Schedule;

class SendShiftExchangingInformMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    // 雙方同意換班後通知排班人員進行確認，applicantShift與receiverShift 為尚未換班時的資料
    protected $admin;
    protected $applicant;
    protected $receiver;
    protected $applicantShift;
    protected $receiverShift;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($applicantID, $receiverID, $applicantShiftID, $receiverShiftID)
    {
        //
        $userObj = new User();
        $schObj = new Schedule();
        
        $this->admin = $userObj->getAdminList()[0];
        $this->applicant = $userObj->getDoctorInfoByID($applicantID);
        $this->receiver = $userObj->getDoctorInfoByID($receiverID)
        $this->applicantShift = $schObj->getScheduleDataByID($applicantShiftID);
        $this->receiverShift = $schObj->getScheduleDataByID($receiverShiftID);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        Mail::to($this->admin->email)
            ->send(new ShiftExchangingInform($this->admin, $this->applicant, $this->receiver, 
                                             $this->applicantShift, $this->receiverShift));
    }
}
