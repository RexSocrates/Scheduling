<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Mail;
use App\Mail\DenyShiftExchange;

// import model
use App\User;

class SendDenyShiftExchangeMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    // 向提出換班的申請人通知對方已拒絕換班，applicant為提出換班的人，receiver為拒絕換班的人
    protected $applicant;
    protected $receiver;
    protected $admin;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($applicantID, $receiverID)
    {
        //
        $userObj = new User();
        
        $this->applicant = $userObj->getDoctorInfoByID($applicantID);
        $this->receiver = $userObj->getDoctorInfoByID($receiverID);
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
            ->send(new DenyShiftExchange($this->applicant, $this->receiver, $this->admin));
    }
}
