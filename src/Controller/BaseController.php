<?php

declare(strict_types=1);


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class BaseController extends AbstractController
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly ValidatorInterface $validator,
    ) {
    }

    protected function deserialize(mixed $data, string $type, $format = 'json'): mixed
    {
        if (empty($data)) {
            throw new BadRequestHttpException('Request data is empty');
        }

        return $this->serializer->deserialize($data, $type, $format);
    }

    protected function validate(mixed $dto): array
    {
        $errorMessages = [];
        $errors = $this->validator->validate($dto);

        if (count($errors) > 0) {
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }
        }

        return $errorMessages;
    }
}