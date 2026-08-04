<?php

declare(strict_types=1);

namespace Poagen\Generator\Tests\Unit\Runtime\Fixtures;

final readonly class Tag
{
    public function __construct(
        public ?int $id = null,
        public ?string $name = null,
    ) {}
}
