<?php

namespace App\Controller;

use App\Domain\Exchange\ExchangeProviderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BalanceController extends AbstractController
{
    public function __construct(private readonly ExchangeProviderInterface $provider)
    {
    }

    #[Route(path: '/balance', name: 'getBalance')]
    public function getBalance(): JsonResponse
    {
        try {
            $balance = $this->provider->getBalance();
        } catch (\Throwable $exception) {
            $error = $exception->getMessage();
            $status = $exception->getCode();
        }

        return new JsonResponse([
            'balance' => $balance ?? null,
            'error' => $error ?? null,
        ], $status ?? Response::HTTP_OK);
    }
}
