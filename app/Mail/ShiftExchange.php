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
    protected $originalLocation;
    protected $originalShiftName;
    
    protected $newShift;
    protected $newLocation;
    protected $newShiftName;
    protected $admin;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($receiverName, $originalShift, $originalShiftName, $newShift, $newShiftName, $admin)
    {
        //
        $this->receiverName = $receiverName;
        
        $this->originalShift = $originalShift;
        if($originalShift->location == 'Taipei') {
            $this->originalLocation = '台北';
        }else {
            $this->originalLocation = '淡水';
        }
        $this->originalShiftName = $originalShiftName;
        
        $this->newShift = $newShift;
        if($newShift->location == 'Taipei') {
            $this->newLocation = '台北';
        }else {
            $this->newLocation = '淡水';
        }
        $this->newShiftName = $newShiftName;
        
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
                'originalLocation' => $this->originalLocation,
                'originalShiftName' => $this->originalShiftName,
                'newShift' => $this->newShift,
                'newLocation' => $this->newLocation,
                'newShiftName' => $this->newShiftName,
                'admin' => $this->admin
            ]);
    }
}
