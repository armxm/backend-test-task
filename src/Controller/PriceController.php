<?php

declare(strict_types=1);


namespace App\Controller;

use App\Dto\CalculatePriceDTO;
use App\Service\PriceCalculator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class PriceController extends BaseController
{
    #[Route('/calculate-price', name: 'calculate_price', methods: ['POST'])]
    public function calculatePrice(Request $request, PriceCalculator $calculator): JsonResponse
    {
        try {
            $dto = $this->deserialize($request->getContent(), CalculatePriceDTO::class, 'json');
            $errors = $this->validate($dto);

            if ($errors) {
                return $this->json(['error' => $errors], 400);
            }

            return $this->json(['price' => $calculator->calculate($dto)]);
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()], 400);
        }
    }
}