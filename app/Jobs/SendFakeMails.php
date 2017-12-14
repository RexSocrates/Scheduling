<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Mail;
use App\Mail\FakeMail2;
use App\Mail\FakeMail3;

class SendFakeMails implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // 同意申請
        Mail::to('georgelesliemackay0@gmail.com')->send(new FakeMail2());
        // 排班人員確認申請1
        Mail::to('georgelesliemackay0@gmail.com')->send(new FakeMail3());
    }
}
