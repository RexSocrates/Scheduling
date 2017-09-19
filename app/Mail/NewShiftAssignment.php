<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewShiftAssignment extends Mailable
{
    use Queueable, SerializesModels;
    
    protected $doctor;
    protected $schedule;
    protected $admin;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($doctor, $schedule, $admin)
    {
        //
        $this->doctor = $doctor;
        $this->schedule = $schedule;
        $this->admin = $admin
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('【馬偕醫院】排班系統')
            ->markdown('emails.newShiftAssignment', [
                'doctor' => $this->doctor,
                'schedule' => $this->schedule,
                'admin' => $this->admin
        ]);
    }
}
