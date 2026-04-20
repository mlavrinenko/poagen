<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class CopilotIdeCodeCompletions
{
    /**
     * @param ?list<array<string, mixed>> $editors
     * @param ?list<array<string, mixed>> $languages
     */
    public function __construct(
        public ?array $editors = null,
        public ?array $languages = null,
        public ?int $total_engaged_users = null,
    ) {
    }
}
