<?php

namespace App\Infrastructure\Exchange;

use App\Domain\Exchange\Exception\ServiceUnavailableException;
use App\Domain\Exchange\Exception\UnauthorizedException;
use JsonException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

trait CommonExchangeProviderTrait
{
    public function __construct(protected readonly HttpClientInterface $client)
    {
    }

    /**
     * @param string $url
     * @return mixed
     * @throws ClientExceptionInterface
     * @throws JsonException
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws ServiceUnavailableException
     * @throws TransportExceptionInterface
     * @throws UnauthorizedException
     */
    public function getContent(string $url): mixed
    {
        $response = $this->client->request('GET', $url);
        $code = $response->getStatusCode();

        if ($code === Response::HTTP_SERVICE_UNAVAILABLE) {
            throw new ServiceUnavailableException();
        }

        if ($code === Response::HTTP_UNAUTHORIZED || $code === Response::HTTP_FORBIDDEN) {
            throw new UnauthorizedException();
        }

        return json_decode(
            $response->getContent(),
            associative: true,
            depth: 512,
            flags: JSON_THROW_ON_ERROR
        );
    }
}
