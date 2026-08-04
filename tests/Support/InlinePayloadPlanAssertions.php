<?php

declare(strict_types=1);

namespace Poagen\Generator\Tests\Support;

use function array_keys;
use function basename;
use function sort;
use function str_contains;

use const DIRECTORY_SEPARATOR;
use const SORT_STRING;

/**
 * The one extra helper {@see GeneratedTreeSandbox} does not already cover:
 * listing the basenames a plan wrote under one emitted subdirectory
 * (`Model`, `Enum`), sorted for a stable assertion. Shared by every
 * inline-payload-naming integration test — `InlinePayloadSynthesisTest`,
 * `InlineMultiStatusResponseTest`, `InlineModelMergeTest` — rather than each
 * growing its own copy (`deduplicate-the-test-suite`). `GeneratedTreeSandbox`'s
 * own `plannedSource()` already covers pulling one named file's source out
 * of a plan, which is the other half these three tests all needed.
 */
trait InlinePayloadPlanAssertions
{
    /**
     * @return list<string>
     */
    private static function emittedNames(\Poagen\Generator\Generator\GenerationPlan $plan, string $subdirectory): array
    {
        $needle = DIRECTORY_SEPARATOR . $subdirectory . DIRECTORY_SEPARATOR;
        $out = [];

        foreach (array_keys($plan->writes) as $path) {
            if (str_contains($path, $needle)) {
                $out[] = basename($path, '.php');
            }
        }

        sort($out, SORT_STRING);

        return $out;
    }
}
