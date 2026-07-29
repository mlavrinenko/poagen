<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated\Model;

final readonly class GetClientCardsResponse
{
    /**
     * @param ?list<\Acme\Kilbil\Generated\Model\GetClientCardsResponseCardsItem> $cards
     */
    public function __construct(
        public string $result_code,
        public ?array $cards = null,
    ) {
    }
}
