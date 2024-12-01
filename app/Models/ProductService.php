<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductService extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',        // Nome do produto/serviço
        'description', // Descrição do produto/serviço
        'reference',
        'price',       // Preço do produto/serviço
        'sku',
        'image_one',
        'image_two',
    ];
}
