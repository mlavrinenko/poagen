<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator;

use Poagen\Generator\Exception\UnrepresentableConstructsException;

/**
 * The profile checks answerable from the profile alone, run before the
 * document is read.
 *
 * Most guidance validators wait until the end of a plan, because most of them
 * need the document, the model ledger, or both, and collecting them lets one
 * run report everything at once. These two need none of it: a
 * `Profile::$responseMaps` group either parses or does not
 * ({@see ResponseMapGroups}, whose own docblock says why it does not wait),
 * and a `Profile::$dateTimeZone` either names a zone PHP knows or does not
 * ({@see DateTimeZoneValidator}). Reading a schema to find that out is work
 * the consumer waits through for an answer that was already available.
 *
 * They are gathered rather than asserted one after another so the same
 * one-pass reporting applies here too: a profile wrong in both ways is told
 * about both, not about whichever check happens to run first
 * (abort-on-unrepresentable-constructs).
 *
 * @internal
 */
final readonly class ProfilePreflight
{
    /**
     * @throws UnrepresentableConstructsException
     */
    public static function assert(Profile $profile): void
    {
        $failures = [
            ...ResponseMapGroups::structuralFailures($profile->responseMaps),
            ...new DateTimeZoneValidator()->validate($profile->dateTimeZone),
        ];

        if ($failures !== []) {
            throw UnrepresentableConstructsException::forProblems($failures);
        }
    }
}
