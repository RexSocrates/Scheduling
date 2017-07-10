<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ShiftExchangingInform extends Mailable
{
    use Queueable, SerializesModels;
    
    // 雙方同意換班後通知排班人員進行確認
    protected $admin;
    protected $applicant;
    protected $receiver;
    protected $applicantShift;
    protected $receiverShift;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($admin, $applicant, $receiver, $applicantShift, $receiverShift)
    {
        //
        $this->admin = $admin;
        $this->applicant = $applicant;
        $this->receiver = $receiver;
        $this->applicantShift = $applicantShift;
        $this->receiverShift = $receiverShift;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('【馬偕醫院】換班申請通知')
            ->markdown('emails.shiftExchangingInform', [
                'admin' => $this->admin,
                'applicant' => $this->applicant,
                'receiver' => $this->receiver,
                'applicantShift' => $this->applicantShift,
                'receiverShift' = $this->receiverShift
            ]);
    }
}
