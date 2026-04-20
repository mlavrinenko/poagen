<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AppsCorsPolicy
{
    /**
     * @param ?list<string> $allow_headers
     * @param ?list<string> $allow_methods
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AppsStringMatch> $allow_origins
     * @param ?list<string> $expose_headers
     */
    public function __construct(
        public ?bool $allow_credentials = null,
        public ?array $allow_headers = null,
        public ?array $allow_methods = null,
        public ?array $allow_origins = null,
        public ?array $expose_headers = null,
        public ?string $max_age = null,
    ) {
    }
}
