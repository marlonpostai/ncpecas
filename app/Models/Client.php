<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',       // Nome do cliente
        'address',    // Endereço do cliente
        'phone',      // Telefone do cliente
        'email',
        'cnpj' // Email do cliente
    ];

    protected $attributes = [
            'cnpj' => '',
        ];

    // Definindo relacionamento com o modelo Quote
    public function quotes()
    {
        return $this->hasMany(Quote::class);
    }
}
