<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class TagsMetadata implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = ['count' => ['count', null], 'last_tagged_uri' => ['last_tagged_uri', null]];

    public function __construct(
        public ?int $count = null,
        public ?string $last_tagged_uri = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'count' => $this->count,
            'last_tagged_uri' => $this->last_tagged_uri,
        ];
    }
}
