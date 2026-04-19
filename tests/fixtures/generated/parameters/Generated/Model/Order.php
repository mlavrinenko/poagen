<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Fixtures\Generated\Parameters\Generated\Model;

use JsonSerializable;
use Mlavrinenko\Paogen\Tests\Fixtures\Generated\Parameters\Generated\Enum\Status;

final readonly class Order implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract. See ADR-007.
     *
     * phpName => [wireKey, shape]
     * shape is one of: null (scalar pass-through), `\FQCN::class` (model ref), ['list', null] (list<scalar>), ['list', \FQCN::class] (list<Model>), ['scalar', \FQCN::class] (ScalarBinding VO), ['datetime', null] (format: date-time → \DateTimeImmutable), ['date', null] (format: date → \DateTimeImmutable), ['enum', \FQCN::class] (named enum component → backed enum), ['union', [\A::class, \B::class, ...], 'propertyName'|null] (oneOf/anyOf of refs; third slot is the discriminator property name or null).
     *
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
