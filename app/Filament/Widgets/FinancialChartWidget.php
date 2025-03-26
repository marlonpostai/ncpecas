<?php

namespace App\Filament\Widgets;

use App\Models\Quote;
use Filament\Widgets\ChartWidget;

class FinancialChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Balanço Financeiro';
    protected static ?int $sort = 2;


    protected function getData(): array
    {
        $quotes = Quote::where('status', 'ENTREGUE')
            ->where('payment_received', true)
            ->with('quoteItems')
            ->orderBy('expected_payment_date')
            ->get();

        if ($quotes->isEmpty()) {
            return [
                'labels' => [],
                'datasets' => [],
            ];
        }

        $monthlyTotals = [];

        foreach ($quotes as $quote) {
            // Formata a data para "YYYY-MM" (exemplo: "2024-03")
            $month = \Carbon\Carbon::parse($quote->expected_payment_date)->format('Y-m');

            // Inicializa o mês no array, se ainda não existir
            if (!isset($monthlyTotals[$month])) {
                $monthlyTotals[$month] = 0;
            }

            // Soma os valores de total_with_discount para o mês correspondente
            $monthlyTotals[$month] += $quote->quoteItems->sum('total_with_discount');
        }

        // Ordena os meses em ordem crescente (YYYY-MM já é lexicograficamente ordenável)
        ksort($monthlyTotals);

        return [
            'labels' => array_keys($monthlyTotals), // Meses no eixo X (ordenados)
            'datasets' => [
                [
                    'label' => 'Balanço Financeiro',
                    'data' => array_values($monthlyTotals), // Valores somados por mês
                    'borderColor' => '#4CAF50',
                    'fill' => false,
                ],
            ],
        ];
    }





    protected function getType(): string
    {
        return 'line'; // Mantendo o gráfico como linha
    }

    public function getColumnSpan(): int|string|array
        {
            return 'full'; // Faz o gráfico ocupar toda a linha
        }


}
