<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerificationMobile extends Mailable
{
    use Queueable, SerializesModels;

    public $verificationData;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($verificationData)
    {
        //

        $this->verificationData = $verificationData;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
   /* public function envelope()
    {
        return new Envelope(
            subject: 'Verification Mobile',
        );
    }*/

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
   /* public function content()
    {
        return new Content(
            view: 'view.name',
        );
    }*/

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
   /* public function attachments()
    {
        return [];
    }*/

    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
            ->to($this->verificationData['email'])
            ->subject('OTP for the ATAB Registration')
            ->view('email.verification-mobile')
            ->with('data', ['otp' => $this->verificationData['otp']],);
    }
}
