<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator;

use Mlavrinenko\Paogen\Exception\InvalidProfileException;

use function strlen;

use const DIRECTORY_SEPARATOR;

final class ProfileLoader
{
    public function load(string $path): Profile
    {
        if (!is_file($path)) {
            throw new InvalidProfileException("Profile file not found: {$path}");
        }

        $value = (static fn(): mixed => require $path)();

        if (!$value instanceof Profile) {
            $type = get_debug_type($value);

            throw new InvalidProfileException(
                "Profile file {$path} must return a " . Profile::class . " instance; got {$type}.",
            );
        }

        if (!is_file($value->schema)) {
            throw new InvalidProfileException(
                "Profile references missing schema: {$value->schema}",
            );
        }

        return $value->with(source: $this->label($path));
    }

    /**
     * Name the profile the way a reader would type it.
     *
     * This ends up in the header of every emitted file, so it must never be an
     * absolute path: `/home/someone/work/api/paogen.php` would put one
     * machine's directory layout into a committed tree, and the next
     * contributor's regeneration would rewrite every file with theirs. A path
     * relative to the working directory is both stable across checkouts and
     * the thing that can actually be pasted back into a shell.
     *
     * A profile outside the working directory falls back to its file name
     * rather than a `../..` chain that leads nowhere useful from anywhere
     * else.
     */
    private function label(string $path): string
    {
        $normalised = str_replace(DIRECTORY_SEPARATOR, '/', $path);

        while (str_starts_with($normalised, './')) {
            $normalised = substr($normalised, 2);
        }

        if (!str_starts_with($normalised, '/')) {
            return $normalised;
        }

        $cwd = getcwd();

        if ($cwd !== false) {
            $prefix = rtrim(str_replace(DIRECTORY_SEPARATOR, '/', $cwd), '/') . '/';

            if (str_starts_with($normalised, $prefix)) {
                return substr($normalised, strlen($prefix));
            }
        }

        return basename($normalised);
    }
}
