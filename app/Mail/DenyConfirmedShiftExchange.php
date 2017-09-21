<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DenyConfirmedShiftExchange extends Mailable
{
    use Queueable, SerializesModels;
    
    protected $doctor1;
    protected $doctor2;
    
    protected $schData1;
    protected $schData2;
    
    protected $admin;
    

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($doctor1, $doctor2, $schData1, $schData2)
    {
        // email 建構式中的所有參數皆為完整的物件
        $this->doctor1 = $doctor1;
        $this->doctor2 = $doctor2;
        
        $this->schData1 = $schData1;
        $this->schData2 = $schData2;
        
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
            ->subject('【馬偕醫院】換班申請回復（拒絕）')
            ->markdown('emails.denyConfirmedShiftExchange', [
                'doctor1' => $this->doctor1,
                'doctor2' => $this->doctor2,
                'schData1' => $this->schData1,
                'schData2' => $this->schData2,
                'admin' => $this->admin
            ]);
    }
}
