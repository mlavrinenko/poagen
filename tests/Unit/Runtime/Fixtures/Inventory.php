<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Unit\Runtime\Fixtures;

use Mlavrinenko\Paogen\Runtime\Attribute\AdditionalProperties;

/**
 * The same shape with the extra values typed by a `$ref`, so the map's values
 * are hydrated Models rather than raw arrays — `additionalProperties` is a
 * declaration like any other and the extras get the type it gave them.
 */
final readonly class Inventory
{
    /**
     * @param array<string, Tag> $additionalProperties
     */
    public function __construct(
        public ?string $warehouse = null,
        #[AdditionalProperties]
        public array $additionalProperties = [],
    ) {}
}
