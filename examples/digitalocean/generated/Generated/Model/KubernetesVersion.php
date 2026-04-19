<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class KubernetesVersion implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'kubernetes_version' => ['kubernetes_version', null],
        'slug' => ['slug', null],
        'supported_features' => ['supported_features', ['list', null]],
    ];

    /**
     * @param ?list<string> $supported_features
     */
    public function __construct(
        public ?string $kubernetes_version = null,
        public ?string $slug = null,
        public ?array $supported_features = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'kubernetes_version' => $this->kubernetes_version,
            'slug' => $this->slug,
            'supported_features' => $this->supported_features,
        ];
    }
}
