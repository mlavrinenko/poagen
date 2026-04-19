<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class AuthorizationApp implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = ['client_id' => ['client_id', null], 'name' => ['name', null], 'url' => ['url', null]];

    public function __construct(
        public string $client_id,
        public string $name,
        public string $url,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'client_id' => $this->client_id,
            'name' => $this->name,
            'url' => $this->url,
        ];
    }
}
