<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SecretariatApplication extends Mailable
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
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Secretariat Application '.$this->application_id.'',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'email.applicationsecretariatMail',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
