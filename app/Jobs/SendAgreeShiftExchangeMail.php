<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Mail;
use App\Mail\AgreeShiftExchange;

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
    public function __construct($applicant, $receiver, $applicantShift, $receiverShift, $admin)
    {
        //
        $this->applicant = $applicant;
        $this->receiver = $receiver;
        $this->applicantShift = $applicantShift;
        $this->receiverShift = $receiverShift;
        $this->admin = $admin;
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
            ->send(new AgreeShiftExchange());
    }
}
