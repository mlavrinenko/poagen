<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class NfsRequest implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'name' => ['name', null],
        'region' => ['region', null],
        'size_gib' => ['size_gib', null],
        'vpc_ids' => ['vpc_ids', ['list', null]],
        'performance_tier' => ['performance_tier', null],
    ];

    /**
     * @param list<string> $vpc_ids
     */
    public function __construct(
        public string $name,
        public string $region,
        public int $size_gib,
        public array $vpc_ids,
        public ?string $performance_tier = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'name' => $this->name,
            'region' => $this->region,
            'size_gib' => $this->size_gib,
            'vpc_ids' => $this->vpc_ids,
            'performance_tier' => $this->performance_tier,
        ];
    }
}
