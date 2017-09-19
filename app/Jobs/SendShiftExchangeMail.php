<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Mail;
use App\Mail\ShiftExchange;

use App\User;
use App\Schedule;

class SendShiftExchangeMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    // 排班人員強制更換上班的通知信件
    protected $receiver;
    protected $originalShift;
    protected $newShift;
    protected $admin;
    

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($receiverID, $originalShiftSerial, $newShiftSerial)
    {
        // 所需參數：被換班的醫生ID, 原本的上班資料, 新的上班編號
        //從controller 接收資料
        $userObj = new USer();
        $scheduleObj = new Schedule();
        
        $this->receiver = $userObj->getDoctorInfoByID($receiverID);
        $this->originalShift = $scheduleObj->getScheduleDataByID($originalShiftSerial);
        
        $this->newShift = $scheduleObj->getScheduleDataByID($newShiftSerial);;
        
        // 取得排班人員聯絡資訊
        $this->admin = $userObj->getAdminList()[0];
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
