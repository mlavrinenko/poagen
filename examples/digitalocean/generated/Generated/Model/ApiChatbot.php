<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ApiChatbot
{
    /**
     * @param ?list<string> $allowed_domains
     */
    public function __construct(
        public ?array $allowed_domains = null,
        public ?string $button_background_color = null,
        public ?string $logo = null,
        public ?string $name = null,
        public ?string $primary_color = null,
        public ?string $secondary_color = null,
        public ?string $starting_message = null,
    ) {
    }
}
