<?php

declare(strict_types=1);

namespace Poagen\Generator\Tests\Integration;

use PHPUnit\Framework\TestCase;
use Poagen\Generator\Exception\UnrepresentableConstructsException;
use Poagen\Generator\Generator\Emit\SkippedWebhook;
use Poagen\Generator\Generator\Emit\WebhookSkipKey;
use Poagen\Generator\Tests\Support\GeneratedTreeSandbox;
use Poagen\Generator\Tests\Support\SkipPlanFixture;

/**
 * webhooks-refuse-with-no-opt-out: a webhook can be named in
 * `Profile::$skip`, keyed `'<webhookName>.webhook'`
 * ({@see WebhookSkipKey}) so it cannot
 * collide with an operation id — the other thing `$skip` already names bare.
 * The default stays a refusal: only an explicit entry turns it off, one
 * webhook at a time, and a document whose webhooks are not all named this
 * way still refuses and names the ones left.
 *
 * Fixture: tests/fixtures/schemas/webhooks-3.1.yaml declares one operation
 * under `paths` (`sendPing`) and two webhooks (`memberCreated`,
 * `orderClosed`), so one document proves "skip all", "skip some" and
 * "skip none" without three fixtures.
 */
final class WebhookSkipTest extends TestCase
{
    use GeneratedTreeSandbox;
    use SkipPlanFixture;

    private const string SCHEMA = __DIR__ . '/../fixtures/schemas/webhooks-3.1.yaml';
    private const string NAMESPACE = 'Poagen\\Generator\\Tests\\Tmp\\WebhookSkip';
    private const string REASON = 'inbound payload, not a client concern';

    public static function tearDownAfterClass(): void
    {
        self::removeSandboxDirs();
    }

    public function testSkippingEveryWebhookGeneratesTheClientFromPathsAlone(): void
    {
        $plan = $this->plan([
            'memberCreated.webhook' => self::REASON,
            'orderClosed.webhook' => self::REASON,
        ]);

        self::assertCount(2, $plan->skippedWebhooks);
        $names = array_map(static fn(SkippedWebhook $webhook): string => $webhook->name, $plan->skippedWebhooks);
        self::assertContains('memberCreated', $names);
        self::assertContains('orderClosed', $names);

        foreach ($plan->skippedWebhooks as $webhook) {
            self::assertSame(self::REASON, $webhook->reason);
        }

        $sources = implode("\n", array_values($plan->writes));
        self::assertStringContainsString('function sendPing(', $sources);
    }

    public function testSkippingSomeButNotAllStillRefusesNamingTheOnesLeft(): void
    {
        try {
            $this->plan(['memberCreated.webhook' => self::REASON]);
            self::fail('expected UnrepresentableConstructsException');
        } catch (UnrepresentableConstructsException $e) {
            $message = $e->getMessage();

            self::assertStringContainsString('1 problem found', $message);
            self::assertStringContainsString('#/webhooks/orderClosed', $message);
            self::assertStringContainsString('onOrderClosed', $message);
            self::assertStringNotContainsString('#/webhooks/memberCreated', $message);
        }
    }

    /**
     * Proves the key is distinguishable from an operation id: a bare webhook
     * name, with no `.webhook` suffix, is not the opt-out spelling — the
     * webhook is refused exactly as if nothing had named it, and the entry
     * itself is reported the same way a skip naming any other absent target
     * is, because nothing under `paths` or `components` is named
     * `memberCreated` either.
     */
    public function testABareWebhookNameWithoutTheSuffixDoesNotSkipIt(): void
    {
        try {
            $this->plan(['memberCreated' => 'wrong spelling, missing the suffix']);
            self::fail('expected UnrepresentableConstructsException');
        } catch (UnrepresentableConstructsException $e) {
            $message = $e->getMessage();

            self::assertStringContainsString('#/webhooks/memberCreated', $message);
            self::assertStringContainsString("Profile::\$skip['memberCreated']", $message);
            self::assertStringContainsString('absent from the schema', $message);
        }
    }

    public function testAStaleWebhookSkipEntryNamingAnAbsentWebhookIsRefused(): void
    {
        try {
            $this->plan([
                'memberCreated.webhook' => self::REASON,
                'orderClosed.webhook' => self::REASON,
                'doesNotExist.webhook' => 'no longer needed',
            ]);
            self::fail('expected UnrepresentableConstructsException');
        } catch (UnrepresentableConstructsException $e) {
            $message = $e->getMessage();

            self::assertStringContainsString("Profile::\$skip['doesNotExist.webhook']", $message);
            self::assertStringContainsString('absent from the schema', $message);
        }
    }
}
