<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Mail;
use App\Mail\ShiftExchangingInform;

use App\User;
use App\Schedule;
use App\ShiftRecords;

class SendShiftExchangingInformMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    // 雙方同意換班後通知排班人員進行確認，applicantShift與receiverShift 為尚未換班時的資料
    protected $admin;
    protected $applicant;
    protected $receiver;
    protected $applicantShift;
    protected $receiverShift;
    
    protected $shitRecordData;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    

    public function __construct($changeSerial)
    {
        // $admin, $applicantID, $receiverID, $applicantShiftID, $receiverShiftID
        $userObj = new User();
        $schObj = new Schedule();
        
        $this->admin = $userObj->getAdminList()[0];
        
        // 使用change serial 取得換班資料
        $shiftRecObj = new ShiftRecords();
        $shiftRecordData = $shiftRecObj->getShiftRecordByChangeSerial($changeSerial);
        
        // 取出換班資訊
        $this->shitRecordData = $shiftRecordData;
        
        // 從換班紀錄中取得醫師1與醫師2的資料
        $this->applicant = $userObj->getDoctorInfoByID($shiftRecordData->schID_1_doctor);
        $this->receiver = $userObj->getDoctorInfoByID($shiftRecordData->schID_2_doctor);
        
        // 取得提出申請換班的人的原本的資訊
        $this->applicantShift = $schObj->getScheduleDataByID($shiftRecordData->scheduleID_1);
        // 取出換班申請的對象的原始上班資料
        $this->receiverShift = $schObj->getScheduleDataByID($shiftRecordData->scheduleID_2);
        
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        Mail::to($this->admin->email)
            ->send(new ShiftExchangingInform($this->admin, $this->applicant, $this->receiver, 
                                             $this->applicantShift, $this->receiverShift));
    }
}
