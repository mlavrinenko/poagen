<?php

declare(strict_types=1);

namespace Poagen\Generator\Tests\Support;

use Poagen\Generator\Generator\GenerationPlan;

use const DIRECTORY_SEPARATOR;

/**
 * The emitted `ApiClient.php` source out of a plan, by suffix match on the
 * write path. Four integration tests carried a byte-identical copy of this
 * loop before `heal-the-duplication-gate-margins` factored it out — see
 * {@see RefusalPlanFixture}, its usual companion trait, for the rest of that
 * clone family's story.
 */
trait ApiClientSourceFixture
{
    private function clientSource(GenerationPlan $plan): string
    {
        foreach ($plan->writes as $path => $source) {
            if (str_ends_with($path, DIRECTORY_SEPARATOR . 'ApiClient.php')) {
                return $source;
            }
        }

        self::fail('the plan wrote no ApiClient.php');
    }
}
