<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

use Mail;
use App\Mail\RandomNotification;

use App\Jobs\SendAgreeShiftExchangeMail;
use App\Jobs\SendApplyShiftExchangeMail;
use App\Jobs\SendDenyShiftExchangeMail;
use App\Jobs\SendShiftExchangeMail;
use App\Jobs\SendShiftExchangingInformMail;
use App\Jobs\SendRandomNotificationMail;

use App\Reservation;

// 僅供信件發送測試用
class MailController extends Controller
{
    
    // 排班人員換班後通知被換班的兩位醫師
    public function sendShiftExchangeMail() {
        
        $job = new SendShiftExchangeMail(1, 1);
        
        dispatch($job);
        
        echo '郵件已送出';
    }
    
    // 醫師A向醫師B提出換班申請時，以電子郵件通知
    public function applyShiftExchanging() {
        $applicant = 'George';
        $receiver = 'Mario';
        
        $job = new SendApplyShiftExchangeMail($applicant, $receiver, 'georgelesliemackay0@gmail.com');
        
        dispatch($job);
        
        echo '郵件已送出';
    }
    
    // 醫師B同意換班後以電子郵件通知醫師A
    public function agreeShiftExchanging() {
        $applicant = 'George';
        $receiver = 'Mario';
        
        $job = new SendExchangingSuccessMail($applicant, $receiver, 'georgelesliemackay0@gmail.com');
        
        dispatch($job);
        
        echo '郵件已送出';
    }
    
    // 醫師B拒絕換班後以電子郵件通知醫師A
    public function rejectShiftExchanging() {
        $applicant = 'George';
        $receiver = 'Mario';
        
        $job = new SendExchangingFailedMail($applicant, $receiver, 'georgelesliemackay0@gmail.com');
        
        dispatch($job);
        
        echo '郵件已送出';
    }
    
    // 預班人數過多
    public function sendRandomNotificationMail() {
        $resSerial = 56;
        
        $job = new SendRandomNotificationMail($resSerial);
        
        dispatch($job);
        
        echo '工作已放入佇列';
        
        
        
//        Mail::to('socrateshung053@gmail.com')->send(new RandomNotification($resSerial));
        
//        echo '郵件已送出';
    }
}
