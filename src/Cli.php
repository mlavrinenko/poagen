<?php

/**
 * This file is part of mlavrinenko/paogen
 *
 * @copyright Copyright (c) Maxim Lavrinenko <maxim@lavrinenko.xyz>
 * @license https://opensource.org/license/mit/ MIT License
 */

declare(strict_types=1);

namespace Mlavrinenko\Paogen;

/**
 * Minimal hand-rolled CLI entry point.
 *
 * See docs/design/cli-tooling.md for why this doesn't use symfony/console.
 */
final class Cli
{
    private const string VERSION = '0.1.0-dev';

    private const string USAGE = <<<HELP
        paogen — OpenAPI-driven PHP client generator

        USAGE
            paogen <command> [options]

        COMMANDS
            generate <schema>   Generate a PHP client from an OpenAPI 3.x schema
            validate <schema>   Validate an OpenAPI 3.x schema
            help                Print this message
            version             Print the paogen version

        GLOBAL OPTIONS
            -h, --help          Print help for a command
            -V, --version       Print the paogen version

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
            fwrite($stdout, 'paogen ' . self::VERSION . "\n");
            return 0;
        }

        $command = $args[0];
        fwrite($stderr, "paogen: command '{$command}' is not implemented yet.\n");
        fwrite($stderr, "See `paogen help`.\n");
        return 2;
    }
}
