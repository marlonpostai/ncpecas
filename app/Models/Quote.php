<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\QuoteStatus;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quote extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'quote_number',
        'creation_date',
        'client_id',
        'user_id',
        'total_amount',
        'product_service_id',
        'status',
        'expected_payment_date',
        'payment_received',
    ];

    protected $casts = [
        'status' => QuoteStatus::class,
        'expected_payment_date' => 'date',
        'payment_received' => 'boolean',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function productService()
    {
        return $this->belongsTo(ProductService::class);
    }

    public function quoteItems()
    {
        return $this->hasMany(QuoteItem::class);
    }

    public static function generateQuoteNumber(): string
    {
        $year = now()->format('Y');
        $lastQuote = static::withTrashed()
            ->whereYear('creation_date', $year)
            ->latest('id')
            ->value('quote_number');

        $nextNumber = $lastQuote ? (int)explode('-', $lastQuote)[0] + 1 : 1;

        return str_pad($nextNumber, 4, '0', STR_PAD_LEFT) . '-' . $year;
    }

    // Evento para gerar o quote_number automaticamente e calcular o total_amount
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($quote) {
            if (empty($quote->quote_number)) {
                $quote->quote_number = self::generateQuoteNumber();
            }

            // Define um valor padrão para o total_amount caso esteja vazio
            $quote->total_amount = $quote->total_amount ?? 0.00;
        });

        static::saving(function ($quote) {
            // Calcula o total_amount com base nos itens relacionados
            $quote->total_amount = $quote->quoteItems->sum(function ($item) {
                return $item->quantity * $item->unit_price;
            });
        });
    }
}
