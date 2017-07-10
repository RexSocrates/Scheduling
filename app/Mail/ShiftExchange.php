<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ShiftExchange extends Mailable
{
    use Queueable, SerializesModels;
    
    // 排班人員將醫師換班後寄送通知信
    protected $receiverName = '';
    protected $originalShift;
    protected $newShift;
    protected $admin;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($receiverName, $originalShift, $newShift, $admin)
    {
        //
        $this->receiverName = $receiverName;
        $this->originalShift = $originalShift;
        $this->newShift = $newShift;
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
            ->subject('【馬偕醫院】班表更動通知')
            ->markdown('emails.shiftExchange', [
                'receiverName' => $this->receiverName,
                'originalShift' => $this->originalShift,
                'newShift' => $this->newShift,
                'admin' =. $this->admin
            ]);
    }
}
