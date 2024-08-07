<?php

namespace App\Infrastructure\Exchange\Rexchange;

use App\Domain\Exchange\Exception\ServiceUnavailableException;
use App\Domain\Exchange\Exception\UnauthorizedException;
use App\Domain\Exchange\ExchangeProviderInterface;
use App\Infrastructure\Exchange\CommonExchangeProviderTrait;
use JsonException;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

final readonly class RexchangeProvider implements ExchangeProviderInterface
{
    use CommonExchangeProviderTrait;

    public function getApiUrl(): string
    {
        return $_ENV['REXCHANGE_API_URL'];
    }

    public function getApiKey(): string
    {
        return $_ENV['REXCHANGE_API_KEY'];
    }

    /**
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     * @throws JsonException
     * @throws UnauthorizedException
     * @throws TransportExceptionInterface
     * @throws ServiceUnavailableException
     * @throws ServerExceptionInterface
     */
    public function getToolsIn(): mixed
    {
        return $this->getContent($this->getApiUrl() . 'tools_in');
    }

    /**
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     * @throws JsonException
     * @throws UnauthorizedException
     * @throws TransportExceptionInterface
     * @throws ServiceUnavailableException
     * @throws ServerExceptionInterface
     */
    public function getToolsOut(): mixed
    {
        return $this->getContent($this->getApiUrl() . 'tools_out');
    }
}
