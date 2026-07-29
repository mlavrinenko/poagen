<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated\Model;

final readonly class DeleteClientTagsRequest
{
    /**
     * @param list<int> $tags
     */
    public function __construct(
        public int $client_id,
        public array $tags,
    ) {
    }
}
