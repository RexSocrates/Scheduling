<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DenyShiftExchange extends Mailable
{
    use Queueable, SerializesModels;
    
    // 向提出換班的申請人通知對方已拒絕換班，applicant為提出換班的人，receiver為拒絕換班的人
    protected $applicant;
    protected $receiver;
    protected $admin;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($applicant, $receiver, $admin)
    {
        //
        $this->applicant = $applicant;
        $this->receiver = $receiver;
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
            ->subject('【馬偕醫院】換班申請回復(拒絕)')
            ->markdown('emails.denyShiftExchange', [
                'applicant' => $this->applicant,
                'receiver' => $this->receiver,
                'admin' => $this->admin
            ]);
    }
}
