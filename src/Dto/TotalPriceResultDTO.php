<?php

declare(strict_types=1);


namespace App\Dto;

use App\Entity\Coupon;
use App\Entity\Product;

class TotalPriceResultDTO
{
    public function __construct(
        public float $price,
        public Product $product,
        public Coupon $coupon,
    ) {
    }
}