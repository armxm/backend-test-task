<?php

declare(strict_types=1);


namespace App\Adapter;

use App\Service\PaymentProcessorInterface;
use Systemeio\TestForCandidates\PaymentProcessor\PaypalPaymentProcessor;

readonly class PaypalPaymentAdapter implements PaymentProcessorInterface
{
    public function __construct(
        private PaypalPaymentProcessor $paymentProcessor,
    ) {
    }

    public function pay(float $price): bool
    {
        try {
            $this->paymentProcessor->pay((int)$price * 100);
            return true;
        } catch (\Exception) {
            return false;
        }
    }
}