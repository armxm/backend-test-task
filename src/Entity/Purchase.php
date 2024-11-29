<?php

declare(strict_types=1);


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;

#[ORM\Entity]
class Purchase
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\ManyToOne(targetEntity: Product::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Product $product;

    #[ORM\ManyToOne(targetEntity: Coupon::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Coupon $coupon;

    #[ORM\Column(type: 'float')]
    private float $price;

    #[ORM\Column(type: 'datetime')]
    private DateTimeImmutable $createdAt;

    public function __construct(
        Product $product,
        Coupon $coupon,
        float $price,
    ) {
        $this->product = $product;
        $this->coupon = $coupon;
        $this->price = $price;
        $this->createdAt = new DateTimeImmutable();
    }
}