<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class assessorSingleFinalMail extends Mailable
{
    use Queueable, SerializesModels;

    public $assessorToSingleApplication,$application_id;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($assessorToSingleApplication,$application_id)
    {
        $this->assessorToSingleApplication = $assessorToSingleApplication;
        $this->application_id = $application_id;
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('RAV ATAB - Received Application Report from Admin')
                    ->view('email.assessorSingleComment');
    }
}
