<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class ScimError
{
    /**
     * @param ?list<string> $schemas
     */
    public function __construct(
        public ?string $detail = null,
        public ?string $documentation_url = null,
        public ?string $message = null,
        public ?array $schemas = null,
        public ?string $scimType = null,
        public ?int $status = null,
    ) {
    }
}
