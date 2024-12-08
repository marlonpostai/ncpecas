<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quote extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'quote_number',
        'product_service_id',
        'quantity',
        'unit_price',
        'creation_date',
        'client_id',
        'user_id',
        'total_amount',
    ];

    /**
     * Método responsável por gerar o número único do orçamento.
     *
     * @return string
     */
    public static function generateQuoteNumber(): string
    {
        $year = now()->format('Y');

        // Busca o último número de orçamento, incluindo soft deletes
        $lastQuote = static::withTrashed()
            ->whereYear('creation_date', $year)
            ->latest('id')
            ->value('quote_number');

        // Calcula o próximo número
        $nextNumber = $lastQuote ? (int)explode('-', $lastQuote)[0] + 1 : 1;

        return str_pad($nextNumber, 4, '0', STR_PAD_LEFT) . '-' . $year;
    }

    /**
     * Calcula o valor total do orçamento.
     *
     * @return void
     */
    public function calculateTotalAmount(): void
    {
        $this->total_amount = $this->quantity * $this->unit_price;
    }

    /**
     * Evento para garantir que os dados sejam gerados corretamente antes de salvar.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($quote) {
            // Gera o número do orçamento automaticamente
            if (empty($quote->quote_number)) {
                $quote->quote_number = static::generateQuoteNumber();
            }
        });

        static::saving(function ($quote) {
            // Preenche o preço unitário automaticamente se não for preenchido
            if (empty($quote->unit_price) && $quote->product_service_id) {
                $product = \App\Models\ProductService::find($quote->product_service_id);
                if ($product) {
                    $quote->unit_price = $product->price;
                }
            }

            // Calcula o valor total
            $quote->calculateTotalAmount();
        });
    }

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
}
