<?php

namespace App\Controller;

use App\Repository\AircraftRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class TestController
{
    #[Route(
        path: '/test',
        name: 'test_',
        methods: [Request::METHOD_GET]
    )]
    public function test(NormalizerInterface $normalizer, AircraftRepository $aircraftRepository): JsonResponse
    {
        return new JsonResponse(
            $normalizer->normalize(
                $aircraftRepository->findAll(),
                'array'
            )
        );
    }
}
