<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Mail;
use App\Mail\ShiftExchange;

class SendShiftExchangeMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    protected $shift1 = '';
    protected $shift2 = '';
    protected $receiverEmail = '';

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($shift1, $shift2, $receiverEmail)
    {
        //
        $this->shift1 = $shift1;
        $this->shift2 = $shift2;
        $this->receiverEmail = $receiverEmail
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
            ->send(new ShiftExchange($this->shift1, $this->shift2));
    }
}
