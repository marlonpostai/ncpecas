<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    public function store(Request $request)
    {
        // Validação dos dados
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'user_id' => 'required|exists:users,id',
            'items' => 'required|array',
            'items.*.product_service_id' => 'required|exists:product_services,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        // Criação do orçamento (Quote)
        $quote = Quote::create([
            'creation_date' => now(),
            'client_id' => $validated['client_id'],
            'user_id' => $validated['user_id'],
            'quote_number' => Quote::generateQuoteNumber(),
        ]);

        // Adiciona os itens ao orçamento
        foreach ($validated['items'] as $item) {
            $quote->quoteItems()->create([
                'product_service_id' => $item['product_service_id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'total_price' => $item['quantity'] * $item['unit_price'],
            ]);
        }

        return response()->json(['message' => 'Orçamento criado com sucesso!', 'quote' => $quote]);
    }
}
