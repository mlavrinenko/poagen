<?php

declare(strict_types=1);

namespace Poagen\Generator\Tests\Integration\Kilbil;

use function dirname;
use function is_file;
use function spl_autoload_register;
use function str_replace;
use function str_starts_with;
use function strlen;
use function substr;

/**
 * Loads the committed `examples/kilbil/generated/Generated` tree.
 *
 * `composer.json`'s `autoload-dev` maps `Acme\Kilbil\ValueObject\` (the
 * hand-written consumer types) but not `Acme\Kilbil\Generated\` — this task's
 * file boundary is `tests/Integration/**`, `tests/fixtures/**` and
 * `examples/kilbil/**`, and `composer.json` is explicitly out of bounds, so
 * the client classes need their own loader rather than a new PSR-4 entry.
 */
final class KilbilGeneratedAutoload
{
    private static bool $registered = false;

    public static function register(): void
    {
        if (self::$registered) {
            return;
        }

        self::$registered = true;

        $root = dirname(__DIR__, 3) . '/examples/kilbil/generated/Generated';
        $prefix = 'Acme\\Kilbil\\Generated\\';

        spl_autoload_register(static function (string $class) use ($root, $prefix): void {
            if (!str_starts_with($class, $prefix)) {
                return;
            }

            $relative = substr($class, strlen($prefix));
            $path = $root . '/' . str_replace('\\', '/', $relative) . '.php';

            if (is_file($path)) {
                require $path;
            }
        });
    }
}
