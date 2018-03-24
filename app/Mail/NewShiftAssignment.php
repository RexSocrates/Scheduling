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
    
    protected $scheduleData;
    // 月 日 院 班
    protected $month;
    protected $day;
    protected $location;
    protected $shiftName;
    
    protected $admin;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($doctor, $scheduleData, $admin)
    {
        //
        $this->doctor = $doctor;
        $this->scheduleData = $scheduleData;
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
            ->subject('【馬偕醫院】新增班表確認')
            ->markdown('emails.newShiftAssignment', [
                'doctor' => $this->doctor,
                'schedule' => $this->scheduleData,
                'admin' => $this->admin
        ]);
    }
}
