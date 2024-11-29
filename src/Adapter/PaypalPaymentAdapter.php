<?php

declare(strict_types=1);


namespace App\Adapter;

use App\Service\PaymentProcessorInterface;
use Systemeio\TestForCandidates\PaymentProcessor\PaypalPaymentProcessor;

class PaypalPaymentAdapter implements PaymentProcessorInterface
{
    public function pay(float $amount): void
    {
        try {
            $paypalPaymentProcessor = new PaypalPaymentProcessor();
            $paypalPaymentProcessor->pay((int)$amount * 100);

        } catch (\Exception) {
            throw new \Exception('Paypal payment failed');
        }
    }
}