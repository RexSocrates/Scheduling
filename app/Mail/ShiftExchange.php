<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ShiftExchange extends Mailable
{
    use Queueable, SerializesModels;
    
    protected $shift1 = '';
    protected $shift2 = '';

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($shift1, $shift2)
    {
        //
        $this->shift1 = $shift1;
        $this->shift2 = $shift2;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('排班人員換班通知')
            ->markdown('emails.shiftExchange', [
                'shift1' => $this->shift1,
                'shift2' => $this->shift2
            ]);
    }
}
