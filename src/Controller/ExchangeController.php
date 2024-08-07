<?php

namespace App\Controller;

use App\Domain\Exchange\ExchangeProviderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExchangeController extends AbstractController
{
    public function __construct(private readonly ExchangeProviderInterface $provider)
    {
    }

    #[Route(path: '/tools_in', name: 'toolsIn')]
    public function getToolsIn(): JsonResponse
    {
        try {
            $data = $this->provider->getToolsIn();
        } catch (\Throwable $exception) {
            $error = $exception->getMessage();
            $status = $exception->getCode();
        }

        return new JsonResponse([
            'data' => $data ?? [],
            'error' => $error ?? null,
        ], $status ?? Response::HTTP_OK);
    }

    #[Route(path: '/tools_out', name: 'toolsOut')]
    public function getToolsOut(): JsonResponse
    {
        try {
            $data = $this->provider->getToolsOut();
        } catch (\Throwable $exception) {
            $error = $exception->getMessage();
            $status = $exception->getCode();
        }

        return new JsonResponse([
            'data' => $data ?? [],
            'error' => $error ?? null,
        ], $status ?? Response::HTTP_OK);
    }
}
