<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class assessoradminapplicationmail extends Mailable
{
    use Queueable, SerializesModels;

    public $adminapplicationsecretariatMail,$application_id,$username;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($adminapplicationsecretariatMail,$application_id,$username)
    {
        $this->adminapplicationsecretariatMail = $adminapplicationsecretariatMail;
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
        return $this->subject('RAV ATAB - Application Send Successfully to Assessor')
                    ->view('email.adminapplicationassessorMail');
    }
}
