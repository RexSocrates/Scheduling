<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AgreeShiftExchange extends Mailable
{
    use Queueable, SerializesModels;
    
    // 向提出換班的申請人通知對方已確認換班，applicant為提出換班的人，receiver為確認換班的人
    protected $applicant;
    protected $receiver;
    // applicantShift與receiverShift 為換班前的資料
    protected $applicantShift;
    protected $receiverShift;
    protected $admin;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($applicant, $receiver, $applicantShift, $receiverShift, $admin)
    {
        // 以下皆為單一物件
        $this->applicant = $applicant;
        $this->receiver = $receiver;
        $this->applicantShift = $applicantShift;
        $this->receiverShift = $receiverShift;
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
            ->subject('【馬偕醫院】換班申請回復(答應)')
            ->markdown('emails.agreeShiftExchange', [
                'applicant' => $this->applicant,
                'receiver' =>$this->receiver,
                'applicantShift' => $this->applicantShift,
                'receiverShift' => $this->receiverShift,
                'admin' => $this->admin
            ]);
    }
}
