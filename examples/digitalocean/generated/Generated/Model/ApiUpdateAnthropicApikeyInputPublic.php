<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ApiUpdateAnthropicApikeyInputPublic implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'api_key' => ['api_key', null],
        'api_key_uuid' => ['api_key_uuid', null],
        'name' => ['name', null],
    ];

    public function __construct(
        public ?string $api_key = null,
        public ?string $api_key_uuid = null,
        public ?string $name = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'api_key' => $this->api_key,
            'api_key_uuid' => $this->api_key_uuid,
            'name' => $this->name,
        ];
    }
}
