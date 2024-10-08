<?php

namespace App\Jobs;

use App\Mail\NotificationTransaction as MailNotificationTransaction;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class NotificationTransaction implements ShouldQueue
{
    use Queueable;

    public $email, $data;

    /**
     * Create a new job instance.
     */
    public function __construct($email, $data)
    {
        $this->email = $email;
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $contents = new MailNotificationTransaction($this->data);
        Mail::to($this->email)->send($contents);
    }
}
