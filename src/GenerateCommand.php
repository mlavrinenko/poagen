<?php

declare(strict_types=1);

namespace Poagen\Generator;

use Composer\Autoload\ClassLoader;
use Poagen\Generator\Generator\AttributeScanner;
use Poagen\Generator\Generator\DiffColorizer;
use Poagen\Generator\Generator\DiffPathFilter;
use Poagen\Generator\Generator\GenerationPlan;
use Poagen\Generator\Generator\Generator;
use Poagen\Generator\Generator\PlanReporter;
use Poagen\Generator\Generator\Profile;
use Poagen\Generator\Generator\ProfileLoader;

use function count;
use function in_array;

/**
 * `poagen generate` command handler.
 *
 * Split out of {@see Cli} so the dispatch helper in `Cli.php` stays tiny
 * (`plain-getopt-for-the-cli` — hand-rolled CLI). Flag parsing is a manual
 * loop; see T-019.
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
        $diffGlob = null;
        $color = 'auto';

        foreach ($args as $arg) {
            if ($arg === '--dry-run') {
                $dryRun = true;
                continue;
            }
            if ($arg === '--diff') {
                $diff = true;
                continue;
            }
            if (str_starts_with($arg, '--diff=')) {
                $diff = true;
                $diffGlob = substr($arg, 7);
                continue;
            }
            if (str_starts_with($arg, '--output=')) {
                $output = substr($arg, 9);
                continue;
            }
            if (str_starts_with($arg, '--color=')) {
                $color = substr($arg, 8);
                continue;
            }
            if (str_starts_with($arg, '--')) {
                fwrite($stderr, "poagen generate: unknown option '{$arg}'.\n");
                return 2;
            }
            $positional[] = $arg;
        }

        if ($dryRun && $diff) {
            fwrite($stderr, "poagen generate: --dry-run and --diff are mutually exclusive.\n");
            return 2;
        }

        if ($positional === []) {
            fwrite($stderr, "poagen generate: missing profile path.\n");
            return 2;
        }

        if ($output !== null && $output === '') {
            fwrite($stderr, "poagen generate: --output requires a non-empty value.\n");
            return 2;
        }

        if ($diffGlob !== null && $diffGlob === '') {
            fwrite($stderr, "poagen generate: --diff requires a non-empty value.\n");
            return 2;
        }

        if (!in_array($color, ['auto', 'always', 'never'], true)) {
            fwrite($stderr, "poagen generate: --color must be one of auto, always, never.\n");
            return 2;
        }

        try {
            $profile = new ProfileLoader()->load($positional[0]);
        } catch (Exception\InvalidProfileException $e) {
            fwrite($stderr, "poagen generate: {$e->getMessage()}\n");
            return 2;
        }

        if ($output !== null) {
            $profile = self::withOutput($profile, $output);
        }

        $generator = new Generator(new AttributeScanner($loader));

        try {
            if ($dryRun) {
                $plan = $generator->plan($profile);
                fwrite($stdout, new PlanReporter()->summary($plan));
                self::reportSkipped($plan, $stderr);
                return 0;
            }

            if ($diff) {
                $plan = $generator->plan($profile);
                $filter = $diffGlob !== null ? new DiffPathFilter($diffGlob, $profile->output) : null;
                $useColor = DiffColorizer::shouldColor($color, $stdout);
                $rendered = new PlanReporter()->diff($plan, $filter, $useColor);
                self::reportSkipped($plan, $stderr);

                if ($rendered === '') {
                    return 0;
                }

                fwrite($stdout, $rendered);
                return 1;
            }

            $plan = $generator->generate($profile);
            self::reportSkipped($plan, $stderr);

            // The success line claims every operation and component made it
            // into the client. That is only true when nothing was skipped —
            // an accepted Profile::$skip entry is still an omission, and
            // printing the plain success line ahead of (or instead of
            // disclosing) it is exactly the "opens by announcing success"
            // shape default-deny-on-degradation forbids.
            if ($plan->skippedOperations === [] && $plan->skippedComponents === [] && $plan->skippedWebhooks === []) {
                fwrite($stdout, "poagen: generated into {$profile->output}\n");
            }

            return 0;
        } catch (Exception\UnrepresentableConstructsException $e) {
            fwrite($stderr, "poagen generate: {$e->getMessage()}\n");
            return 1;
        }
    }

    /**
     * @param resource $stderr
     */
    private static function reportSkipped(GenerationPlan $plan, $stderr): void
    {
        $skippedOps = $plan->skippedOperations;

        if ($skippedOps !== []) {
            $count = count($skippedOps);
            fwrite($stderr, "poagen: {$count} operation(s) skipped — not emitted onto ApiClient:\n");

            foreach ($skippedOps as $entry) {
                fwrite($stderr, $entry->format() . "\n");
            }
        }

        $skippedComponents = $plan->skippedComponents;

        if ($skippedComponents !== []) {
            $count = count($skippedComponents);
            fwrite($stderr, "poagen: {$count} component(s) skipped — no Generated/Model file emitted:\n");

            foreach ($skippedComponents as $entry) {
                fwrite($stderr, "  - {$entry->rawName} [{$entry->reason}]\n");
            }
        }

        $skippedWebhooks = $plan->skippedWebhooks;

        if ($skippedWebhooks !== []) {
            $count = count($skippedWebhooks);
            fwrite($stderr, "poagen: {$count} webhook(s) skipped — poagen does not generate webhook handlers:\n");

            foreach ($skippedWebhooks as $entry) {
                fwrite($stderr, "  - {$entry->name} [{$entry->reason}]\n");
            }
        }

        // Notices come last and never touch the exit status. Nothing here was
        // omitted — each one names guidance that would make the emitted client
        // more pleasant, which `user-code-guides-generation` is explicit must
        // never be an error.
        foreach ($plan->notices as $notice) {
            fwrite($stderr, "poagen: {$notice}\n");
        }
    }

    /**
     * `--output` overrides one field and must carry every other one.
     *
     * The hand-enumerated copy that did the carrying used to live here and
     * rotted twice — `$inlineModels` and then the three tag maps were each
     * added to `Profile` and silently not carried, so a `--output` run quietly
     * discarded the consumer's guidance and emitted a different tree than a
     * plain run would. It now lives on `Profile` itself, next to the
     * constructor it tracks and shared with the loader, which is the only
     * other caller that needs to replace a field.
     */
    private static function withOutput(Profile $profile, string $output): Profile
    {
        return $profile->with(output: $output);
    }
}
