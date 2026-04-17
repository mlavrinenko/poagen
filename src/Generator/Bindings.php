<?php

/**
 * This file is part of mlavrinenko/paogen
 *
 * @copyright Copyright (c) Maxim Lavrinenko <maxim@lavrinenko.xyz>
 * @license https://opensource.org/license/mit/ MIT License
 */

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator;

/**
 * Discovered user-side type bindings, indexed for O(1) lookup at emit time.
 */
final readonly class Bindings
{
    /**
     * @param array<string,class-string> $formats Map of OpenAPI format → user value-object FQCN.
     */
    public function __construct(public array $formats) {}

    public function formatType(string $format): ?string
    {
        return $this->formats[$format] ?? null;
    }
}
