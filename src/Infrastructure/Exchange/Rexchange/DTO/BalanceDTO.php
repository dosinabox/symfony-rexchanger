<?php

namespace App\Infrastructure\Exchange\Rexchange\DTO;

readonly class BalanceDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public string $balance,
        public string $createDate,
        public string $webhookURL
    ) {
    }
}
