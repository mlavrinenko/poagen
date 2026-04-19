<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class NfsSnapshotGetResponse implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'snapshot' => ['snapshot', \Acme\DigitalOcean\Generated\Model\NfsSnapshotResponse::class],
    ];

    public function __construct(
        public ?NfsSnapshotResponse $snapshot = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'snapshot' => $this->snapshot,
        ];
    }
}
