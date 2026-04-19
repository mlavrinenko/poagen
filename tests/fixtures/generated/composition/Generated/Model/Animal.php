<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Fixtures\Generated\Composition\Generated\Model;

use JsonSerializable;

final readonly class Animal implements JsonSerializable
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
        'creature' => [
            'creature',
            [
                'union',
                [
                    \Mlavrinenko\Paogen\Tests\Fixtures\Generated\Composition\Generated\Model\Dog::class,
                    \Mlavrinenko\Paogen\Tests\Fixtures\Generated\Composition\Generated\Model\Cat::class,
                ],
                null,
            ],
        ],
    ];

    public function __construct(
        public Dog|Cat $creature,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'creature' => $this->creature,
        ];
    }
}
