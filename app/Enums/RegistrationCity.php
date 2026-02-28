<?php

namespace App\Enums;

enum RegistrationCity: string
{
    case ITAQUAQUECETUBA = 'Itaquaquecetuba';
    case SUZANO = 'Suzano';
    case ARUJA = 'Aruja';

    public static function all(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $city) => [$city->value => $city->label()])
            ->toArray();
    }

    public function label(): string
    {
        return match ($this) {
            self::ITAQUAQUECETUBA => 'Itaquaquecetuba',
            self::SUZANO => 'Suzano',
            self::ARUJA => 'Aruja',
        };
    }
}
