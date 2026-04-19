<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator;

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
     * @param array<string,string> $writes Absolute paths mapped to their would-be file contents.
     * @param list<string>         $prunes Absolute paths that would be deleted by the prune step.
     */
    public function __construct(
        public array $writes,
        public array $prunes,
    ) {}
}
