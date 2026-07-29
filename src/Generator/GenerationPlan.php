<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator;

use Mlavrinenko\Paogen\Generator\Emit\SkippedComponent;
use Mlavrinenko\Paogen\Generator\Emit\SkippedOperation;

/**
 * The outcome of planning a generation run without touching disk.
 *
 * Split out so that `--dry-run` and `--diff` can inspect the would-be
 * writes and prunes without committing them; `Generator::generate()`
 * runs the plan and then applies it in the usual path.
 */
final readonly class GenerationPlan
{
    /**
     * @param array<string,string>   $writes              Absolute paths mapped to their would-be file contents.
     * @param list<string>           $prunes              Absolute paths that would be deleted by the prune step.
     * @param list<SkippedOperation> $skippedOperations   Operations the generator did not emit. Reaching a
     *                                                    successful plan with a non-empty list here means every
     *                                                    one of them was explicitly accepted via `Profile::$skip`
     *                                                    (abort-on-unrepresentable-constructs) — otherwise
     *                                                    {@see \Mlavrinenko\Paogen\Generator\Generator::plan()}
     *                                                    throws instead of returning.
     * @param list<SkippedComponent> $skippedComponents   Components (or components with an undiscriminated
     *                                                    union property) the generator did not emit. Same
     *                                                    skip-list guarantee as $skippedOperations.
     */
    public function __construct(
        public array $writes,
        public array $prunes,
        public array $skippedOperations = [],
        public array $skippedComponents = [],
    ) {}
}
