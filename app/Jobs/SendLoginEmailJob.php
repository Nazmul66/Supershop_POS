<?php

namespace App\Jobs;

use App\Mail\TwoFactorAuthMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendLoginEmailJob implements ShouldQueue
{
    use Queueable;

    public $admin;
    /**
     * Create a new job instance.
     */
    public function __construct($admin)
    {
        $this->admin = $admin;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to('hnazmul748@gmail.com')->send(new TwoFactorAuthMail($this->admin));
    }
}
