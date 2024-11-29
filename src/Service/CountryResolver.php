<?php

declare(strict_types=1);


namespace App\Service;

use App\Enum\Country;

class CountryResolver
{
    public function findCountryByTaxNumber(string $taxNumber): ?Country
    {
        $patterns = [
            Country::GERMANY->value => '/^DE\d{9}$/',
            Country::ITALY->value => '/^IT\d{11}$/',
            Country::GREECE->value => '/^GR\d{9}$/',
            Country::FRANCE->value => '/^FR[A-Z]{2}\d{9}$/',
        ];

        foreach ($patterns as $code => $pattern) {
            if (preg_match($pattern, $taxNumber)) {
                return Country::from($code);
            }
        }

        return null;
    }
}