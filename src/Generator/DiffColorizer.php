<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator;

/**
 * ANSI colouring for `poagen generate --diff`'s `--color=auto|always|never`.
 *
 * The `auto` decision is split into an I/O edge ({@see shouldColor}, which
 * reads the real stdout stream and the process environment) and a pure core
 * ({@see autoDetect}, plain booleans and strings in, no syscall) so the
 * decision itself is unit-testable without a real TTY or mutating the
 * process environment.
 */
final class DiffColorizer
{
    private const string RESET = "\e[0m";

    private const string GREEN = "\e[32m";

    private const string RED = "\e[31m";

    private const string CYAN = "\e[36m";

    /**
     * @param resource $stdout
     */
    public static function shouldColor(string $mode, $stdout): bool
    {
        if ($mode === 'always') {
            return true;
        }

        if ($mode === 'never') {
            return false;
        }

        return self::autoDetect(stream_isatty($stdout), getenv('NO_COLOR'), getenv('TERM'));
    }

    /**
     * `--color=auto` colours iff stdout is a TTY, `NO_COLOR` is not set to a
     * non-empty value, and `TERM` is not `dumb`. `getenv()` returns `false`
     * for an unset variable, which is why $noColor and $term accept it.
     */
    public static function autoDetect(bool $isTty, string|false $noColor, string|false $term): bool
    {
        if (!$isTty) {
            return false;
        }

        if ($noColor !== false && $noColor !== '') {
            return false;
        }

        return $term !== 'dumb';
    }

    /**
     * Post-processes an already-rendered unified diff line by line: `+`
     * lines green, `-` lines red, `@@` hunk headers cyan, the `--- a/…` /
     * `+++ b/…` file headers left uncoloured. The header checks run first —
     * both headers themselves start with `-` or `+` — so they are never
     * mistaken for a content line.
     */
    public static function apply(string $rendered): string
    {
        $lines = explode("\n", $rendered);
        $last = count($lines) - 1;

        foreach ($lines as $i => $line) {
            // The trailing element after exploding a string that ends in
            // "\n" is an empty artifact of the split, not a line — leave it.
            if ($i === $last && $line === '') {
                continue;
            }

            $lines[$i] = self::colorizeLine($line);
        }

        return implode("\n", $lines);
    }

    private static function colorizeLine(string $line): string
    {
        if (str_starts_with($line, '--- a/') || str_starts_with($line, '+++ b/')) {
            return $line;
        }

        if (str_starts_with($line, '@@')) {
            return self::CYAN . $line . self::RESET;
        }

        if (str_starts_with($line, '+')) {
            return self::GREEN . $line . self::RESET;
        }

        if (str_starts_with($line, '-')) {
            return self::RED . $line . self::RESET;
        }

        return $line;
    }
}
