<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Unit;

use Mlavrinenko\Paogen\Generator\Emit\InlineModelSite;
use PHPUnit\Framework\TestCase;

/**
 * Unit coverage for {@see InlineModelSite} — splitting a
 * `'<operationId>.<position>'` `Profile::$inlineModels` site key on its last
 * dot, and reassembling it.
 */
final class InlineModelSiteTest extends TestCase
{
    public function testARequestSiteSplitsIntoTheOperationIdAndTheLiteralWordRequest(): void
    {
        $site = InlineModelSite::parse('addclient.request');

        self::assertSame('addclient', $site->operationId);
        self::assertSame('request', $site->position);
        self::assertTrue($site->isRequest());
    }

    public function testAResponseSiteSplitsIntoTheOperationIdAndTheStatus(): void
    {
        $site = InlineModelSite::parse('addclient.403');

        self::assertSame('addclient', $site->operationId);
        self::assertSame('403', $site->position);
        self::assertFalse($site->isRequest());
    }

    public function testKeyReassemblesWhatParseSplit(): void
    {
        foreach (['addclient.403', 'addclient.request', 'addclient.default', 'addclient.4XX'] as $raw) {
            self::assertSame($raw, InlineModelSite::parse($raw)->key());
        }
    }
}
