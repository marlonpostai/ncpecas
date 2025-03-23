<?php

namespace App\Enums;

enum QuoteStatus: string
{
    case AGUARDANDO_APROVACAO = 'aguardando_ap';
    case APROVADO = 'aprovado';
    case REJEITADO = 'rejeitado';
    case ENTREGUE = 'entregue';

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::APROVADO => 'success',
            self::AGUARDANDO_APROVACAO => 'warning',
            self::REJEITADO => 'danger',
            self::ENTREGUE => 'info',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::APROVADO => 'heroicon-c-check-circle',
            self::AGUARDANDO_APROVACAO => 'heroicon-c-clock',
            self::REJEITADO => 'heroicon-c-x-circle',
            self::ENTREGUE => 'heroicon-c-cube',
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::AGUARDANDO_APROVACAO => 'AGUARDANDO',
            self::APROVADO => 'aprovado',
            self::REJEITADO => 'aprovado',
            self::ENTREGUE => 'entregue',
        };
    }
}
