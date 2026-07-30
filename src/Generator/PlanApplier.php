<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator;

use RuntimeException;

use function dirname;

/**
 * Executes a {@see GenerationPlan} against the filesystem.
 *
 * Split out of {@see Generator} so the planning step stays pure and the
 * I/O side-effects live in one small, easy-to-mock surface.
 */
final readonly class PlanApplier
{
    public function apply(GenerationPlan $plan): void
    {
        foreach ($plan->writes as $path => $contents) {
            $this->ensureDir(dirname($path));
            file_put_contents($path, $contents);
        }

        foreach ($plan->prunes as $path) {
            if (is_file($path)) {
                unlink($path);
            }
        }
    }

    private function ensureDir(string $dir): void
    {
        if (!is_dir($dir) && !mkdir($dir, 0o755, true) && !is_dir($dir)) {
            throw new RuntimeException("Could not create output dir: {$dir}");
        }
    }
}
