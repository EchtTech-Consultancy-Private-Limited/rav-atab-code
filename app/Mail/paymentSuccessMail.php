<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class paymentSuccessMail extends Mailable
{
    use Queueable, SerializesModels;

    public $paymentMail,$paymentid,$userid;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($paymentMail,$paymentid,$userid)
    {
        $this->paymentMail = $paymentMail;
        $this->paymentid = $paymentid;
        $this->userid = $userid;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('RAV ATAB - Course Payment Success')
                    ->view('email.payment-email');
    }
}
