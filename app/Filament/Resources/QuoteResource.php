<?php

namespace App\Filament\Resources;

use App\Enums\QuoteStatus;
use App\Filament\Resources\QuoteResource\Pages;
use App\Filament\Resources\QuoteResource\RelationManagers\QuoteRelationManager;
use App\Models\Quote;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\ToggleButtons;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QuoteResource extends Resource
{
    protected static ?string $model = Quote::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $modelLabel = 'Orçamento';

    protected static ?string $pluralModelLabel = 'Orçamentos';

    protected static ?int $navigationSort = 1;

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Section::make('Dados do Orçamento')->schema([
                    Grid::make(2)->schema([
                        TextInput::make('quote_number')
                            ->label('Número do Orçamento')
                            ->disabled()
                            ->default(fn () => Quote::generateQuoteNumber()),

                        DatePicker::make('creation_date')
                            ->label('Data de Criação')
                            ->default(now())
                            ->required(),

                        Select::make('client_id')
                            ->label('Cliente')
                            ->relationship('client', 'name')
                            ->preload()
                            ->searchable()
                            ->required(),

                        Select::make('user_id')
                            ->label('Usuário')
                            ->relationship('user', 'name')
                            ->disabled()
                            ->default(fn () => auth()->id()),

                        ToggleButtons::make('status')
                            ->options(QuoteStatus::class)
                            ->label('Status'),

                        DatePicker::make('expected_payment_date')
                            ->label('Data Prevista de Pagamento')
                            ->hidden(fn ($get) => $get('status') !== QuoteStatus::ENTREGUE->value)
                            ->default(fn () => now()->addDays(30)),

                    ]),
                ]),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('quote_number')
                    ->label('Número do Orçamento')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('creation_date')
                    ->label('Data de Criação')
                    ->date()
                    ->sortable(),

                TextColumn::make('client.name')
                    ->label('Cliente')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('user.name')
                    ->label('Usuário')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge(),

                TextColumn::make('expected_payment_date')
                    ->label('Data Prevista de Pagamento')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            QuoteRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQuotes::route('/'),
            'create' => Pages\CreateQuote::route('/create'),
            'edit' => Pages\EditQuote::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
