<?php

namespace App\Filament\Resources\QuoteResource\Pages;

use App\Filament\Resources\QuoteResource;
use App\Models\Quote;
use App\Models\QuoteItem;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateQuote extends CreateRecord
{
    protected static string $resource = QuoteResource::class;

    // Mutar os dados do formulário antes de criar
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::id(); // Adiciona o ID do usuário autenticado

        return $data;
    }

    // Lógica para executar após criar a cotação
    protected function afterCreate(): void
    {
        $activeQuoteId = $this->record->id;

        // Buscar a última cotação do mesmo cliente
        $lastQuote = Quote::where('client_id', '=', $this->record->client_id)
            ->orderBy('id', 'DESC')
            ->first();

        if ($lastQuote) {
            foreach ($lastQuote->quoteItems as $item) {
                QuoteItem::create([
                    'quote_id' => $activeQuoteId,
                    'product_service_id' => $item->product_service_id,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->unit_price,
                    'total_price' => $item->total_price,
                ]);
            }
        }
    }

    // Redirecionar para a página de edição após criação
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('edit', ['record' => $this->record->getKey()]);
    }
}
