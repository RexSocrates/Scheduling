<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Mail;
use App\Mail\ApplyShiftExchange;

// import model
use App\User;
use App\Schedule;

class SendApplyShiftExchangeMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    // 對醫生通知有人對他/她申請換班
    protected $receiver;
    protected $applicant;
    protected $applicantShift;
    protected $receiverShift;
    protected $admin;
    

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($receiverID, $applicantID, $applicantShiftID, $receiverShiftID)
    {
        //所需參數 接收者的ID, 提出人的ID, 提出人用來交換的班ID, 接收者被提出更換的班ID
        $userObj = new User();
        
        $this->receiver = $userObj->getDoctorInfoByID($receiverID);
        $this->applicant = $userObj->getDoctorInfoByID($applicantID);
        
        $schObj = new Schedule();
        $this->applicantShift = $schObj->getScheduleDataByID($applicantShiftID);
        $this->receiverShift = $schObj->getScheduleDataByID($receiverShiftID);
        
        // 取得排班人員資料
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
        Mail::to($this->receiver->email)
            ->send(new ApplyShiftExchange($this->applicant, $this->receiver));
    }
}
