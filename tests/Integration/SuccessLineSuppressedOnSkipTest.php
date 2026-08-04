<?php

declare(strict_types=1);

namespace Poagen\Generator\Tests\Integration;

use PHPUnit\Framework\TestCase;
use Poagen\Generator\Tests\Support\GeneratedTreeSandbox;

/**
 * default-deny-on-degradation: `poagen generate`'s plain success line
 * ("poagen: generated into ...") claims every operation and component made
 * it into the client. That claim is false the moment anything was skipped —
 * even a skip the profile explicitly accepted is still an omission — so a
 * run that skipped or degraded anything must not open by announcing success.
 *
 * Uses tests/fixtures/schemas/response-degradation-3.0.yaml with all three
 * remaining unrepresentable responses accepted via Profile::$skip, so the
 * run completes (exit 0) with a non-empty skippedOperations list.
 * `getPlainText` left that set in
 * represent-non-json-request-and-response-bodies — a `text/*` response over
 * a `type: string` schema is representable — and `getBinaryBlob` made the
 * identical move in
 * return-a-binary-2xx-as-the-stream-a-done-task-already-promised.
 */
final class SuccessLineSuppressedOnSkipTest extends TestCase
{
    use GeneratedTreeSandbox;

    private const string SCHEMA = __DIR__ . '/../fixtures/schemas/response-degradation-3.0.yaml';

    public static function tearDownAfterClass(): void
    {
        self::removeSandboxDirs();
    }

    public function testTheSuccessLineIsNotPrintedWhenAnAcceptedSkipDroppedAnOperation(): void
    {
        [$exit, $stdout, $stderr] = $this->invokeGenerate();

        self::assertSame(0, $exit);
        self::assertStringNotContainsString('generated into', $stdout);
        self::assertStringContainsString('3 operation(s) skipped', $stderr);
    }

    /**
     * @return array{0:int,1:string,2:string}
     */
    private function invokeGenerate(): array
    {
        $outputDir = self::makeSandboxDir('poagen-success-line-');
        $profilePath = $this->writeProfile($outputDir);

        return self::runGenerateCommand([$profilePath]);
    }

    private function writeProfile(string $outputDir): string
    {
        $dir = self::makeSandboxDir('poagen-success-line-profile-');
        $path = $dir . '/profile.php';

        $schema = var_export(self::SCHEMA, true);
        $output = var_export($outputDir, true);

        file_put_contents($path, <<<PHP
            <?php
            declare(strict_types=1);
            use Poagen\\Generator\\Generator\\Profile;
            return new Profile(
                schema: {$schema},
                output: {$output},
                namespace: 'Poagen\\\\Generator\\\\Tests\\\\Tmp\\\\SuccessLineSuppressed',
                skip: [
                    'getXmlLabel' => 'application/xml not decoded',
                    'getBrokenRef' => 'broken \$ref, fix the schema',
                    'listInlineItems' => 'inline array items unsupported',
                ],
            );
            PHP);

        return $path;
    }
}
