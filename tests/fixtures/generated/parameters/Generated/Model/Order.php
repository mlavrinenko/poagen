<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Fixtures\Generated\Parameters\Generated\Model;

use JsonSerializable;

final readonly class Order implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract. See ADR-007.
     *
     * phpName => [wireKey, shape]
     * shape is one of: null (scalar pass-through), `\FQCN::class` (model ref), ['list', null] (list<scalar>), ['list', \FQCN::class] (list<Model>).
     *
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}}>
     */
    public const array PROPERTY_MAP = ['id' => ['id', null], 'status' => ['status', null]];

    public function __construct(
        public int $id,
        public ?string $status = null,
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
