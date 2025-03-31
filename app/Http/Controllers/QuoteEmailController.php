<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvoiceMail; // Verifique se você já tem essa classe de e-mail
use Barryvdh\DomPDF\Facade\Pdf; // Verifique se você já tem o pacote DomPDF instalado

class QuoteEmailController extends Controller
{
    public function edit($id)
    {
        // Obtenha o orçamento ou qualquer dado necessário
        $quote = Quote::findOrFail($id);

        // Retorne a página de edição com os dados
        return view('email.edit', compact('quote'));
    }

    // App\Http\Controllers\QuoteEmailController.php

    public function send(Request $request, Quote $quote)
    {
        $validated = $request->validate([
            'email_subject' => 'required|string|max:255',
            'email_body' => 'required|string',
            'recipient_email' => 'required|email',
        ]);

        $clientName = $quote->client->name;
        $clientEmail = $request->recipient_email;

        // Gera o PDF
        $pdf = Pdf::loadView('filament.pages.pdf', ['quote' => $quote]);

        // Envia o e-mail
        Mail::to($clientEmail)->send(new InvoiceMail(
            $quote,
            $clientName,
            $pdf,
            $validated['email_subject'],
            nl2br($validated['email_body']) // Mantém formatação no e-mail
        ));

        return redirect()->route('quote.email.edit', $quote->id)
                         ->with('success', 'Orçamento enviado por e-mail com sucesso!');
    }

}
