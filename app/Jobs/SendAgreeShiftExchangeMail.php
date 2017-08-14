<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Mail;
use App\Mail\AgreeShiftExchange;

// import model
use App\User;
use App\Schedule;

class SendAgreeShiftExchangeMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    // 向提出換班的申請人通知對方已確認換班，applicant為提出換班的人，receiver為確認換班的人
    protected $applicant;
    protected $receiver;
    // applicantShift與receiverShift 為換班前的資料
    protected $applicantShift;
    protected $receiverShift;
    protected $admin;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($applicantID, $receiverID, $applicantShiftSerial, $receiverShiftSerial)
    {
        $userObj = new User();
        $scheduleObj = new Schedule();
        
        $this->applicant = $userObj->getDoctorInfoByID($applicantID);
        $this->receiver = $userObj->getDoctorInfoByID($receiverID);
        $this->applicantShift = $scheduleObj->getScheduleDataByID($applicantShiftSerial);
        $this->receiverShift = $scheduleObj->getScheduleDataByID($receiverShiftSerial);
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
        Mail::to($this->applicant->email)
            ->send(new AgreeShiftExchange($this->applicant, $this->receiver, $this->applicantShift, $this->receiverShift, $this->admin));
    }
}
