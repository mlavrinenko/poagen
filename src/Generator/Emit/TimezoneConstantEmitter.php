<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator\Emit;

use Nette\PhpGenerator\ClassType;

/**
 * Puts `public const string NAIVE_TIMEZONE` on the root client when the
 * profile stated one — the zone an offset-free `date-time` means, for a
 * vendor that fixed the same one for every installation.
 *
 * A value, not wiring, exactly as {@see ServerConstantEmitter} is: the
 * consumer reads it when they build a `Runtime\BindingContext`, and an
 * installation that differs states its own there instead and wins. Nothing
 * here reaches the transport, because
 * `operations-delegate-to-an-injected-transport` puts the transport in the
 * consumer's hands before a generated client exists — there is no seam by
 * which emitted code could apply this to itself, and inventing one would
 * mean the client constructing its own transport.
 *
 * One constant per tree rather than an attribute argument repeated on every
 * date-bearing property: the generated duplication tier is ratcheted per
 * tree (`generated-duplication-ceiling-is-per-tree`), and a string repeated
 * across a hundred models is the shape that moves it.
 *
 * @internal
 */
final readonly class TimezoneConstantEmitter
{
    public static function addTo(ClassType $class, ?string $zone): void
    {
        if ($zone === null) {
            return;
        }

        $class->addConstant('NAIVE_TIMEZONE', $zone)
            ->setPublic()
            ->setType('string')
            ->addComment('The zone a `date-time` without an offset means, per this document.');
    }
}
