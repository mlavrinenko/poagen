<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen;

use Composer\Autoload\ClassLoader;
use Mlavrinenko\Paogen\Exception\InvalidProfileException;
use Mlavrinenko\Paogen\Generator\AttributeScanner;
use Mlavrinenko\Paogen\Generator\Generator;
use Mlavrinenko\Paogen\Generator\PlanReporter;
use Mlavrinenko\Paogen\Generator\Profile;
use Mlavrinenko\Paogen\Generator\ProfileLoader;

/**
 * `paogen generate` command handler.
 *
 * Split out of {@see Cli} so the dispatch helper in `Cli.php` stays tiny
 * (ADR-006 — hand-rolled CLI). Flag parsing is a manual loop; see T-019.
 */
final class GenerateCommand
{
    /**
     * @param list<string> $args
     * @param resource     $stdout
     * @param resource     $stderr
     */
    public static function run(array $args, ClassLoader $loader, $stdout, $stderr): int
    {
        $positional = [];
        $output = null;
        $dryRun = false;
        $diff = false;

        foreach ($args as $arg) {
            if ($arg === '--dry-run') {
                $dryRun = true;
                continue;
            }
            if ($arg === '--diff') {
                $diff = true;
                continue;
            }
            if (str_starts_with($arg, '--output=')) {
                $output = substr($arg, 9);
                continue;
            }
            if (str_starts_with($arg, '--')) {
                fwrite($stderr, "paogen generate: unknown option '{$arg}'.\n");
                return 2;
            }
            $positional[] = $arg;
        }

        if ($dryRun && $diff) {
            fwrite($stderr, "paogen generate: --dry-run and --diff are mutually exclusive.\n");
            return 2;
        }

        if ($positional === []) {
            fwrite($stderr, "paogen generate: missing profile path.\n");
            return 2;
        }

        if ($output !== null && $output === '') {
            fwrite($stderr, "paogen generate: --output requires a non-empty value.\n");
            return 2;
        }

        try {
            $profile = new ProfileLoader()->load($positional[0]);
        } catch (InvalidProfileException $e) {
            fwrite($stderr, "paogen generate: {$e->getMessage()}\n");
            return 2;
        }

        if ($output !== null) {
            $profile = self::withOutput($profile, $output);
        }

        $generator = new Generator(new AttributeScanner($loader));

        if ($dryRun) {
            $plan = $generator->plan($profile);
            fwrite($stdout, new PlanReporter()->summary($plan));
            self::reportSkipped($plan, $stderr);
            return 0;
        }

        if ($diff) {
            $plan = $generator->plan($profile);
            $rendered = new PlanReporter()->diff($plan);
            self::reportSkipped($plan, $stderr);

            if ($rendered === '') {
                return 0;
            }

            fwrite($stdout, $rendered);
            return 1;
        }

        $plan = $generator->generate($profile);
        fwrite($stdout, "paogen: generated into {$profile->output}\n");
        self::reportSkipped($plan, $stderr);
        return 0;
    }

    /**
     * @param resource $stderr
     */
    private static function reportSkipped(\Mlavrinenko\Paogen\Generator\GenerationPlan $plan, $stderr): void
    {
        $skippedOps = $plan->skippedOperations;

        if ($skippedOps !== []) {
            $count = \count($skippedOps);
            fwrite($stderr, "paogen: {$count} operation(s) skipped — not emitted onto ApiClient:\n");

            foreach ($skippedOps as $entry) {
                fwrite($stderr, $entry->format() . "\n");
            }
        }

        $skippedComponents = $plan->skippedComponents;

        if ($skippedComponents !== []) {
            $count = \count($skippedComponents);
            fwrite($stderr, "paogen: {$count} component(s) skipped — no Generated/Model file emitted:\n");

            foreach ($skippedComponents as $entry) {
                fwrite($stderr, "  - {$entry->rawName} [{$entry->reason}]\n");
            }
        }
    }

    private static function withOutput(Profile $profile, string $output): Profile
    {
        return new Profile(
            schema: $profile->schema,
            output: $output,
            namespace: $profile->namespace,
            discoverIn: $profile->discoverIn,
            renames: $profile->renames,
        );
    }
}
