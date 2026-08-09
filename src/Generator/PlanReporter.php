<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator;

use SebastianBergmann\Diff\Differ;
use SebastianBergmann\Diff\Output\UnifiedDiffOutputBuilder;

use const SORT_STRING;

/**
 * Formats a {@see GenerationPlan} for human consumption.
 *
 * Two modes:
 *  - {@see summary} — tree-shaped list of would-be writes and prunes for
 *    `poagen generate --dry-run`.
 *  - {@see diff} — unified diff between each planned write (and each
 *    planned prune) and the file currently on disk, for `--diff`.
 */
final class PlanReporter
{
    /**
     * Render a tree-like, path-sorted summary. The caller is responsible
     * for writing it to stdout.
     */
    public function summary(GenerationPlan $plan): string
    {
        $lines = [];

        $writes = array_keys($plan->writes);
        sort($writes, SORT_STRING);

        foreach ($writes as $path) {
            $lines[] = "would write: {$path}";
        }

        $prunes = $plan->prunes;
        sort($prunes, SORT_STRING);

        foreach ($prunes as $path) {
            $lines[] = "would prune: {$path}";
        }

        if ($lines === []) {
            return "poagen: nothing to do\n";
        }

        return implode("\n", $lines) . "\n";
    }

    /**
     * Render unified diffs between each planned write / prune and the
     * current file on disk. Returns an empty string when nothing differs.
     *
     * $filter, when given, drops any write/prune {@see DiffPathFilter}
     * rejects before it is even read off disk. $color, when true, runs each
     * rendered diff through {@see DiffColorizer}. Both are additive over the
     * plain call this method used to be: a bare `diff($plan)` renders
     * everything, uncoloured, exactly as before.
     */
    public function diff(GenerationPlan $plan, ?DiffPathFilter $filter = null, bool $color = false): string
    {
        $out = '';

        $writes = $plan->writes;
        ksort($writes, SORT_STRING);

        foreach ($writes as $path => $new) {
            if ($filter instanceof DiffPathFilter && !$filter->matches($path)) {
                continue;
            }

            $current = is_file($path) ? (string) file_get_contents($path) : '';

            if ($current === $new) {
                continue;
            }

            $out .= $this->unified($path, $current, $new, $color);
        }

        $prunes = $plan->prunes;
        sort($prunes, SORT_STRING);

        foreach ($prunes as $path) {
            if ($filter instanceof DiffPathFilter && !$filter->matches($path)) {
                continue;
            }

            $current = is_file($path) ? (string) file_get_contents($path) : '';

            if ($current === '') {
                continue;
            }

            $out .= $this->unified($path, $current, '', $color);
        }

        return $out;
    }

    private function unified(string $path, string $from, string $to, bool $color): string
    {
        $header = "--- a/{$path}\n+++ b/{$path}\n";
        $differ = new Differ(new UnifiedDiffOutputBuilder($header, false));
        $rendered = $differ->diff($from, $to);

        return $color ? DiffColorizer::apply($rendered) : $rendered;
    }
}
