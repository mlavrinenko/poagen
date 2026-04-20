<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class CopilotDotcomChat
{
    /**
     * @param ?list<array<string, mixed>> $models
     */
    public function __construct(
        public ?array $models = null,
        public ?int $total_engaged_users = null,
    ) {
    }
}
