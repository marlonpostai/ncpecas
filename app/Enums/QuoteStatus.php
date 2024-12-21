<?php

namespace App\Enums;

enum QuoteStatus: string
{
    case AGUARDANDO_APROVACAO = 'aguardando_ap';
    case APROVADO = 'aprovado';
    case REJEITADO = 'rejeitado';
    case ENTREGUE = 'entregue';

    public function label(): string
    {
        return match ($this) {
            self::AGUARDANDO_APROVACAO => 'aguardando_ap',
            self::APROVADO => 'aprovado',
            self::REJEITADO => 'aprovado',
            self::ENTREGUE => 'entregue',
        };
    }
}
