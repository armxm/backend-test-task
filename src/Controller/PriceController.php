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
            $dto = $this->deserialize($request->getContent(), CalculatePriceDTO::class);
            $errors = $this->validate($dto);

            if ($errors) {
                return $this->error($errors);
            }

            return $this->success(['price' => $calculator->calculate($dto)->price]);
        } catch (\Exception $e) {
            return $this->error([$e->getMessage()]);
        }
    }
}