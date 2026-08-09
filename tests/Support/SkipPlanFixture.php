<?php

declare(strict_types=1);

namespace Poagen\Generator\Tests\Support;

use Poagen\Generator\Generator\GenerationPlan;
use Poagen\Generator\Generator\Profile;

/**
 * The single generation call every "does this schema construct get
 * accepted, and does a skip entry cover exactly the operation it names"
 * integration test needs: plan `self::SCHEMA` into a fresh sandbox under
 * `self::NAMESPACE`, passing `$skip` straight through.
 *
 * Nine test classes carried a byte-identical copy before
 * `heal-the-duplication-gate-margins` factored it out — the largest single
 * clone family the source tier's duplicated-logic/scaffolding split found,
 * measured from jscpd's own JSON report rather than eyeballed. They differed
 * only in the sandbox-directory prefix passed to
 * {@see GeneratedTreeSandbox::makeSandboxDir()}, a debugging aid nothing
 * asserts on, so this trait derives it from the class name instead.
 *
 * A class using this trait must also `use GeneratedTreeSandbox` (for
 * `generator()` and `makeSandboxDir()`) and declare `SCHEMA` and `NAMESPACE`
 * constants — the convention every {@see GeneratedTreeSandbox} caller
 * already follows. {@see RefusalPlanFixture} composes this trait and adds
 * `refusalMessage()` for the subset of callers that also assert on a caught
 * `UnrepresentableConstructsException`.
 */
trait SkipPlanFixture
{
    /**
     * @param array<string,string> $skip
     */
    private function plan(array $skip): GenerationPlan
    {
        return self::generator()->plan(new Profile(
            schema: self::SCHEMA,
            output: self::makeSandboxDir(self::skipPlanSandboxPrefix()),
            namespace: self::NAMESPACE,
            skip: $skip,
        ));
    }

    /**
     * The short class name, lower-cased — a stable, collision-free sandbox
     * prefix with no per-class literal to keep in step.
     */
    private static function skipPlanSandboxPrefix(): string
    {
        $fqcn = static::class;
        $short = substr($fqcn, strrpos($fqcn, '\\') !== false ? strrpos($fqcn, '\\') + 1 : 0);

        return 'poagen-' . strtolower($short) . '-';
    }
}
