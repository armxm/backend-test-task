<?php

declare(strict_types=1);


namespace App\Service;

use App\Enum\Country;

class CountryResolver
{
    public function findCountryByTaxNumber(string $taxNumber): ?Country
    {
        $countryCode = substr($taxNumber, 0, 2);

        try {
            return Country::from($countryCode);
        } catch (\Exception) {
            return null;
        }
    }
}