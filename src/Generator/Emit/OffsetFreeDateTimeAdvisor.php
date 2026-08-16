<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator\Emit;

use cebe\openapi\spec\OpenApi;
use cebe\openapi\spec\Schema;

use function is_string;
use function preg_match;
use function sprintf;

/**
 * Names a `date-time` the document itself shows without an offset.
 *
 * RFC 3339 requires the offset, and poagen resolves a value that carries none
 * against the PROCESS timezone. The type is right and the value is wrong by a
 * whole number of hours, which is the kind of defect nobody re-reads a field
 * to find: the consumer that produced this advisor found it by comparing
 * their own screen against the vendor's back office, not from anything the
 * client said.
 *
 * Evidence, never suspicion. A property is reported only when its own
 * `example` or `default` is a string this document shows without an offset —
 * the document convicting itself. A `date-time` with no example says nothing,
 * and that silence is deliberate: most documents carry no per-property
 * examples at all, so reporting on their absence would fire on nearly every
 * run and make the report worth ignoring. `silence-means-success` only means
 * something while silence is earned.
 *
 * Advisory, exactly as {@see FormatAdvisor}'s own report is. The value
 * hydrates and the client is whole, so nothing here moves the exit status —
 * this is a run that could be more correct, not one that shrank the client.
 *
 * @internal
 */
final readonly class OffsetFreeDateTimeAdvisor
{
    /** RFC 3339's offset: `Z`, or `+hh:mm` / `-hh:mm`, at the very end. */
    private const string CARRIES_OFFSET = '/(?:Z|[+-]\d{2}:?\d{2})$/i';

    /** Something date-shaped at all — an unrelated string is not evidence. */
    private const string LOOKS_LIKE_A_TIMESTAMP = '/^\d{4}\D\d{2}\D\d{2}[T ]\d{2}:\d{2}/';

    /**
     * @return list<string> one line when the document shows an offset-free
     *                      `date-time`, empty otherwise
     */
    public static function notices(OpenApi $openApi): array
    {
        $count = 0;
        $firstSeen = null;

        foreach (SchemaWalk::roots($openApi) as $schema) {
            self::walk($schema, $count, $firstSeen);
        }

        if ($firstSeen === null) {
            return [];
        }

        return [sprintf(
            "format 'date-time' is shown without a UTC offset — %d example(s), first at %s. RFC 3339 requires "
                . 'one, and a value without it resolves against the process timezone, so the same payload means '
                . 'different instants on different machines. Say which zone the vendor means: '
                . 'Profile::$dateTimeZone when they fixed one for every installation, or a '
                . 'Runtime\\BindingContext at client construction when it varies by installation.',
            $count,
            $firstSeen,
        )];
    }

    private static function walk(Schema $schema, int &$count, ?string &$firstSeen): void
    {
        if ($schema->format === 'date-time') {
            foreach ([$schema->example, $schema->default] as $shown) {
                if (!self::isOffsetFree($shown)) {
                    continue;
                }

                ++$count;
                $firstSeen ??= SynthesisedModel::originOf($schema);
            }
        }

        foreach (SchemaWalk::children($schema) as $child) {
            self::walk($child, $count, $firstSeen);
        }
    }

    private static function isOffsetFree(mixed $shown): bool
    {
        return is_string($shown)
            && preg_match(self::LOOKS_LIKE_A_TIMESTAMP, $shown) === 1
            && preg_match(self::CARRIES_OFFSET, $shown) !== 1;
    }
}
