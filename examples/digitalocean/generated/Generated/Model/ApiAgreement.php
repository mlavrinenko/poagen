<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ApiAgreement implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'description' => ['description', null],
        'name' => ['name', null],
        'url' => ['url', null],
        'uuid' => ['uuid', null],
    ];

    public function __construct(
        public ?string $description = null,
        public ?string $name = null,
        public ?string $url = null,
        public ?string $uuid = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'description' => $this->description,
            'name' => $this->name,
            'url' => $this->url,
            'uuid' => $this->uuid,
        ];
    }
}
