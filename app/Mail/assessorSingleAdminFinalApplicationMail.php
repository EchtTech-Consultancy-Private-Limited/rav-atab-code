<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class assessorSingleAdminFinalApplicationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $assessorToAdminSingle,$application_id;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($assessorToAdminSingle,$application_id)
    {
        $this->assessorToAdminSingle = $assessorToAdminSingle;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('RAV ATAB - You Have Received Application Report Successfully From Assessor')
                    ->view('email.assessorToAdminSingle');
    }
}
