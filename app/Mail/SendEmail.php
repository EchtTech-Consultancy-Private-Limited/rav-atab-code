<?php
  
namespace App\Mail;
  
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
  
class SendEmail extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * Create a new message instance.
     */
    public function __construct($data)
    {
          $this->data = $data;
    }
  
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'RAV ATAB -'.$this->data['subject'],
        );
    }
  
    /**
     * Get the message content definition.
     */
    public function content(): Content
    {

        $template = 'email';
        if($this->data['action_type']=="new_application"){
            if($this->data['user_type']=='tp'){
                $template = 'NewApplicationByTp.tp';
            }else if($this->data['user_type']=='accountant'){
                $template = 'NewApplicationByTp.account';
            }else if(in_array($this->data['user_type'],['admin','secretariat'])){
                $template = 'NewApplicationByTp.admin';
            }
            }else if($this->data['action_type']=="payment_approve"){
                if($this->data['user_type']=='tp'){
                    $template = 'PaymentApprove.TP';
                }else if($this->data['user_type']=='accountant'){
                    $template = 'PaymentApprove.account';
                }else if(in_array($this->data['user_type'],['admin','secretariat'])){
                    $template = 'PaymentApprove.admin';
                }
            }
            else if($this->data['action_type']=="nc_created"){
                if($this->data['user_type']=='tp'){
                    $template = 'NcCreated.tp';
                }
            }
            else if($this->data['action_type']=="final_submit_assessor"){
                if($this->data['user_type']=='tp'){
                    $template = 'SubmitFinalSummary.tp';
                }else if(in_array($this->data['user_type'],['admin','secretariat'])){
                    $template = 'SubmitFinalSummary.admin';
                }
            }
            else if($this->data['action_type']=="certificate_generate"){
                if($this->data['user_type']=='tp'){
                    $template = 'CertificateGenerate.tp';
                }
            }

        return new Content(
            view: 'email.'.$template.'',
            with:['data'=>$this->data]
        );
    }
  
    /**
     * Get the attachments for the message.
     *
     * @return array

     */
    public function attachments(): array
    {
        return [];
    }
}