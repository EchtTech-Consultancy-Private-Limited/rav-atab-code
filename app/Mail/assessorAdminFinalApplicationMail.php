<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class assessorAdminFinalApplicationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $assessorToAdmin,$application_id;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($assessorToAdmin,$application_id)
    {
        $this->assessorToAdmin = $assessorToAdmin;
        $this->application_id = $application_id;
   
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('RAV ATAB - You have Received a Final Application Report from Assessor')
                    ->view('email.documentassessortoAdmin');
    }
}
