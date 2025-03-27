<?php

namespace App\Filament\Widgets;

use App\Models\Quote;
use App\Models\QuoteItem;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class PendingPaymentsTable extends BaseWidget
{
    protected static ?string $heading = 'Orçamentos Pendentes de Pagamento';
    protected static bool $isLazy = false;
    protected static ?int $sort = 3;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Quote::where('status', 'entregue')
                    ->where('payment_received', false)
            )
            ->columns([
                Tables\Columns\TextColumn::make('quote_number')
                    ->label('Número do Orçamento')
                    ->sortable(),
                Tables\Columns\TextColumn::make('quoteItems.total_with_discount')
                    ->label('Total')
                    ->money('BRL')
                    ->formatStateUsing(fn (string $state): string =>
                        'R$ ' . number_format(array_sum(array_map('floatval', explode(',', $state))), 2, ',', '.')
                    )
                    ->sortable(),

                Tables\Columns\TextColumn::make('expected_payment_date')
                    ->label('Previsão de Pagamento')
                    ->date()
                    ->color('success')
                    ->badge()
                    ->sortable(),

            ]);
    }
}
