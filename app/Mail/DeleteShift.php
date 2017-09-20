<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DeleteShift extends Mailable
{
    use Queueable, SerializesModels;
    
    protected $doctor;
    protected $scheduleData;
    protected $admin

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($doctor, $scheduleData, $admin)
    {
        //
        $this->$doctor = $doctor;
        $this->scheduleData = $scheduleData;
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
            ->subject('【馬偕醫院】排班系統')
            ->markdown('emails.deleteShift', [
                'doctor' => $this->doctor,
                'scheduleData' => $this->scheduleData,
                'admin' => $this->admin
            ]);
    }
}
