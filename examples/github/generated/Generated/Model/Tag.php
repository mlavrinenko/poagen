<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class Tag implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'commit' => ['commit', \Acme\GitHub\Generated\Model\TagCommit::class],
        'name' => ['name', null],
        'node_id' => ['node_id', null],
        'tarball_url' => ['tarball_url', null],
        'zipball_url' => ['zipball_url', null],
    ];

    public function __construct(
        public TagCommit $commit,
        public string $name,
        public string $node_id,
        public string $tarball_url,
        public string $zipball_url,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'commit' => $this->commit,
            'name' => $this->name,
            'node_id' => $this->node_id,
            'tarball_url' => $this->tarball_url,
            'zipball_url' => $this->zipball_url,
        ];
    }
}
