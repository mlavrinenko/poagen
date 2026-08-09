<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator;

use const DIRECTORY_SEPARATOR;

/**
 * Scopes `poagen generate --diff` to a subtree of the generated output via
 * `--diff=<glob>`.
 *
 * Matches against each write/prune path made relative to the output root
 * `$outputRoot` names (both come from the same `Profile::$output` string a
 * {@see GenerationPlan}'s paths are built from, so stripping that literal
 * prefix is enough — no `realpath()` needed); a path not under the output
 * root is matched against the raw path {@see GenerationPlan} recorded for
 * it instead.
 *
 * Glob semantics: `**` crosses `/`, `*` does not, `?` is one non-`/`
 * character. A pattern with no wildcard character matches the relative path
 * exactly OR anything beneath it as a directory prefix, so `Generated/Model`
 * and `Generated/Model/**` scope to the same subtree.
 *
 * Its own final class, constructed from the pattern plus the output root, so
 * the glob semantics are unit-testable without building a
 * {@see GenerationPlan}.
 */
final readonly class DiffPathFilter
{
    private string $root;

    private bool $literal;

    private string $regex;

    public function __construct(
        private string $pattern,
        string $outputRoot,
    ) {
        $this->root = rtrim($outputRoot, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        $this->literal = preg_match('/[*?]/', $pattern) !== 1;
        $this->regex = $this->toRegex($pattern);
    }

    public function matches(string $path): bool
    {
        $subject = str_starts_with($path, $this->root)
            ? substr($path, strlen($this->root))
            : $path;

        if ($this->literal) {
            return $subject === $this->pattern || str_starts_with($subject, $this->pattern . '/');
        }

        return preg_match($this->regex, $subject) === 1;
    }

    /**
     * Translates one glob pattern into an anchored regex, quoting every
     * non-wildcard character with `preg_quote`. `**` (crosses `/`) is
     * checked before a lone `*` (does not) since both start with the same
     * character.
     */
    private function toRegex(string $pattern): string
    {
        $regex = '';
        $length = strlen($pattern);

        for ($i = 0; $i < $length; $i++) {
            $char = $pattern[$i];

            if ($char === '*' && ($pattern[$i + 1] ?? '') === '*') {
                $regex .= '.*';
                $i++;

                continue;
            }

            $regex .= match ($char) {
                '*' => '[^/]*',
                '?' => '[^/]',
                default => preg_quote($char, '#'),
            };
        }

        return '#^' . $regex . '$#';
    }
}
