<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Unit\Runtime\Fixtures;

final readonly class Warehouse
{
    /**
     * @param array<string, Tag>|null $bins
     */
    public function __construct(
        public ?string $name = null,
        public ?array $bins = null,
    ) {}
}
