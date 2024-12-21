<?php

namespace App\Filament\Resources\QuoteResource\Pages;

use App\Filament\Resources\QuoteResource;
use Filament\Actions;
use Filament\Actions\ExportAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListQuotes extends ListRecords
{
    protected static string $resource = QuoteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    /**
     * Define tabs no topo da tabela.
     */
     public function getTabs(): array
     {
         return [
             'Todas' => Tab::make('Todas')->query(fn ($query) => $query),
             'Aguardando Aprovação' => Tab::make()->query(fn ($query) => $query->where('status', 'aguardando_ap')),
             'Aprovado' => Tab::make()->query(fn ($query) => $query->where('status', 'aprovado')),
             'Rejeitado' => Tab::make()->query(fn ($query) => $query->where('status', 'rejeitado')),
             'Entregue' => Tab::make()->query(fn ($query) => $query->where('status', 'entregue')),
         ];
     }

}
