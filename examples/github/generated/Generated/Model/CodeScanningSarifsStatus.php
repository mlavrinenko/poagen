<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class CodeScanningSarifsStatus
{
    /**
     * @param ?list<string> $errors
     */
    public function __construct(
        public ?string $analyses_url = null,
        public ?array $errors = null,
        public ?string $processing_status = null,
    ) {
    }
}
