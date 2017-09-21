<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DeleteShift extends Mailable
{
    use Queueable, SerializesModels;
    
    // 排班人員刪除醫師的班
    protected $doctor;
    protected $admin;
    protected $month;
    protected $day;
    protected $location;
    protected $schCateName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($doctor, $admin, $month, $day, $location, $schCateName)
    {
        //
        $this->doctor = $doctor;
        $this->admin = $admin;
        $this->month = $month;
        $this->day = $day;
        $this->location = $location;
        $this->schCateName = $schCateName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('【馬偕醫院】刪除班表確認')
            ->markdown('emails.deleteShift', [
                'doctor' => $this->doctor,
                'admin' => $this->admin,
                'month' => $this->month,
                'day' => $this->day,
                'location' => $this->location,
                'schCateName' => $this->schCateName
            ]);
    }
}
