<?php

namespace App\Infrastructure\Exchange\Rexchange;

use App\Domain\Exchange\Exception\ForbiddenException;
use App\Domain\Exchange\Exception\InvalidResponseException;
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
     * @throws ForbiddenException
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
     * @throws ForbiddenException
     */
    public function getToolsOut(): mixed
    {
        return $this->getContent($this->getApiUrl() . 'tools_out');
    }

    /**
     * @return int
     * @throws ClientExceptionInterface
     * @throws ForbiddenException
     * @throws InvalidResponseException
     * @throws JsonException
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws ServiceUnavailableException
     * @throws TransportExceptionInterface
     * @throws UnauthorizedException
     */
    public function getBalance(): int
    {
        $content = $this->getContent($this->getApiUrl() . 'me');

        if (!array_key_exists('merchant', $content)) {
            throw new InvalidResponseException();
        }

        $merchant = $content['merchant'];

        if (!array_key_exists('balance', $merchant)) {
            throw new InvalidResponseException();
        }

        return $merchant['balance'];
    }
}
