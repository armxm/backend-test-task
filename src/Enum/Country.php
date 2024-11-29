<?php

declare(strict_types=1);


namespace App\Enum;

enum Country: string
{
    case GERMANY = 'DE';
    case ITALY = 'IT';
    case GREECE = 'GR';
    case FRANCE = 'FR';

    public function getTaxRate(): float
    {
        return match ($this) {
            self::GERMANY => 19,
            self::ITALY => 22,
            self::FRANCE => 20,
            self::GREECE => 24,
        };
    }
}