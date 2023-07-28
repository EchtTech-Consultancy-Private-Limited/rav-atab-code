<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class adminSingleDocumentMail extends Mailable
{
    use Queueable, SerializesModels;

    public $AdminSingleDocumentCommentApplication;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($AdminSingleDocumentCommentApplication)
    {
        $this->AdminSingleDocumentCommentApplication = $AdminSingleDocumentCommentApplication;
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('RAV ATAB - Application Final Report Send Successfully')
                    ->view('email.adminSingleDocumentMail');
    }
}
