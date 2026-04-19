<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class KubernetesNodePoolTaint implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = ['effect' => ['effect', null], 'key' => ['key', null], 'value' => ['value', null]];

    public function __construct(
        public ?string $effect = null,
        public ?string $key = null,
        public ?string $value = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'effect' => $this->effect,
            'key' => $this->key,
            'value' => $this->value,
        ];
    }
}
