<?php

declare(strict_types=1);


namespace App\Adapter;

use App\Service\PaymentProcessorInterface;
use Systemeio\TestForCandidates\PaymentProcessor\StripePaymentProcessor;

readonly class StripePaymentAdapter implements PaymentProcessorInterface
{
    public function __construct(
        private StripePaymentProcessor $stripePaymentProcessor,
    ) {
    }

    public function pay(float $price): bool
    {
        try {
            return $this->stripePaymentProcessor->processPayment($price);
        } catch (\Exception) {
            return false;
        }
    }
}