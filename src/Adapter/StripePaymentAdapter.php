<?php

declare(strict_types=1);


namespace App\Adapter;

use App\Service\PaymentProcessorInterface;
use Systemeio\TestForCandidates\PaymentProcessor\StripePaymentProcessor;

class StripePaymentAdapter implements PaymentProcessorInterface
{
    public function pay(float $amount): bool
    {
        try {
            $stripePaymentProcessor = new StripePaymentProcessor();

            return $stripePaymentProcessor->processPayment($amount);
        } catch (\Throwable) {
            throw new \Exception('Stripe payment failed');
        }
    }
}