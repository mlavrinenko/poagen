<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated\Model;

final readonly class GetClientTagsResponse
{
    /**
     * @param list<int> $data
     */
    public function __construct(
        public array $data,
        public string $result_code,
        public ?string $result_text = null,
    ) {
    }
}
