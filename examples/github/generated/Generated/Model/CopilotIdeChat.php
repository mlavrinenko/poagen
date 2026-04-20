<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class CopilotIdeChat
{
    /**
     * @param ?list<array<string, mixed>> $editors
     */
    public function __construct(
        public ?array $editors = null,
        public ?int $total_engaged_users = null,
    ) {
    }
}
