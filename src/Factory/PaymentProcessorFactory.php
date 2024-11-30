<?php

declare(strict_types=1);


namespace App\Factory;

use App\Adapter\PaypalPaymentAdapter;
use App\Adapter\StripePaymentAdapter;
use App\Enum\ProcessorType;
use App\Service\PaymentProcessorInterface;
use Systemeio\TestForCandidates\PaymentProcessor\PaypalPaymentProcessor;
use Systemeio\TestForCandidates\PaymentProcessor\StripePaymentProcessor;

readonly class PaymentProcessorFactory implements PaymentProcessorFactoryInterface
{
    public function __construct(
        private PaypalPaymentProcessor $paypalPaymentProcessor,
        private StripePaymentProcessor $stripePaymentProcessor,
    ) {
    }

    public function create(ProcessorType $processorType): PaymentProcessorInterface
    {
        return match ($processorType) {
            ProcessorType::PAYPAL => new PaypalPaymentAdapter($this->paypalPaymentProcessor),
            ProcessorType::STRIPE => new StripePaymentAdapter($this->stripePaymentProcessor),
        };
    }
}