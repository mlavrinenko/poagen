<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class PullRequestMinimal implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'base' => ['base', \Acme\GitHub\Generated\Model\PullRequestMinimalBase::class],
        'head' => ['head', \Acme\GitHub\Generated\Model\PullRequestMinimalHead::class],
        'id' => ['id', null],
        'number' => ['number', null],
        'url' => ['url', null],
    ];

    public function __construct(
        public PullRequestMinimalBase $base,
        public PullRequestMinimalHead $head,
        public int $id,
        public int $number,
        public string $url,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'base' => $this->base,
            'head' => $this->head,
            'id' => $this->id,
            'number' => $this->number,
            'url' => $this->url,
        ];
    }
}
