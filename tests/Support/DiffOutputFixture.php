<?php

declare(strict_types=1);

namespace Poagen\Generator\Tests\Support;

/**
 * Shared scaffolding for the `coloured-and-path-filtered-diff-output` CLI
 * tests split across `tests/Integration/DiffColorCliTest.php` and
 * `tests/Integration/DiffPathFilterCliTest.php` — both generate the same
 * tiny `diff-output-3.0.yaml` fixture into a sandbox and need the same
 * profile-file-on-disk boilerplate {@see GeneratedTreeSandbox::runGenerateCommand}
 * requires. Pulled out so the two files describe one concern each (colour,
 * path scope) without jscpd counting the same profile writer twice.
 */
trait DiffOutputFixture
{
    use GeneratedTreeSandbox;

    private const string DIFF_OUTPUT_SCHEMA = __DIR__ . '/../fixtures/schemas/diff-output-3.0.yaml';

    private function writeDiffOutputProfile(string $outputDir, string $namespace): string
    {
        $dir = self::makeSandboxDir('poagen-diff-output-profile-');
        $path = $dir . '/profile.php';

        $schema = var_export(self::DIFF_OUTPUT_SCHEMA, true);
        $output = var_export($outputDir, true);

        file_put_contents($path, <<<PHP
            <?php
            declare(strict_types=1);
            use Poagen\\Generator\\Generator\\Profile;
            return new Profile(
                schema: {$schema},
                output: {$output},
                namespace: '{$namespace}',
            );
            PHP);

        return $path;
    }
}
