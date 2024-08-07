<?php

namespace App\Domain\Exchange;

interface ExchangeProviderInterface
{
    public function getApiUrl(): string;

    public function getApiKey(): string;

    public function getToolsIn(): mixed;

    public function getToolsOut(): mixed;
}
