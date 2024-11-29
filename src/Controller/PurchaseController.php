<?php

declare(strict_types=1);


namespace App\Controller;

use App\Dto\PurchaseDTO;
use App\Service\PurchaseService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class PurchaseController extends BaseController
{
    #[Route('/purchase', name: 'purchase', methods: ['POST'])]
    public function purchase(Request $request, PurchaseService $service): JsonResponse
    {
        try {
            $dto = $this->deserialize($request->getContent(), PurchaseDTO::class);
            $errors = $this->validate($dto);

            if ($errors) {
                return $this->error($errors);
            }

            $service->purchase($dto);

            return $this->success();
        } catch (\Exception $e) {
            return $this->error([$e->getMessage()]);
        }
    }
}