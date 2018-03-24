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
use App\ScheduleCategory;

class SendDeleteShiftMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    // 寄送上班時段被移除之信件
    protected $doctor;
    protected $scheduleData;
    
    protected $month;
    protected $day;
    protected $location;
    protected $schCateName;
    
    protected $admin;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($doctorID, $scheduleID)
    {
        //所需參數：通知的醫生ID, 被移除的班的ID
        $userObj = new User();
        $this->doctor = $userObj->getDoctorInfoByID($doctorID);
        
        $schObj = new Schedule();
        $this->scheduleData = $schObj->getScheduleDataByID($scheduleID);
        
        $schDate = $this->scheduleData->date;
        $schDateArr = explode('-', $schDate);
        
        $this->month = $schDateArr[1];
        $this->day = $schDateArr[2];
        
        $location = '';
        if($this->scheduleData->location == 'Taipei') {
            $this->location = '台北';
        }else {
            $this->location = '淡水';
        }
        
        $this->admin = $userObj->getAdminList()[0];
        
        $schCateObj = new ScheduleCategory();
        $this->schCateName = $schCateObj->getSchCateName($this->scheduleData->schCategorySerial);
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
            ->send(new DeleteShift($this->doctor, $this->admin, $this->month, $this->day, $this->location, $this->schCateName));
    }
}
