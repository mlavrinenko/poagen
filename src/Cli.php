<?php

/**
 * This file is part of mlavrinenko/paogen
 *
 * @copyright Copyright (c) Maxim Lavrinenko <maxim@lavrinenko.xyz>
 * @license https://opensource.org/license/mit/ MIT License
 */

declare(strict_types=1);

namespace Mlavrinenko\Paogen;

use Composer\Autoload\ClassLoader;
use Composer\InstalledVersions;
use Mlavrinenko\Paogen\Exception\InvalidProfileException;
use Mlavrinenko\Paogen\Generator\AttributeScanner;
use Mlavrinenko\Paogen\Generator\Generator;
use Mlavrinenko\Paogen\Generator\ProfileLoader;

/**
 * Minimal hand-rolled CLI entry point. See ADR-006.
 */
final class Cli
{
    private const string PACKAGE = 'mlavrinenko/paogen';

    private const string USAGE = <<<HELP
        paogen — OpenAPI-driven PHP client generator

        USAGE
            paogen <command> [options]

        COMMANDS
            generate <profile>  Generate code from a profile (PHP file returning a Profile)
            help                Print this message
            version             Print the paogen version

        GLOBAL OPTIONS
            -h, --help          Print help for a command
            -V, --version       Print the paogen version

        NOTES
            The printed version reflects the installed paogen package, not the
            working copy. In-repo runs report `dev-<branch>`; installs via
            Packagist report the tagged release. When Composer metadata is not
            available the fallback sentinel `dev` is used instead.

        HELP;

    /**
     * @param  list<string>  $argv
     * @param  resource|null $stdout defaults to STDOUT
     * @param  resource|null $stderr defaults to STDERR
     * @return int exit code
     */
    public static function run(array $argv, $stdout = null, $stderr = null): int
    {
        $stdout ??= \STDOUT;
        $stderr ??= \STDERR;

        $args = \array_slice($argv, 1);

        if ($args === [] || \in_array($args[0], ['-h', '--help', 'help'], true)) {
            fwrite($stdout, self::USAGE . "\n");
            return 0;
        }

        if (\in_array($args[0], ['-V', '--version', 'version'], true)) {
            fwrite($stdout, 'paogen ' . self::version() . "\n");
            return 0;
        }

        if ($args[0] === 'generate') {
            return self::generate(\array_slice($args, 1), $stdout, $stderr);
        }

        $command = $args[0];
        fwrite($stderr, "paogen: command '{$command}' is not implemented yet.\n");
        fwrite($stderr, "See `paogen help`.\n");
        return 2;
    }

    /**
     * @param list<string> $args
     * @param resource     $stdout
     * @param resource     $stderr
     */
    private static function generate(array $args, $stdout, $stderr): int
    {
        if ($args === []) {
            fwrite($stderr, "paogen generate: missing profile path.\n");
            return 2;
        }

        $loader = self::composerLoader();

        if (!$loader instanceof \Composer\Autoload\ClassLoader) {
            fwrite($stderr, "paogen generate: could not locate Composer ClassLoader (needed to scan for #[BindsFormat]).\n");
            return 1;
        }

        try {
            $profile = new ProfileLoader()->load($args[0]);
        } catch (InvalidProfileException $e) {
            fwrite($stderr, "paogen generate: {$e->getMessage()}\n");
            return 2;
        }

        new Generator(new AttributeScanner($loader))->generate($profile);

        fwrite($stdout, "paogen: generated into {$profile->output}\n");
        return 0;
    }

    /**
     * Resolve a package's version from Composer's installed metadata so that
     * consumers who install via Packagist see the real tag, while in-repo
     * runs still report something meaningful (`dev-<branch>`). Packagers
     * that strip Composer's `installed.php` (phar, vendored) hit the
     * fallback sentinel `dev`.
     *
     * Exposed so the fallback path can be regression-tested with a known-
     * missing package name.
     */
    public static function version(string $package = self::PACKAGE): string
    {
        try {
            $version = InstalledVersions::getPrettyVersion($package);
        } catch (\OutOfBoundsException) {
            return 'dev';
        }

        return $version ?? 'dev';
    }

    private static function composerLoader(): ?ClassLoader
    {
        foreach (spl_autoload_functions() as $fn) {
            if (\is_array($fn) && isset($fn[0]) && $fn[0] instanceof ClassLoader) {
                return $fn[0];
            }
        }

        return null;
    }
}
