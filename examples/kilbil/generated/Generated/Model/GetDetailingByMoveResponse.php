<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated\Model;

final readonly class GetDetailingByMoveResponse
{
    /**
     * @param ?list<\Acme\Kilbil\Generated\Model\GetDetailingByMoveResponseMoveDetailItem> $move_detail
     */
    public function __construct(
        public string $result_code,
        public string $result_text,
        public ?array $move_detail = null,
        public ?GetDetailingByMoveResponseMoveInfo $move_info = null,
    ) {
    }
}
