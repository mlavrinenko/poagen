<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class PushEvent implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'before' => ['before', null],
        'head' => ['head', null],
        'push_id' => ['push_id', null],
        'ref' => ['ref', null],
        'repository_id' => ['repository_id', null],
    ];

    public function __construct(
        public string $before,
        public string $head,
        public int $push_id,
        public string $ref,
        public int $repository_id,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'before' => $this->before,
            'head' => $this->head,
            'push_id' => $this->push_id,
            'ref' => $this->ref,
            'repository_id' => $this->repository_id,
        ];
    }
}
