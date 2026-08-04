<?php

declare(strict_types=1);

namespace Poagen\Generator\Exception;

use Poagen\Generator\Generator\Profile;
use RuntimeException;

use function count;
use function sprintf;

/**
 * Thrown once, at the end of planning, when the schema contains constructs
 * poagen cannot represent, or {@see Profile::$skip}
 * is stale or names something absent from the schema.
 *
 * Carries every problem found during this run — not just the first one
 * encountered — so a consumer fixing their schema sees the whole list in
 * one pass instead of one failure at a time (abort-on-unrepresentable-constructs).
 * Nothing is written to disk when this is thrown: {@see
 * \Poagen\Generator\Generator\Generator::plan()} builds the whole plan in
 * memory and only throws before returning it, so the apply step that
 * touches the filesystem never runs.
 */
final class UnrepresentableConstructsException extends RuntimeException
{
    /**
     * @param list<string> $problems fully formatted diagnostic lines, one per problem
     */
    public static function forProblems(array $problems): self
    {
        $count = count($problems);
        $noun = $count === 1 ? 'problem' : 'problems';
        $lines = array_map(static fn(string $p): string => '  - ' . $p, $problems);

        return new self(sprintf(
            "%d %s found; nothing was written:\n%s\n\nAdd an entry to Profile::\$skip naming the operation id or "
                . 'component to accept one of these and generate without it.',
            $count,
            $noun,
            implode("\n", $lines),
        ));
    }
}
