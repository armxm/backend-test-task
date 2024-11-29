<?php

declare(strict_types=1);


namespace App\Controller;

use App\Dto\CalculatePriceDto;
use App\Service\PriceCalculator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;

class PriceController extends AbstractController
{
    #[Route('/calculate-price', name: 'calculate_price', methods: ['POST'])]
    public function calculatePrice(
        #[MapRequestPayload] CalculatePriceDto $dto,
        PriceCalculator $calculator,
    ): JsonResponse {
        return $this->json([
            'success' => true,
            'data' => [
                'price' => $calculator->calculate($dto)->price,
            ]
        ]);
    }
}