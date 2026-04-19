<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ApiChatbot implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'allowed_domains' => ['allowed_domains', ['list', null]],
        'button_background_color' => ['button_background_color', null],
        'logo' => ['logo', null],
        'name' => ['name', null],
        'primary_color' => ['primary_color', null],
        'secondary_color' => ['secondary_color', null],
        'starting_message' => ['starting_message', null],
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'allowed_domains' => $this->allowed_domains,
            'button_background_color' => $this->button_background_color,
            'logo' => $this->logo,
            'name' => $this->name,
            'primary_color' => $this->primary_color,
            'secondary_color' => $this->secondary_color,
            'starting_message' => $this->starting_message,
        ];
    }
}
