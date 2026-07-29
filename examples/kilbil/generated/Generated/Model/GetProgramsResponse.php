<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated\Model;

final readonly class GetProgramsResponse
{
    /**
     * @param ?list<\Acme\Kilbil\Generated\Model\GetProgramsResponseDataItem> $data
     */
    public function __construct(
        public string $result_code,
        public ?array $data = null,
    ) {
    }
}
