<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class assessorapplicationmail extends Mailable
{
    use Queueable, SerializesModels;

    public $assessorapplicationMail,$application_id,$username;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($assessorapplicationMail,$application_id,$username)
    {
        $this->assessorapplicationMail = $assessorapplicationMail;
        $this->application_id = $application_id;
        $this->username = $username;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('RAV ATAB - Received Application from Admin')
                    ->view('email.documentFinalAssessor');
    }
}
