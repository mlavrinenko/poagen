<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class ReviewCustomGatesStateRequired implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'environment_name' => ['environment_name', null],
        'state' => ['state', null],
        'comment' => ['comment', null],
    ];

    public function __construct(
        public string $environment_name,
        public string $state,
        public ?string $comment = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'environment_name' => $this->environment_name,
            'state' => $this->state,
            'comment' => $this->comment,
        ];
    }
}
