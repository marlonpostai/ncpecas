<?php

namespace App\Filament\Widgets;

use App\Enums\QuoteStatus;
use App\Models\Quote;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class Status extends BaseWidget
{
    protected static ?string $pollingInterval = null;

    protected static ?int $sort = 0;

    protected function getStats(): array
    {
        $quoteCount = Quote::count();
        $aguardando_apCount = Quote::where('status', QuoteStatus::AGUARDANDO_APROVACAO)->count();
        $aprovadoCount = Quote::where('status', QuoteStatus::APROVADO)->count();
        $rejeitadoCount = Quote::where('status', QuoteStatus::REJEITADO)->count();
        $entregueCount = Quote::where('status', QuoteStatus::ENTREGUE)->count();
        $financeresume = 'R$ ' . number_format(
            Quote::where('status', QuoteStatus::ENTREGUE)
                ->where('payment_received', true)
                ->with('quoteItems')
                ->get()
                ->flatMap(fn($quote) => $quote->quoteItems)
                ->sum('total_with_discount'),
            2, ',', '.'
        );

        // Calcular "A Receber"
        $areceber = 'R$ ' . number_format(
            Quote::where('status', QuoteStatus::ENTREGUE)
                ->where('payment_received', false)
                ->with('quoteItems')
                ->get()
                ->flatMap(fn($quote) => $quote->quoteItems)
                ->sum('total_with_discount'),
            2, ',', '.'
        );

        return [
            Stat::make('Total de Orçamentos', $quoteCount)
                ->description('Novos orçamentos realizados')
                ->descriptionIcon('heroicon-o-clipboard-document-list', IconPosition::Before)
                ->chart([13, 13, 13])
                ->color('success'),

            Stat::make('Aguardando Aprovação', $aguardando_apCount)
                ->description('Em processo')
                ->descriptionIcon('heroicon-o-clipboard-document-list', IconPosition::Before)
                ->chart([12, 12, 12, 30, 50])
                ->color('warning'),

            // Stat::make('Aprovado', $aprovadoCount),
            // Stat::make('Rejeitado', $rejeitadoCount),
            // Stat::make('Produtos Entregues', $entregueCount)
            //     ->description('Completo')
            //     ->descriptionIcon('heroicon-m-clipboard-document-check', IconPosition::Before)
            //     ->chart([12, 12, 12, 30, 50])
            //     ->color('info'),
            Stat::make('Resumo Financeiro', $financeresume)
                ->description('Receita Bruta')
                ->descriptionIcon('heroicon-m-banknotes', IconPosition::Before)
                ->chart([12, 12, 12, 30, 50])
                ->color('success'),

            Stat::make('A Receber', $areceber)
                ->description('Valores pendentes de pagamento')
                ->descriptionIcon('heroicon-m-banknotes', IconPosition::Before)
                ->chart([12, 12, 12, 30, 50])
                ->color('info'),


        ];
    }
}
