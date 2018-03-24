<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ApplyShiftExchange extends Mailable
{
    use Queueable, SerializesModels;
    
    // 醫師向其他醫師提出換班申請通知信件
    protected $applicant;
    protected $receiver;
    protected $applicantShift;
    protected $applicantShiftName;
    protected $applicantShiftLocation;
    
    protected $receiverShift;
    protected $receiverShiftName;
    protected $receiverShiftLocation;
    protected $admin;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($applicant, $receiver, $applicantShift, $applicantShiftName, $receiverShift, $receiverShiftName, $admin)
    {
        //
        $this->receiver = $receiver;
        $this->applicant = $applicant;
        
        $this->applicantShift = $applicantShift;
        $this->applicantShiftName = $applicantShiftName;
        if($this->applicantShift->location == 'Taipei') {
            $this->applicantShiftLocation = '台北';
        }else {
            $this->applicantShiftLocation = '淡水';
        }
        
        $this->receiverShift = $$receiverShift;
        $this->receiverShiftName = $receiverShiftName;
        if($this->receiverShift->location == 'Taipei') {
            $this->receiverShiftLocation = '台北';
        }else {
            $this->receiverShiftLocation = '淡水';
        }
        
        $this->admin = $admin;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('【馬偕醫院】換班申請確認')
            ->markdown('emails.applyShiftExchange', [
                'receiverName' => $this->receiver->name,
                'applicant' => $this->applicant,
                'applicantShift' => $this->applicantShift,
                'applicantShiftName' => $this->applicantShiftName,
                'applicantShiftLocation' => $this->applicantShiftLocation,
                'receiverShift' => $this->receiverShift,
                'receiverShiftName' => $this->receiverShiftName,
                'receiverShiftLocation' => $this->receiverShiftLocation,
                'admin' => $this->admin
            ]);
    }
}
