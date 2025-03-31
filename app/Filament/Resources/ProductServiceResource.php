<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductServiceResource\Pages;
use App\Models\ProductService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProductServiceResource extends Resource
{
    protected static ?string $model = ProductService::class;

    protected static ?string $navigationIcon = 'icon-product-classes-o';

    protected static ?string $modelLabel = 'Produtos';

    protected static ?string $pluralModelLabel = 'Produtos';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Name')
                    ->required(),
                Forms\Components\Textarea::make('description')
                    ->label('Description'),
                    Forms\Components\Textarea::make('reference')
                    ->label('Unidade'),
                Forms\Components\TextInput::make('price')
                    ->label('Price')
                    ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('sku')
                    ->label('Item')
                    ->required(),
                    // Campo para a primeira imagem
                Forms\Components\FileUpload::make('image_one')
                    ->label('Image One')
                    ->image()
                    ->disk('product_images') // Aqui utiliza o disco customizado
                    ->visibility('public')
                    ->required(),

                // Campo para a segunda imagem
                Forms\Components\FileUpload::make('image_two')
                    ->label('Image Two')
                    ->image()
                    ->disk('product_images') // Aqui utiliza o disco customizado
                    ->visibility('public'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('sku')
                    ->label('Item'),
                Tables\Columns\TextColumn::make('name')
                    ->label('Name'),
                Tables\Columns\TextColumn::make('price')
                    ->label('Price')
                    ->money('BRL', true),
                Tables\Columns\ImageColumn::make('image_one')
                    ->label('Image One')
                    ->disk('product_images'),
                Tables\Columns\TextColumn::make('description')
                    ->label('Description'),
                Tables\Columns\TextColumn::make('reference')
                    ->label('Unidade de Medida'),


                //Tables\Columns\ImageColumn::make('image_two')
                //    ->label('Image Two'),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProductServices::route('/'),
            'create' => Pages\CreateProductService::route('/create'),
            'edit' => Pages\EditProductService::route('/{record}/edit'),
        ];
    }
}
