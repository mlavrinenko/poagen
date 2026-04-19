<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class SimpleCommitStatus implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'avatar_url' => ['avatar_url', null],
        'context' => ['context', null],
        'created_at' => ['created_at', ['datetime', null]],
        'description' => ['description', null],
        'id' => ['id', null],
        'node_id' => ['node_id', null],
        'state' => ['state', null],
        'target_url' => ['target_url', null],
        'updated_at' => ['updated_at', ['datetime', null]],
        'url' => ['url', null],
        'required' => ['required', null],
    ];

    public function __construct(
        public ?string $avatar_url = null,
        public string $context,
        public DateTimeImmutable $created_at,
        public ?string $description = null,
        public int $id,
        public string $node_id,
        public string $state,
        public ?string $target_url = null,
        public DateTimeImmutable $updated_at,
        public string $url,
        public ?bool $required = null,
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
            'created_at' => $this->created_at->format(\DateTimeInterface::RFC3339),
            'description' => $this->description,
            'id' => $this->id,
            'node_id' => $this->node_id,
            'state' => $this->state,
            'target_url' => $this->target_url,
            'updated_at' => $this->updated_at->format(\DateTimeInterface::RFC3339),
            'url' => $this->url,
            'required' => $this->required,
        ];
    }
}
