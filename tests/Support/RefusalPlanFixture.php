<?php

declare(strict_types=1);

namespace Poagen\Generator\Tests\Support;

use Poagen\Generator\Exception\UnrepresentableConstructsException;

/**
 * {@see SkipPlanFixture}'s `plan()` plus the refusal half: re-run it
 * expecting `UnrepresentableConstructsException` and hand back its message.
 *
 * Four test classes carried a byte-identical copy of both before
 * `heal-the-duplication-gate-margins` factored them out — see
 * {@see SkipPlanFixture} for the full story and the sandbox-prefix note, and
 * {@see ApiClientSourceFixture} / {@see ModelSourceFixture} for the other
 * traits the same clone family produced.
 */
trait RefusalPlanFixture
{
    use SkipPlanFixture;

    /**
     * @param array<string,string> $skip every refusal except the one under test —
     *                                    left unlisted so it surfaces in the exception
     */
    private function refusalMessage(array $skip): string
    {
        try {
            $this->plan($skip);
            self::fail('expected UnrepresentableConstructsException');
        } catch (UnrepresentableConstructsException $e) {
            return $e->getMessage();
        }
    }
}
