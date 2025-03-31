<?php

namespace App\Mail;

use App\Models\Quote;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $quote;
    public $clientName;
    public $pdf;
    public $subject;
    public $body;

    public function __construct(Quote $quote, $clientName, $pdf, $subject, $body)
    {
        $this->quote = $quote;
        $this->clientName = $clientName;
        $this->pdf = $pdf;
        $this->subject = $subject;
        $this->body = $body;
    }

    public function build()
    {
        // Remove espaços do nome do cliente e pega as 10 primeiras letras
        $clientNamePart = substr(str_replace(' ', '_', $this->quote->client->name), 0, 10);
        $attachmentName = 'Orçamento_'
            . $clientNamePart
            . '_N' . $this->quote->quote_number
            . '_' . $this->quote->created_at->format('d-m-Y')
            . '.pdf';

        return $this->subject($this->subject)
                    ->view('emails.invoice_email')
                    ->with(['body' => $this->body])
                    ->attachData($this->pdf->output(), $attachmentName, [
                        'mime' => 'application/pdf',
                    ]);
    }
}
