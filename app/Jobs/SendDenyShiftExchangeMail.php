<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Mail;
use App\Mail\DenyShiftExchange;

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
    public function __construct($applicant, $receiver, $admin)
    {
        //
        $this->applicant = $applicant;
        $this->receiver = $receiver;
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
            ->send(new DenyShiftExchange());
    }
}
