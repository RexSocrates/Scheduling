<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Mail;
use App\Mail\ApplyShiftExchange;

// import model
use App\User;
use App\Schedule;
use App\ScheduleCategory;
use App\ShiftRecords;

class SendApplyShiftExchangeMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    // 對醫生通知有人對他/她申請換班
    protected $receiver; // 換班申請對象的資料
    protected $applicant; // 換班申請人的資料
    
    // 換班內容的兩個班的資料
    protected $applicantShift;
    protected $applicantShiftName;
    
    protected $receiverShift;
    protected $receiverShiftName;
    
    protected $admin;
    

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($serial)
    {
        // 所需參數 : 換班編號 
        
        // 取得換班的內容
        $shiftRecObj = new ShiftRecords();
        $shiftRecordData = $shiftRecObj->getShiftRecordByChangeSerial($serial);
        
        // 換班的兩位醫師資料
        $userObj = new User();
        $this->applicant = $userObj->getDoctorInfoByID($shiftRecordData->schID_1_doctor);
        $this->receiver = $userObj->getDoctorInfoByID($shiftRecordData->schID_2_doctor);
        // 取得排班人員資料
        $this->admin = $userObj->getAdminList()[0];
        
        // 取得兩個班的資料
        $schObj = new Schedule();
        $this->applicantShift = $schObj->getScheduleDataByID($shiftRecordData->scheduleID_1);
        $this->receiverShift = $schObj->getScheduleDataByID($shiftRecordData->scheduleID_2);
        
        // 取得兩個班的名稱
        $schCateObj = new ScheduleCategory();
        $this->applicantShiftName = $schCateObj->getSchCateName($this->applicantShift->schCategorySerial);
        $this->receiverShiftName = $schCateObj->getSchCateName($this->receiverShift->schCategorySerial);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        Mail::to($this->receiver->email)
            ->send(new ApplyShiftExchange($this->applicant, $this->receiver, $this->applicantShift, $this->applicantShiftName, $this->receiverShift, $this->receiverShiftName, $this->admin));
    }
}
