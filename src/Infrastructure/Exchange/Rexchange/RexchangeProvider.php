<?php

namespace App\Infrastructure\Exchange\Rexchange;

use App\Domain\Exchange\Exception\ForbiddenException;
use App\Domain\Exchange\Exception\ServiceUnavailableException;
use App\Domain\Exchange\Exception\UnauthorizedException;
use App\Domain\Exchange\ExchangeProviderInterface;
use App\Infrastructure\Exchange\CommonExchangeProviderTrait;
use App\Infrastructure\Exchange\Rexchange\DTO\BalanceDTO;
use App\Infrastructure\Exchange\Rexchange\DTO\ToolDTO;
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
    public function getToolsIn(): array
    {
        $content = $this->getContent($this->getApiUrl() . 'tools_in');

        return $this->getTools($content);
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
    public function getToolsOut(): array
    {
        $content = $this->getContent($this->getApiUrl() . 'tools_out');

        return $this->getTools($content);
    }

    /**
     * @return int
     * @throws ClientExceptionInterface
     * @throws ForbiddenException
     * @throws JsonException
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws ServiceUnavailableException
     * @throws TransportExceptionInterface
     * @throws UnauthorizedException
     */
    public function getBalance(): BalanceDTO
    {
        $content = $this->getContent($this->getApiUrl() . 'me');

        return new BalanceDTO(
            id: $content['merchant']['id'],
            name: $content['merchant']['name'],
            balance: $content['merchant']['balance'],
            createDate: $content['merchant']['create_date'],
            webhookUrl: $content['merchant']['webhook_url']
        );
    }

    private function getTools(array $content): array
    {
        $tools = [];

        foreach ($content['tools'] as $tool) {
            $tools[] = new ToolDTO(
                id: $tool['id'],
                name: $tool['name'],
                minPayment: $tool['min_payment'],
                maxPayment: $tool['max_payment'],
                currency: $tool['currency'],
                network: $tool['network'],
                roundedStr: $tool['rounded_str'],
                costInUSDT: $tool['cost_in_usdt'],
                isFiat: $tool['is_fiat']
            );
        }

        return $tools;
    }
}
