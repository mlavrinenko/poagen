<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ApiPages implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'first' => ['first', null],
        'last' => ['last', null],
        'next' => ['next', null],
        'previous' => ['previous', null],
    ];

    public function __construct(
        public ?string $first = null,
        public ?string $last = null,
        public ?string $next = null,
        public ?string $previous = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'first' => $this->first,
            'last' => $this->last,
            'next' => $this->next,
            'previous' => $this->previous,
        ];
    }
}
