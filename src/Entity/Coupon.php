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

    public function getId(): int
    {
        return $this->id;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;
        return $this;
    }

    public function getType(): CouponType
    {
        return $this->type;
    }

    public function setType(CouponType $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function setValue(float $value): self
    {
        $this->value = $value;
        return $this;
    }
}