<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TestController
{
    #[Route(
        path: '/test',
        name: 'test_',
        methods: [Request::METHOD_GET]
    )]
    public function test(): JsonResponse
    {
        return new JsonResponse('hola');
    }
}
