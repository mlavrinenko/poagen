<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class OneClicksCreate implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'addon_slugs' => ['addon_slugs', ['list', null]],
        'cluster_uuid' => ['cluster_uuid', null],
    ];

    /**
     * @param list<string> $addon_slugs
     */
    public function __construct(
        public array $addon_slugs,
        public string $cluster_uuid,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'addon_slugs' => $this->addon_slugs,
            'cluster_uuid' => $this->cluster_uuid,
        ];
    }
}
