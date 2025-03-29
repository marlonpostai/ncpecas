<?php

namespace App\Filament\Resources\QuoteResource\Pages;

use App\Filament\Resources\QuoteResource;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditQuote extends EditRecord
{
    protected static string $resource = QuoteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('Exportar PDF')
                ->label('Exportar PDF')
                ->color('info')
                // ->icon('heroicon-o-document-download')
                ->action(function () {
                    // Obtém o registro atual
                    $quote = $this->record;

                    // Gera o PDF passando a variável $quote para a view
                    $pdf = Pdf::loadView('filament.pages.pdf', ['quote' => $quote]);

                    return response()->streamDownload(
                        fn () => print($pdf->output()),
                        'orcamento_' . $quote->quote_number . '.pdf'
                    );
                }),

            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
