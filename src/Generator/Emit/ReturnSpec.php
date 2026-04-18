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
 * Resolved return-type of an operation: either void (`model === null`), a
 * single Model, or a list of Models.
 */
final readonly class ReturnSpec
{
    public function __construct(
        public ?string $model,
        public bool $isList,
    ) {}
}
