<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class tpApplicationmail extends Mailable
{
    use Queueable, SerializesModels;

    public $tpMail,$application_id,$username;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($tpMail,$application_id,$username)
    {
        $this->tpMail = $tpMail;
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
        return $this->subject('RAV ATAB - Received Application Report from Admin')
                    ->view('email.tpMail');
    }
}
