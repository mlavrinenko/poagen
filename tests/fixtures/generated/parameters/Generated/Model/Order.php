<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Fixtures\Generated\Parameters\Generated\Model;

use JsonSerializable;
use Mlavrinenko\Paogen\Tests\Fixtures\Generated\Parameters\Generated\Enum\Status;

final readonly class Order implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'id' => ['id', null],
        'status' => [
            'status',
            ['enum', \Mlavrinenko\Paogen\Tests\Fixtures\Generated\Parameters\Generated\Enum\Status::class],
        ],
    ];

    public function __construct(
        public int $id,
        public ?Status $status = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
        ];
    }
}
