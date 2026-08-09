<?php

declare(strict_types=1);

namespace Poagen\Generator\Tests\Support;

use Poagen\Generator\Generator\GenerationPlan;

use const DIRECTORY_SEPARATOR;

/**
 * The emitted source of one named model out of a plan, by suffix match on
 * the write path. `heal-the-duplication-gate-margins` factored this out of
 * the two tests that carried an identical copy — {@see RefusalPlanFixture}
 * and {@see ApiClientSourceFixture} are its usual companions.
 */
trait ModelSourceFixture
{
    private function modelSource(GenerationPlan $plan, string $className): string
    {
        foreach ($plan->writes as $path => $source) {
            if (str_ends_with($path, DIRECTORY_SEPARATOR . $className . '.php')) {
                return $source;
            }
        }

        self::fail("the plan wrote no {$className}.php");
    }
}
