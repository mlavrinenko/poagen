<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class CustomDeploymentRuleApp implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'id' => ['id', null],
        'integration_url' => ['integration_url', null],
        'node_id' => ['node_id', null],
        'slug' => ['slug', null],
    ];

    public function __construct(
        public int $id,
        public string $integration_url,
        public string $node_id,
        public string $slug,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'integration_url' => $this->integration_url,
            'node_id' => $this->node_id,
            'slug' => $this->slug,
        ];
    }
}
