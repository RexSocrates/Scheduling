<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ExchangingSuccess extends Mailable
{
    use Queueable, SerializesModels;
    
    protected $applicant = '';
    protected $receiver = '';

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($applicant, $receiver)
    {
        //
        $this->applicant = $applicant;
        $this->receiver = $receiver;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('換班申請成功')
            ->markdown('emails.exchangingSuccess', [
                'applicant' => $this->applicant,
                'receiver' => $this->receiver
            ]);
    }
}
