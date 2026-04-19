<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class NfsListResponse implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'shares' => ['shares', ['list', \Acme\DigitalOcean\Generated\Model\NfsResponse::class]],
    ];

    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\NfsResponse> $shares
     */
    public function __construct(
        public ?array $shares = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'shares' => $this->shares,
        ];
    }
}
