<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RandomNotification extends Mailable
{
    use Queueable, SerializesModels;
    
    protected $reservation; // 預約資料
    protected $cateName; // 預約班別的名稱
    protected $amount = 0; // 預約人數
    protected $admin; // 排班人員資料

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($reservation, $cateName, $amount, $admin)
    {
        //
        $this->reservation = $reservation;
        $this->cateName = $cateName;
        $this->amount = $amount;
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
            ->subject('【馬偕醫院】預班人數過多通知')
            ->markdown('emails.randomNitification', [
            'res' => $this->reservation,
            'resCateName' => $this->cateName,
            'amount' => $this->amount,
            'admin' => $this->admin
        ]);
    }
}
