<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Mail;
use App\Mail\ExchangingSuccess;

class SendExchangingSuccessMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    protected $applicant = '';
    protected $receiver = '';
    protected $receiverEmail = '';

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($applicant, $receiver, $receiverEmail)
    {
        //
        $this->applicant = $applicant;
        $this->receiver = $receiver;
        $this->receiverEmail = $receiverEmail;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        Mail::to($this->receiverEmail)
            ->send(new ExchangingSuccess($this->applicant, $this->receiver));
    }
}
