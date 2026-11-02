<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator;

use DateTimeZone;

use function in_array;
use function sprintf;
use function str_contains;
use function timezone_open;

/**
 * Checks `Profile::$dateTimeZone` against PHP's own timezone database.
 *
 * Answerable from the profile alone, so like {@see FormatBindingValidator}
 * this needs neither the document nor the model ledger. It is worth checking
 * at all because the failure it prevents is otherwise silent: PHP's
 * `DateTimeZone` throws on an unknown identifier at RUN time, in the
 * consumer's application, long after generation reported success — and a
 * near-miss (`Europe/Kyiv` for `Europe/Kiev`, `MSK`, `UTC+3`) reads like a
 * real zone to whoever wrote it.
 *
 * Returns failure lines rather than throwing, so a run reports every problem
 * it found in one pass, same as every other profile-guidance validator here
 * (abort-on-unrepresentable-constructs).
 */
final readonly class DateTimeZoneValidator
{
    /**
     * @param  string|null   $zone Profile::$dateTimeZone
     * @return list<string>  failure lines; empty means the profile named nothing, or named a zone PHP knows
     */
    public function validate(?string $zone): array
    {
        if ($zone === null) {
            return [];
        }

        // ALL_WITH_BC rather than ALL: a document pinned to a deprecated
        // identifier is still telling the truth about what its vendor sends,
        // and PHP still resolves it. Refusing it would refuse a fact.
        //
        // The list is not enough on every build. Some distributions strip
        // the backward-compatible links from tzdata, so `US/Eastern` resolves
        // through `timezone_open()` but is missing from `listIdentifiers()`.
        // A named zone is one with a slash; abbreviations such as `MSK` and
        // offsets such as `UTC+3` still fail the list and are still refused.
        if (in_array($zone, DateTimeZone::listIdentifiers(DateTimeZone::ALL_WITH_BC), true)) {
            return [];
        }

        if (str_contains($zone, '/') && @timezone_open($zone) !== false) {
            return [];
        }

        return [sprintf(
            "Profile::\$dateTimeZone '%s' is not a timezone identifier PHP knows — use one from "
                . 'DateTimeZone::listIdentifiers(), e.g. Europe/Moscow.',
            $zone,
        )];
    }
}
