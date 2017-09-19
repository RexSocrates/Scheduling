<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

// import mail
use Mail;
use App\Mail\RandomNotification;

// import model
use App\Reservation;
use App\DoctorAndReservation;
use App\User;
use App\ShiftCategory;

class SendRandomNotificationMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    // 當預約人數過多，向所有預約的醫師通知人數過多將會隨機選取上班醫師
    protected $adminInfo;
    protected $reservation;
    protected $emails = [];
    protected $cateName = '';
    protected $amount = 0;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($resSerial)
    {
        //
        $resObj = new Reservation();
        
        $this->reservation = $resObj->getReservationBySerial($resSerial);
        
        // 取得單一預班的人
        $resAndDoctorObj = new DoctorAndReservation();
        $doctorsID = $resAndDoctorObj->getDoctorsByResSerial($resSerial);
        
        // 取得預約人數
        $this->amount = $resAndDoctorObj->amountInResserial($resSerial);
        
        // 取得list 當中的使用者的email
        $receiversEmail = [];
        $userObj = new User();
        
        // 取得排班人員資料
        $this->adminInfo = $userObj->getAdminList()[0];
        
        foreach($doctorsID as $ID) {
            array_push($receiversEmail, $userObj->getDoctorInfoByID($ID->doctorID)->email);
        }
        
        $this->emails = $receiversEmail;
        
        // 取得預約班別的名稱
        $shiftCate = new ShiftCategory();
        $this->cateName = $shiftCate->findName($this->reservation->categorySerial);
        
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        foreach($this->emails as $email) {
            Mail::to($email)
                ->send(new RandomNotification($this->reservation, $this->cateName, $this->amount, $this->adminInfo));
        }
        
    }
}
