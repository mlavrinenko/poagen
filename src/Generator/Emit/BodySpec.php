<?php

/**
 * This file is part of mlavrinenko/paogen
 *
 * @copyright Copyright (c) Maxim Lavrinenko <maxim@lavrinenko.xyz>
 * @license https://opensource.org/license/mit/ MIT License
 */

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

/**
 * Resolved request-body shape: either a single `$ref`-to-Model or a
 * `list<$ref>`. `application/json` is the only content type we look at.
 */
final readonly class BodySpec
{
    public function __construct(
        public string $model,
        public bool $isList,
    ) {}
}
