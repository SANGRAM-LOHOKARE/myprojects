<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;
use App\Mail\Taskmail;

class SendEmailJob implements ShouldQueue
{
    use Queueable;
    private $data;
    /**
     * Create a new job instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $mail = new Taskmail($this->data);
        Mail::to($this->data->task_owner_email)->send($mail);
    }
}
