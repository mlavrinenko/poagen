<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator;

use Poagen\Runtime\Format\RamseyUuidCodec;
use Poagen\Runtime\Format\SymfonyUuidCodec;

use function implode;
use function sprintf;

/**
 * The formats `poagen/client-runtime` already carries a binding for, and the
 * library each one needs.
 *
 * Distinct from a built-in like `date-time`, which poagen resolves on its
 * own. A built-in is only free where PHP core already has the type:
 * `DateTimeImmutable` costs nobody a dependency and takes no side on which
 * library is right. `uuid` has no core type, so any binding for it is a
 * dependency decision, and one poagen is in no position to make for a
 * consumer who may already have a different UUID library in their tree — or
 * none, and no wish to acquire one. So nothing here is applied by default;
 * these are candidates {@see Emit\FormatAdvisor} names when the document uses
 * a format one of them covers, and a `Profile::$formats` entry is what turns
 * one on.
 *
 * Keyed by format, valued by package name → binding class, because the
 * package is the half of the answer a consumer has to act on: the class is
 * one line in the profile, the `composer require` is the part they would
 * otherwise discover from a class-not-found at run time.
 */
final readonly class ReadyMadeBindings
{
    /** @var array<string,array<string,class-string>> */
    private const array BY_FORMAT = [
        'uuid' => [
            'ramsey/uuid' => RamseyUuidCodec::class,
            'symfony/uid' => SymfonyUuidCodec::class,
        ],
    ];

    /**
     * One `\Fqcn::class (package)` clause per candidate, in declaration
     * order, or `null` when poagen ships nothing for this format.
     */
    public static function candidatesFor(string $format): ?string
    {
        $candidates = self::BY_FORMAT[$format] ?? [];

        if ($candidates === []) {
            return null;
        }

        $clauses = [];

        foreach ($candidates as $package => $fqcn) {
            $clauses[] = sprintf('\\%s::class (%s)', $fqcn, $package);
        }

        return implode(', ', $clauses);
    }
}
