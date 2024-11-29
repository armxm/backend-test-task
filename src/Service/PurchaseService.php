<?php

declare(strict_types=1);


namespace App\Service;

use App\Dto\PurchaseDto;
use App\Entity\Purchase;
use App\Factory\PaymentProcessorFactory;
use Doctrine\ORM\EntityManagerInterface;

readonly class PurchaseService
{
    public function __construct(
        private PriceCalculator $priceCalculator,
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function purchase(PurchaseDto $dto): void
    {
        $totalPriceDto = $this->priceCalculator->calculate($dto);
        $paymentProcessor = PaymentProcessorFactory::create($dto->paymentProcessor);
        $paymentProcessor->pay($totalPriceDto->price);

        $purchase = new Purchase(
            $totalPriceDto->product,
            $totalPriceDto->coupon,
            $totalPriceDto->price,
        );

        $this->entityManager->persist($purchase);
        $this->entityManager->flush();
    }
}