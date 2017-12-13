<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class FakeMail4 extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
            ->markdown('emails.fakeMail4', [
                'a_doctor' => '黃書田',
                'b_doctor' => '蔡維德',
                'a_date' => '2018年1月9日北白急救班',
                'b_date' => '2018年1月10日北白發燒',
                'a_email' => 'fake7@gmail.com',
                'b_email' => 'admin@gmail.com'
            ]);
    }
}
