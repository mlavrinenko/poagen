<?php

/**
 * This file is part of mlavrinenko/paogen
 *
 * @copyright Copyright (c) Maxim Lavrinenko <maxim@lavrinenko.xyz>
 * @license https://opensource.org/license/mit/ MIT License
 */

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Enum;

/**
 * Describes one backed enum that the generator intends to emit.
 *
 * `$values` preserves the order declared in the OpenAPI document so the
 * emitted `case` order is stable for byte-stability. `$caseNames` holds
 * the PHP-safe, PascalCased identifiers already resolved against the
 * value set — collisions (e.g. `foo` and `Foo`) are the caller's problem
 * to sort out before constructing the spec.
 */
final readonly class EnumSpec
{
    public const string BACKING_STRING = 'string';
    public const string BACKING_INT = 'int';

    /**
     * @param list<array{name: string, value: string|int}> $cases
     */
    public function __construct(
        public string $name,
        public string $backingType,
        public array $cases,
    ) {}
}
