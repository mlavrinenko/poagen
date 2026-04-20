<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class ValidationErrorSimple
{
    /**
     * @param ?list<string> $errors
     */
    public function __construct(
        public string $documentation_url,
        public string $message,
        public ?array $errors = null,
    ) {
    }
}
