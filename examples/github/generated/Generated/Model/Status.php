<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class Status implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'avatar_url' => ['avatar_url', null],
        'context' => ['context', null],
        'created_at' => ['created_at', null],
        'creator' => ['creator', \Acme\GitHub\Generated\Model\NullableSimpleUser::class],
        'description' => ['description', null],
        'id' => ['id', null],
        'node_id' => ['node_id', null],
        'state' => ['state', null],
        'target_url' => ['target_url', null],
        'updated_at' => ['updated_at', null],
        'url' => ['url', null],
    ];

    public function __construct(
        public ?string $avatar_url = null,
        public string $context,
        public string $created_at,
        public NullableSimpleUser $creator,
        public ?string $description = null,
        public int $id,
        public string $node_id,
        public string $state,
        public ?string $target_url = null,
        public string $updated_at,
        public string $url,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'avatar_url' => $this->avatar_url,
            'context' => $this->context,
            'created_at' => $this->created_at,
            'creator' => $this->creator,
            'description' => $this->description,
            'id' => $this->id,
            'node_id' => $this->node_id,
            'state' => $this->state,
            'target_url' => $this->target_url,
            'updated_at' => $this->updated_at,
            'url' => $this->url,
        ];
    }
}
