<?php

declare(strict_types=1);


namespace App\Adapter;

use App\Service\PaymentProcessorInterface;
use Systemeio\TestForCandidates\PaymentProcessor\StripePaymentProcessor;

class StripePaymentAdapter implements PaymentProcessorInterface
{
    public function pay(float $amount): void
    {
        $stripePaymentProcessor = new StripePaymentProcessor();
        if (!$stripePaymentProcessor->processPayment($amount)) {
            throw new \Exception('Stripe payment failed');
        }
    }
}