<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class ProtectedBranchRequiredStatusCheck
{
    /**
     * @param list<array<string, mixed>> $checks
     * @param list<string> $contexts
     */
    public function __construct(
        public array $checks,
        public array $contexts,
        public ?string $contexts_url = null,
        public ?string $enforcement_level = null,
        public ?bool $strict = null,
        public ?string $url = null,
    ) {
    }
}
