<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Attribute;

use Attribute;

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
 * Repeatable, because one type frequently answers several spellings. Real
 * documents misspell format values and are inconsistent between endpoints — the
 * kilbil loyalty schema writes `date time`, `data time` and `data` for what is
 * all one `date-time` — and a consumer should not need three near-identical
 * classes to say so:
 *
 *     #[BindsFormat('date time')]
 *     #[BindsFormat('data time')]
 *     final readonly class Timestamp implements ScalarBinding { ... }
 *
 * The generator's AttributeScanner discovers these on classes whose namespace
 * is listed in the Profile's `discoverIn`. See ADR-003.
 */
#[Attribute(Attribute::TARGET_CLASS | Attribute::IS_REPEATABLE)]
final readonly class BindsFormat
{
    public function __construct(public string $format) {}
}
