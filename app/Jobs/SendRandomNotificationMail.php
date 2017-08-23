<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

// import mail
use App\Mail\RandomNotification;

// import model
use App\Reservation;
use App\USer;

class SendRandomNotificationMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    protected $reservation;
    protected $emails;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($resSerial, $receiversID)
    {
        //
        $resObj = new Reservation();
        
        $this->reservation; = $resObj->getReservationBySerial($resSerial);
        
        // 取得list 當中的使用者的email
        $receiversEmail = [];
        $userObj = new User();
        
        foreach($receiversID as $ID) {
            $email = $userObj->getDoctorInfoByID($ID)->email;
            
            array_push($receiversEmail, $email);
        }
        
        $this->emails = $receiversEmail;
        
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
            Mail::to($email)->send(new RandomNotification());
        }
        
    }
}
