<?php

declare(strict_types=1);

namespace Poagen\Generator;

use Composer\Autoload\ClassLoader;
use Composer\InstalledVersions;
use OutOfBoundsException;
use Throwable;

use function array_slice;
use function in_array;
use function is_array;

use const STDERR;
use const STDOUT;

/**
 * Minimal hand-rolled CLI entry point. See `plain-getopt-for-the-cli`.
 */
final class Cli
{
    private const string PACKAGE = 'poagen/client-generator';

    private const string USAGE = <<<HELP
        poagen — OpenAPI-driven PHP client generator

        USAGE
            poagen <command> [options]

        COMMANDS
            generate <profile>  Generate code from a profile (PHP file returning a Profile)
            validate <schema>   Parse and validate an OpenAPI document (YAML or JSON)
            help                Print this message
            version             Print the poagen version

        GENERATE OPTIONS
            --output=<dir>      Write the generated tree under <dir> (resolved relative to CWD),
                                overriding the profile's `output` setting.
            --dry-run           Print a tree-shaped summary of would-be-written and would-be-deleted
                                files; write nothing; exit 0.
            --diff              Print a unified diff between each planned write and the file on disk.
                                Exit 0 if no diffs, 1 if any, 2 on usage error.

        GLOBAL OPTIONS
            -h, --help          Print help for a command
            -V, --version       Print the poagen version

        NOTES
            The printed version reflects the installed poagen package, not the
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
        $stdout ??= STDOUT;
        $stderr ??= STDERR;

        $args = array_slice($argv, 1);

        if ($args === [] || in_array($args[0], ['-h', '--help', 'help'], true)) {
            fwrite($stdout, self::USAGE . "\n");
            return 0;
        }

        if (in_array($args[0], ['-V', '--version', 'version'], true)) {
            fwrite($stdout, 'poagen ' . self::version() . "\n");
            return 0;
        }

        if ($args[0] === 'generate') {
            $loader = self::composerLoader();

            if (!$loader instanceof ClassLoader) {
                fwrite($stderr, "poagen generate: could not locate Composer ClassLoader (needed to scan for #[BindsFormat]).\n");
                return 1;
            }

            return GenerateCommand::run(array_slice($args, 1), $loader, $stdout, $stderr);
        }

        if ($args[0] === 'validate') {
            return self::validate(array_slice($args, 1), $stdout, $stderr);
        }

        $command = $args[0];
        fwrite($stderr, "poagen: command '{$command}' is not implemented yet.\n");
        fwrite($stderr, "See `poagen help`.\n");
        return 2;
    }

    /**
     * @param list<string> $args
     * @param resource     $stdout
     * @param resource     $stderr
     */
    private static function validate(array $args, $stdout, $stderr): int
    {
        if ($args === []) {
            fwrite($stderr, "poagen validate: missing schema path.\n");
            fwrite($stderr, "See `poagen help`.\n");
            return 2;
        }

        $schemaPath = $args[0];

        if (!is_file($schemaPath)) {
            fwrite($stderr, "poagen validate: schema file not found: {$schemaPath}\n");
            return 1;
        }

        // cebe refuses relative paths when it stashes the file context for
        // later $ref resolution, even when resolveReferences is off.
        $absolutePath = realpath($schemaPath);

        if ($absolutePath === false) {
            fwrite($stderr, "poagen validate: cannot resolve schema path: {$schemaPath}\n");
            return 1;
        }

        try {
            $openApi = SchemaReader::read($absolutePath);
        } catch (Throwable $e) {
            fwrite($stderr, "poagen validate: parse error: {$e->getMessage()}\n");
            return 1;
        }

        if (!$openApi->validate()) {
            fwrite($stderr, "poagen validate: {$schemaPath} has validation errors:\n");
            foreach ($openApi->getErrors() as $error) {
                fwrite($stderr, "  - {$error}\n");
            }
            return 1;
        }

        fwrite($stdout, "poagen: {$schemaPath} is a valid OpenAPI document\n");
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
        } catch (OutOfBoundsException) {
            return 'dev';
        }

        return $version ?? 'dev';
    }

    private static function composerLoader(): ?ClassLoader
    {
        foreach (spl_autoload_functions() as $fn) {
            if (is_array($fn) && $fn[0] instanceof ClassLoader) {
                return $fn[0];
            }
        }

        return null;
    }
}
