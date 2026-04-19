<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class GitRef implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'node_id' => ['node_id', null],
        'object' => ['object', \Acme\GitHub\Generated\Model\GitRefObject::class],
        'ref' => ['ref', null],
        'url' => ['url', null],
    ];

    public function __construct(
        public string $node_id,
        public GitRefObject $object,
        public string $ref,
        public string $url,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'node_id' => $this->node_id,
            'object' => $this->object,
            'ref' => $this->ref,
            'url' => $this->url,
        ];
    }
}
