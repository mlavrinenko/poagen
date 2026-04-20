<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ErrorWithRootCauses
{
    /**
     * @param list<string> $root_causes
     * @param ?list<string> $messages
     */
    public function __construct(
        public string $error,
        public array $root_causes,
        public ?array $messages = null,
    ) {
    }
}
