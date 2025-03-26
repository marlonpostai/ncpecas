<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteItem extends Model
{
    use HasFactory;

    protected $fillable = [
            'product_service_id',
            'description',
            'quantity',
            'unit_price',
            'total_price',
            'apply_discount',
            'item_discount_percent',
            'total_with_discount',
    ];


    protected $casts = [
        'quantity' => 'float',
        'unit_price' => 'float',
        'total_price' => 'float',
    ];

    public function quote()
    {
        return $this->belongsTo(Quote::class);
    }

    public function productService()
    {
        return $this->belongsTo(ProductService::class);
    }

    public function quoteItems()
    {
        return $this->hasMany(QuoteItem::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($quoteItem) {
            $product = ProductService::find($quoteItem->product_service_id);
            if ($product) {
                $quoteItem->unit_price = $quoteItem->unit_price ?? $product->price;
                $quoteItem->description = $quoteItem->description ?? $product->description;
            }
        });
    }

    public function getTotalPriceAttribute(): float
    {
        return ($this->attributes['quantity'] ?? 0) * ($this->attributes['unit_price'] ?? 0);
    }

}
