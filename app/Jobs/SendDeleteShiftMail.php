<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

// import mail
use Mail;
use App\Mail\DeleteShift;

// import model
use App\User;
use App\Schedule;

class SendDeleteShiftMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    // 寄送上班時段被移除之信件
    protected $doctor;
    protected $scheduleData;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($doctorID, $scheduleData)
    {
        //所需參數：通知的醫生ID, 被移除的班的資料
        $this->doctor = $doctorID;
        $this->scheduleData = $scheduleData;
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
            ->send(new DeleteShift($this->doctor, $this->schedule));
    }
}
