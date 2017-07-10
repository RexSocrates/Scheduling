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
    
    protected $receiver;
    protected $originalShift;
    protected $newShift;
    protected $admin;
    

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($receiver, $originalShift, $newShift, $admin)
    {
        //從controller 接收資料
        $this->receiver = $receiver;
        $this->originalShift = $originalShift;
        $this->newShift = $newShift;
        $this->admin = $admin;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // 寄送換班通知信件
        Mail::to($this->receiver->email)
            ->send(new ShiftExchange($this->receiver->name, $this->originalShift, $this->newShift, $this->admin));
    }
}
