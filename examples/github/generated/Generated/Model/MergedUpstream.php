<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class MergedUpstream implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'base_branch' => ['base_branch', null],
        'merge_type' => ['merge_type', null],
        'message' => ['message', null],
    ];

    public function __construct(
        public ?string $base_branch = null,
        public ?string $merge_type = null,
        public ?string $message = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'base_branch' => $this->base_branch,
            'merge_type' => $this->merge_type,
            'message' => $this->message,
        ];
    }
}
