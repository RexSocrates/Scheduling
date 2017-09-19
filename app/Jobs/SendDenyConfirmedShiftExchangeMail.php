<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

// import mail
use Mail;
use App\Mail\DenyConfirmedShiftExchange;

// import model
use App\User;
use App\ShiftRecords;
use App\Schedule;

class SendDenyConfirmedShiftExchangeMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    // 排班人員拒絕兩位醫師都已經同意的換班申請
    protected $shiftRecordData;
    
    protected $doctor1;
    protected $doctor2;
    
    protected $sch1Data;
    protected $sch2Data;
    
    protected $admin;
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($changeSerial)
    {
        //所需參數：換班編號
        
        // 取得 換班紀錄內容
        $shiftRecordObj = new ShiftRecords();
        $this->shiftRecordData = $shiftRecordObj->getShiftRecordByChangeSerial($changeSerial);
        
        // 取得兩個班的資料
        $schObj = new Schedule();
        $this->sch1Data = $schObj->getScheduleDataByID($this->shiftRecordData->scheduleID_1);
        $this->sch2Data = $schObj->getScheduleDataByID($this->shiftRecordData->scheduleID_2);
        
        // 取得與此換班紀錄有關的醫生資料
        $userObj = new User();
        $this->doctor1 = $userObj->getDoctorInfoByID($this->shiftRecordData->schID_1_doctor);
        $this->doctor2 = $userObj->getDoctorInfoByID($this->shiftRecordData->schID_2_doctor);
        
        // 取得排班人員資訊
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
        Mail::to($this->doctor1->email)
            ->cc($this->doctor2->email)
            ->send(new DenyConfirmedShiftExchange($this->doctor1, $this->doctor2, $this->sch1Data, $this->sch2Data, $admin));
    }
}
