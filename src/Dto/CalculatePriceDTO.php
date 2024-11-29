<?php

declare(strict_types=1);


namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class CalculatePriceDTO
{
    public function __construct(
        #[Assert\NotNull(message: "Product ID is required.")]
        #[Assert\Type(type: 'integer', message: "Product ID must be an integer.")]
        public int $product,

        #[Assert\NotBlank(message: "Tax number is required.")]
        #[Assert\Regex(
            pattern: "/^[A-Z]{2}[0-9]{9}$/",
            message: "Invalid tax number format."
        )]
        public string $taxNumber,

        #[Assert\NotBlank(message: "Coupon code is required.")]
        public string $couponCode,
    ) {
    }
}