<?php

declare(strict_types=1);


namespace App\Factory;

use App\Adapter\PaypalPaymentAdapter;
use App\Adapter\StripePaymentAdapter;
use App\Enum\ProcessorType;
use App\Service\PaymentProcessorInterface;

class PaymentProcessorFactory
{
    public static function create(ProcessorType $processorType): PaymentProcessorInterface
    {
        return match ($processorType) {
            ProcessorType::PAYPAL => new PaypalPaymentAdapter(),
            ProcessorType::STRIPE => new StripePaymentAdapter(),
        };
    }
}