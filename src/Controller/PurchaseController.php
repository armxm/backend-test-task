<?php

declare(strict_types=1);


namespace App\Controller;

use App\Dto\PurchaseDto;
use App\Service\PurchaseService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;

class PurchaseController extends AbstractController
{
    #[Route('/purchase', name: 'purchase', methods: ['POST'])]
    public function purchase(
        #[MapRequestPayload] PurchaseDto $dto,
        PurchaseService $service,
    ): JsonResponse {
        $service->purchase($dto);
        return $this->json(['success' => true, 'data' => []]);
    }
}