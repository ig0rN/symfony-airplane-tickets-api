<?php

namespace App\Service;

use App\Exception\ValidationException;
use App\Validator\SysValidator;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

class RequestDTOFactory
{
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly SerializerInterface $serializer,
        private readonly SysValidator $sysValidator,
    ) {
    }

    /**
     * @throws ValidationException
     */
    public function make(Request $request, string $dtoFQCN, array $assocAdditionalData = []): object
    {
        $jsonData = $this->formatJsonData($request, $assocAdditionalData);

        $this->logger->info('Request data', [
            'data' => json_decode($jsonData, true),
        ]);

        $dto = $this->serializer->deserialize($jsonData, $dtoFQCN, 'json');

        $this->sysValidator->validate($dto);

        return $dto;
    }

    private function formatJsonData(Request $request, array $assocAdditionalData): string
    {
        if (!$this->isAssoc($assocAdditionalData)) {
            return $request->getContent();
        }

        $requestData = json_decode($request->getContent(), true);

        $newData = array_merge($requestData, $assocAdditionalData);

        return json_encode($newData);
    }

    private function isAssoc(array $assocAdditionalData): bool
    {
        if ([] === $assocAdditionalData) {
            return false;
        }

        return array_keys($assocAdditionalData) !== range(0, count($assocAdditionalData) - 1);
    }
}
