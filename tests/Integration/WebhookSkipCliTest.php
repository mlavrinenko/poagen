<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Integration;

use Mlavrinenko\Paogen\Tests\Support\GeneratedTreeSandbox;
use PHPUnit\Framework\TestCase;

/**
 * webhooks-refuse-with-no-opt-out, CLI surface: `paogen generate` reports an
 * accepted webhook skip the same way it reports a skipped operation or
 * component — a written reason, a printed count, and a suppressed plain
 * success line, because an accepted skip is still an omission
 * (default-deny-on-degradation). Uses the same fixture as
 * {@see WebhookSkipTest}, via a profile file written to a temp path
 * (`GenerateCommand::run()` takes a profile *file path*, not a `Profile`).
 */
final class WebhookSkipCliTest extends TestCase
{
    use GeneratedTreeSandbox;

    private const string SCHEMA = __DIR__ . '/../fixtures/schemas/webhooks-3.1.yaml';

    public static function tearDownAfterClass(): void
    {
        self::removeSandboxDirs();
    }

    public function testSuccessLineIsSuppressedAndTheSkippedWebhooksAreReported(): void
    {
        $outputDir = self::makeSandboxDir('paogen-webhook-skip-cli-');
        $profilePath = $this->writeProfile($outputDir, [
            'memberCreated.webhook' => 'inbound payload, not a client concern',
            'orderClosed.webhook' => 'inbound payload, not a client concern',
        ]);

        [$exit, $stdout, $stderr] = self::runGenerateCommand([$profilePath]);

        self::assertSame(0, $exit);
        self::assertStringNotContainsString('generated into', $stdout);
        self::assertStringContainsString('2 webhook(s) skipped', $stderr);
        self::assertStringContainsString('memberCreated', $stderr);
        self::assertStringContainsString('orderClosed', $stderr);
        self::assertStringContainsString('inbound payload, not a client concern', $stderr);
    }

    public function testAPlainGenerateRefusesWhenNoWebhookIsSkipped(): void
    {
        $outputDir = self::makeSandboxDir('paogen-webhook-skip-cli-');
        $profilePath = $this->writeProfile($outputDir, []);

        [$exit, $stdout, $stderr] = self::runGenerateCommand([$profilePath]);

        self::assertSame(1, $exit);
        self::assertStringNotContainsString('generated into', $stdout);
        self::assertStringContainsString('#/webhooks/memberCreated', $stderr);
        self::assertStringContainsString('#/webhooks/orderClosed', $stderr);
    }

    /**
     * @param  array<string,string> $skip
     */
    private function writeProfile(string $outputDir, array $skip): string
    {
        $dir = self::makeSandboxDir('paogen-webhook-skip-cli-profile-');
        $path = $dir . '/profile.php';

        $schema = var_export(self::SCHEMA, true);
        $output = var_export($outputDir, true);
        $skipExport = var_export($skip, true);

        file_put_contents($path, <<<PHP
            <?php
            declare(strict_types=1);
            use Mlavrinenko\\Paogen\\Generator\\Profile;
            return new Profile(
                schema: {$schema},
                output: {$output},
                namespace: 'Mlavrinenko\\\\Paogen\\\\Tests\\\\Tmp\\\\WebhookSkipCli',
                skip: {$skipExport},
            );
            PHP);

        return $path;
    }
}
