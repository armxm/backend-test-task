<?php

declare(strict_types=1);


namespace App\Service;

use App\Dto\PurchaseDto;
use App\Entity\Purchase;
use App\Factory\PaymentProcessorFactoryInterface;
use Doctrine\ORM\EntityManagerInterface;

readonly class PurchaseService
{
    public function __construct(
        private PriceCalculator $priceCalculator,
        private EntityManagerInterface $entityManager,
        private PaymentProcessorFactoryInterface $paymentProcessorFactory,
    ) {
    }

    public function purchase(PurchaseDto $dto): bool
    {
        $totalPriceDto = $this->priceCalculator->calculate($dto);
        $paymentProcessor = $this->paymentProcessorFactory->create($dto->paymentProcessor);

        if (!$paymentProcessor->pay($totalPriceDto->price)) {
            return false;
        }

        $purchase = new Purchase(
            $totalPriceDto->product,
            $totalPriceDto->coupon,
            $totalPriceDto->price,
        );

        $this->entityManager->persist($purchase);
        $this->entityManager->flush();

        return true;
    }
}