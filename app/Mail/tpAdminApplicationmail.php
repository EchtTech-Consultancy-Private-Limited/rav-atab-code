<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class tpAdminApplicationmail extends Mailable
{
    use Queueable, SerializesModels;

    public $tpadminMail,$application_id,$username;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($tpadminMail,$application_id,$username)
    {
        $this->tpadminMail = $tpadminMail;
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
        return $this->subject('RAV ATAB - Application Final Report Send Successfully')
                    ->view('email.tpadminMail');
    }
}
