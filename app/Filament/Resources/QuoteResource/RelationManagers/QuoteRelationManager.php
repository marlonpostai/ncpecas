<?php

namespace App\Filament\Resources\QuoteResource\RelationManagers;

use App\Models\ProductService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\Summarizers\Sum;

class QuoteRelationManager extends RelationManager
{
    protected static string $relationship = 'quoteItems';

    protected static ?string $title = 'Itens do Orçamento';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('product_service_id')
                ->label('Produto/Serviço')
                ->options(fn () => ProductService::all()->pluck('name', 'id'))
                ->searchable()
                ->required()
                ->live()
                ->afterStateUpdated(function (?string $state, Forms\Set $set) {
                    $product = ProductService::find($state);
                    if ($product) {
                        $set('description', $product->description ?? '');
                        $set('unit_price', $product->price);
                    }
                }),
            Forms\Components\TextInput::make('description')
                ->label('Descrição')
                ->required(),
            Forms\Components\TextInput::make('unit_price')
                ->label('Preço Unitário')
                ->required()
                ->prefix('R$ '),
            Forms\Components\TextInput::make('quantity')
                ->label('Quantidade')
                ->required()
                ->live(debounce: 500)
                ->afterStateUpdated(function (?string $state, Forms\Set $set, $get) {
                    $unitPrice = $get('unit_price');
                    $set('total_price', $state * $unitPrice);
                }),
            Forms\Components\TextInput::make('total_price')
                ->label('Preço Total')
                ->prefix('R$ ')
                ->disabled(),

            // Toggle para aplicar desconto
            Forms\Components\Toggle::make('apply_discount')
                ->label('Aplicar Desconto')
                ->default(false)
                ->reactive()
                ->inline(false),

            // Campo para desconto em porcentagem
            Forms\Components\TextInput::make('item_discount_percent')
                ->label('Desconto (%)')
                ->numeric()
                ->hidden(fn (Forms\Get $get) => !$get('apply_discount'))
                ->reactive()
                ->afterStateUpdated(function (?string $state, Forms\Set $set, $get) {
                    if ($get('apply_discount')) {
                        $totalPrice = $get('total_price');
                        $discount = $totalPrice * ($state / 100);
                        $set('total_with_discount', $totalPrice - $discount);
                    }
                }),

            // Total com desconto
            Forms\Components\TextInput::make('total_with_discount')
                ->label('Total com Desconto')
                ->prefix('R$ ')
                ->disabled(),
        ])->columns(3);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('productService.name')
            ->columns([
                Tables\Columns\TextColumn::make('description')->label('Descrição'),
                Tables\Columns\TextColumn::make('quantity')->label('Quantidade')
                    ->summarize(Sum::make()->label('Total Quantidade')),
                Tables\Columns\TextColumn::make('unit_price')->label('Preço Unitário')->prefix('R$ '),
                Tables\Columns\TextColumn::make('total_price')->label('Preço Total')->prefix('R$ ')
                    ->summarize(Sum::make()->label('Total Geral')),

                // Coluna para exibir o desconto (%)
                Tables\Columns\TextColumn::make('item_discount_percent')
                    ->label('Desconto (%)')
                    ->formatStateUsing(fn (?string $state) => $state ? "{$state}%" : '-'),

                // Coluna para exibir o total com desconto
                Tables\Columns\TextColumn::make('total_with_discount')
                    ->label('Total com Desconto')
                    ->prefix('R$ ')
                    ->summarize(Sum::make()->label('Total com Desconto Geral')),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['total_price'] = $data['quantity'] * $data['unit_price'];

                        if (!empty($data['apply_discount']) && !empty($data['item_discount_percent'])) {
                            $discount = $data['total_price'] * ($data['item_discount_percent'] / 100);
                            $data['total_with_discount'] = $data['total_price'] - $discount;
                        } else {
                            $data['total_with_discount'] = $data['total_price'];
                        }

                        \Log::info('Dados salvos no banco:', $data); // Log dos dados

                        return $data;
                    })

                    ->label('Adicionar Item'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['total_price'] = $data['quantity'] * $data['unit_price'];

                        if (!empty($data['apply_discount']) && !empty($data['item_discount_percent'])) {
                            $discount = $data['total_price'] * ($data['item_discount_percent'] / 100);
                            $data['total_with_discount'] = $data['total_price'] - $discount;
                        } else {
                            $data['total_with_discount'] = $data['total_price'];
                        }

                        return $data;
                    }),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
