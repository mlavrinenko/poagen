<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class StatusCheckPolicy
{
    /**
     * @param list<array<string, mixed>> $checks
     * @param list<string> $contexts
     */
    public function __construct(
        public array $checks,
        public array $contexts,
        public string $contexts_url,
        public bool $strict,
        public string $url,
    ) {
    }
}
