<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class secretariatapplicationmail extends Mailable
{
    use Queueable, SerializesModels;

    public $applicationsecretariatMail,$application_id,$username;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($applicationsecretariatMail,$application_id,$username)
    {
        $this->applicationsecretariatMail = $applicationsecretariatMail;
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
        return $this->subject('RAV ATAB - Course Payment Success')
                    ->view('email.applicationsecretariatMail');
    }
}
