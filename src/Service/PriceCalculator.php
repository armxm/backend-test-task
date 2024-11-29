<?php

declare(strict_types=1);


namespace App\Service;

use App\Dto\RequestDtoInterface;
use App\Dto\TotalPriceResultDto;
use App\Repository\CouponRepositoryInterface;
use App\Repository\ProductRepositoryInterface;
use Exception;

readonly class PriceCalculator
{
    public function __construct(
        private ProductRepositoryInterface $productRepository,
        private CouponRepositoryInterface $couponRepository,
        private CountryResolver $countryResolver,
    ) {
    }

    public function calculate(RequestDtoInterface $dto): TotalPriceResultDto
    {
        $product = $this->productRepository->find($dto->getProduct());
        if (!$product) {
            throw new Exception('Product not found');
        }

        $coupon = $this->couponRepository->findOneBy(['code' => $dto->getCouponCode()]);
        if (!$coupon) {
            throw new Exception('Coupon not found');
        }

        $country = $this->countryResolver->findCountryByTaxNumber($dto->getTaxNumber());
        if (!$country) {
            throw new Exception('Country not found');
        }

        $taxAmount = $product->getPrice() * $country->getTaxRate() / 100;
        $priceAfterDiscount = $product->getPrice() - $coupon->getDiscount($product->getPrice());

        return new TotalPriceResultDto(
            $priceAfterDiscount + $taxAmount,
            $product,
            $coupon,
        );
    }
}