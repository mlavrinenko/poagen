<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class SimpleClassroomRepository implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'default_branch' => ['default_branch', null],
        'full_name' => ['full_name', null],
        'html_url' => ['html_url', null],
        'id' => ['id', null],
        'node_id' => ['node_id', null],
        'private' => ['private', null],
    ];

    public function __construct(
        public string $default_branch,
        public string $full_name,
        public string $html_url,
        public int $id,
        public string $node_id,
        public bool $private,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'default_branch' => $this->default_branch,
            'full_name' => $this->full_name,
            'html_url' => $this->html_url,
            'id' => $this->id,
            'node_id' => $this->node_id,
            'private' => $this->private,
        ];
    }
}
