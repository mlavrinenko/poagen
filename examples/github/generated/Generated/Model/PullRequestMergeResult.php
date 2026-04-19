<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class PullRequestMergeResult implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = ['merged' => ['merged', null], 'message' => ['message', null], 'sha' => ['sha', null]];

    public function __construct(
        public bool $merged,
        public string $message,
        public string $sha,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'merged' => $this->merged,
            'message' => $this->message,
            'sha' => $this->sha,
        ];
    }
}
