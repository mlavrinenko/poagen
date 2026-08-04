<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Unit;

use Mlavrinenko\Paogen\Generator\Emit\WebhookSkipKey;
use PHPUnit\Framework\TestCase;

/**
 * Unit coverage for {@see WebhookSkipKey} — the `Profile::$skip` key
 * spelling for a webhook, `'<webhookName>.webhook'`, and telling it apart
 * from a bare operation id or component name.
 */
final class WebhookSkipKeyTest extends TestCase
{
    public function testForNameAppendsTheWebhookSuffix(): void
    {
        self::assertSame('memberCreated.webhook', WebhookSkipKey::forName('memberCreated'));
    }

    public function testWebhookNameOfRecoversTheNameFromASuffixedKey(): void
    {
        self::assertSame('memberCreated', WebhookSkipKey::webhookNameOf('memberCreated.webhook'));
    }

    public function testWebhookNameOfReturnsNullForABareOperationIdOrComponentName(): void
    {
        self::assertNull(WebhookSkipKey::webhookNameOf('memberCreated'));
        self::assertNull(WebhookSkipKey::webhookNameOf('addclient.request'));
        self::assertNull(WebhookSkipKey::webhookNameOf('addclient.403'));
    }
}
