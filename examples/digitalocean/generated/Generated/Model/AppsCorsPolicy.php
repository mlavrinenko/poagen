<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class AppsCorsPolicy implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'allow_credentials' => ['allow_credentials', null],
        'allow_headers' => ['allow_headers', ['list', null]],
        'allow_methods' => ['allow_methods', ['list', null]],
        'allow_origins' => ['allow_origins', ['list', \Acme\DigitalOcean\Generated\Model\AppsStringMatch::class]],
        'expose_headers' => ['expose_headers', ['list', null]],
        'max_age' => ['max_age', null],
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'allow_credentials' => $this->allow_credentials,
            'allow_headers' => $this->allow_headers,
            'allow_methods' => $this->allow_methods,
            'allow_origins' => $this->allow_origins,
            'expose_headers' => $this->expose_headers,
            'max_age' => $this->max_age,
        ];
    }
}
