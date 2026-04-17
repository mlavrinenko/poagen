<?php

/**
 * This file is part of mlavrinenko/paogen
 *
 * @copyright Copyright (c) Maxim Lavrinenko <maxim@lavrinenko.xyz>
 * @license https://opensource.org/license/mit/ MIT License
 */

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Attribute;

/**
 * Marks a user value object as the PHP type for an OpenAPI `format` value.
 *
 * Usage:
 *
 *     #[BindsFormat('email')]
 *     final readonly class Email
 *     {
 *         public function __construct(public string $value) { ... }
 *     }
 *
 * The generator's AttributeScanner discovers these on classes whose namespace
 * is listed in the Profile's `discoverIn`. See ADR-003.
 */
#[\Attribute(\Attribute::TARGET_CLASS)]
final readonly class BindsFormat
{
    public function __construct(public string $format) {}
}
