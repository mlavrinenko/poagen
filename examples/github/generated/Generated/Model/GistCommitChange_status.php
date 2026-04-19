<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class GistCommitChange_status implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'additions' => ['additions', null],
        'deletions' => ['deletions', null],
        'total' => ['total', null],
    ];

    public function __construct(
        public ?int $additions = null,
        public ?int $deletions = null,
        public ?int $total = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'additions' => $this->additions,
            'deletions' => $this->deletions,
            'total' => $this->total,
        ];
    }
}
