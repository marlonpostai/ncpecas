<?php

namespace App\Filament\Resources\QuoteResource\Pages;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Filament\Resources\QuoteResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewQuote extends ViewRecord
{
    protected static string $resource = QuoteResource::class;


}
