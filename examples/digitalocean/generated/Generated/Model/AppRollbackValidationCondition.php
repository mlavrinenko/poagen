<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AppRollbackValidationCondition
{
    /**
     * @param ?list<string> $components
     */
    public function __construct(
        public ?string $code = null,
        public ?array $components = null,
        public ?string $message = null,
    ) {
    }
}
