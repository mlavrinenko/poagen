<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated\Model;

final readonly class GetSalesIndicesSlidesResponse
{
    /**
     * @param list<string> $slides
     */
    public function __construct(
        public ?string $info,
        public int $result_code,
        public array $slides,
    ) {
    }
}
