<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    public $registerMailData;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($registerMailData)
    {
        $this->registerMailData = $registerMailData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('RAV ATAB - Registration Success')
                    ->view('email.register-mail');
    }
}