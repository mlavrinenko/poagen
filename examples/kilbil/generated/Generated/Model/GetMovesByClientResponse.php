<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated\Model;

final readonly class GetMovesByClientResponse
{
    /**
     * @param ?list<GetMovesByClientResponseClientMovesItem> $client_moves
     */
    public function __construct(
        public string $result_code,
        public ?array $client_moves = null,
    ) {
    }
}
