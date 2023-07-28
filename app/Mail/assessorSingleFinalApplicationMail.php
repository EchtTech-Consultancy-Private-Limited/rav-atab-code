<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class assessorSingleFinalApplicationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $assessorToSingle,$application_id;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($assessorToSingle,$application_id)
    {
        $this->assessorToSingle = $assessorToSingle;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('RAV ATAB - Application Report Send Successfully to Admin')
                    ->view('email.assessorSingleComment');
    }
}
