<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Mail;
use Auth;

use App\Mail\ShiftExchange;
use App\Mail\ApplyShiftExchange;
use App\Mail\ExchangingSuccess;
use App\Mail\ExchangingFailed;

class MailController extends Controller
{
    
    // 排班人員換班後通知被換班的兩位醫師
    public function shiftExchange() {
        Mail::to('georgelesliemackay0@gmail.com')
            ->send(new ShiftExchange('台北白班發燒1', '淡水夜班發燒1'));
        
        echo '郵件已送出';
    }
    
    // 醫師A向醫師B提出換班申請時，以電子郵件通知
    public function applyShiftExchange() {
        $applicant = 'George';
        $receiver = 'Mario';
        
        Mail::to('georgelesliemackay0@gmail.com')
            ->send(new ApplyShiftExchange($applicant, $receiver));
        
        echo '郵件已送出';
    }
    
    // 醫師B同意換班後以電子郵件通知醫師A
    public function exchangingSuccess() {
        $applicant = 'George';
        $receiver = 'Mario';
        
        Mail::to('georgelesliemackay0@gmail.com')
            ->send(new ExchangingSuccess($applicant, $receiver));
        
        echo '郵件已送出';
    }
    
    // 醫師B拒絕換班後以電子郵件通知醫師A
    public function exchangingFailed() {
        $applicant = 'George';
        $receiver = 'Mario';
        
        Mail::to('georgelesliemackay0@gmail.com')
            ->send(new ExchangingFailed($applicant, $receiver));
        
        echo '郵件已送出';
    }
}
