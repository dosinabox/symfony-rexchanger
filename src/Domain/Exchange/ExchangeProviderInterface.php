<?php

namespace App\Domain\Exchange;

use App\Infrastructure\Exchange\Rexchange\DTO\BalanceDTO;

interface ExchangeProviderInterface
{
    public function getApiUrl(): string;

    public function getApiKey(): string;

    public function getToolsIn(): array;

    public function getToolsOut(): array;

    public function getBalance(): BalanceDTO;
}
