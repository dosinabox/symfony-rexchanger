<?php

namespace App\Infrastructure\Exchange\Rexchange;

readonly class ToolsDto
{
    public function __construct(
        public int $id,
        public string $name,
        public string $minPayment,
        public string $maxPayment,
        public string $currency,
        public string $network,
        public string $roundedStr,
        public string $costInUSDT,
        public bool $isFiat,
    ) {
    }
}
