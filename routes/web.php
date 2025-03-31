<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuoteEmailController;

Route::get('/', function () {
    return view('site/landing/home');
});

Route::prefix('app/quotes')->group(function () {
    // Rota de edição do e-mail
    Route::get('{quoteId}/email/edit', [QuoteEmailController::class, 'edit'])
        ->name('quote.email.edit');

    // Rota para envio do e-mail
    Route::post('{quoteId}/email/send', [QuoteEmailController::class, 'send'])
        ->name('quote.email.send');
});
