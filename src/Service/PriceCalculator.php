<?php

declare(strict_types=1);


namespace App\Service;

use App\Dto\CalculatePriceDTO;
use App\Repository\CouponRepository;
use App\Repository\ProductRepository;
use Exception;

readonly class PriceCalculator
{
    public function __construct(
        private ProductRepository $productRepository,
        private CouponRepository $couponRepository,
        private CountryResolver $countryResolver,
    ) {
    }

    public function calculate(CalculatePriceDTO $dto): float
    {
        $product = $this->productRepository->find($dto->product);
        if (!$product) {
            throw new Exception('Product not found');
        }

        $coupon = $this->couponRepository->findOneBy(['code' => $dto->couponCode]);
        if (!$coupon) {
            throw new Exception('Coupon not found');
        }

        $country = $this->countryResolver->findCountryByTaxNumber($dto->taxNumber);
        if (!$country) {
            throw new Exception('Country not found');
        }

        $taxAmount = $product->getPrice() * $country->getTaxRate() / 100;
        $priceAfterDiscount = $product->getPrice() - $coupon->getDiscount($product->getPrice());

        return $priceAfterDiscount + $taxAmount;
    }
}