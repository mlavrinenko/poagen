<?php

/**
 * This file is part of mlavrinenko/paogen
 *
 * @copyright Copyright (c) Maxim Lavrinenko <maxim@lavrinenko.xyz>
 * @license https://opensource.org/license/mit/ MIT License
 */

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Fixtures\ValueObject;

use Mlavrinenko\Paogen\Generator\Attribute\BindsFormat;

/**
 * Fixture: a user value object that opts in as the PHP type for `format: email`.
 */
#[BindsFormat('email')]
final readonly class Email
{
    public function __construct(public string $value) {}
}
