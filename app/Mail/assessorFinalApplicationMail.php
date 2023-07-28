<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class assessorFinalApplicationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $assessorToself,$application_id;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($assessorToself,$application_id)
    {
        $this->assessorToself = $assessorToself;
        $this->application_id = $application_id;
   
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('RAV ATAB - Report Send Successfully')
                    ->view('email.documentFinalAssessor');
    }
}
