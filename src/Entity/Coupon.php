<?php

declare(strict_types=1);


namespace App\Entity;

use App\Enum\CouponType;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Coupon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', unique: true)]
    private string $code;

    #[ORM\Column(type: 'string', enumType: CouponType::class)]
    private CouponType $type;

    #[ORM\Column(type: "float")]
    private float $value;

    public function getDiscount(float $price): float
    {
        return match ($this->type) {
            CouponType::FIXED => $this->value,
            CouponType::PERCENTAGE => $price * ($this->value / 100),
        };
    }
}