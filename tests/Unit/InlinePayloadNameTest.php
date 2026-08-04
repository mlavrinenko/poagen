<?php

declare(strict_types=1);

namespace Poagen\Generator\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Poagen\Generator\Generator\Naming\InlinePayloadName;

/**
 * Unit coverage for {@see InlinePayloadName} — the one derivation rule
 * `name-inline-schemas-by-operation-and-status` adds:
 * `{OperationId}{Position}Content`, read two ways.
 */
final class InlinePayloadNameTest extends TestCase
{
    public function testARequestBodyIsNamedWithTheLiteralWordRequest(): void
    {
        self::assertSame('AddClientRequestContent', InlinePayloadName::request('AddClient'));
    }

    public function testARequestBodyThatIsAnArrayOfObjectsGetsAnItemSuffix(): void
    {
        self::assertSame('AddClientRequestContentItem', InlinePayloadName::request('AddClient', item: true));
    }

    public function testAnOrdinaryNumericStatusIsSpelledVerbatim(): void
    {
        self::assertSame('AddClient200Content', InlinePayloadName::response('AddClient', '200'));
        self::assertSame('AddClient403Content', InlinePayloadName::response('AddClient', '403'));
    }

    public function testAResponseThatIsAnArrayOfObjectsGetsAnItemSuffix(): void
    {
        self::assertSame('AddClient200ContentItem', InlinePayloadName::response('AddClient', '200', item: true));
    }

    /**
     * The `default` key and a range key such as `4XX` are spelled exactly as
     * the document writes them — no case normalisation, unlike a component or
     * operation id.
     */
    public function testTheDefaultKeyAndARangeKeyAreSpelledAsTheDocumentWritesThem(): void
    {
        self::assertSame('AddClientdefaultContent', InlinePayloadName::response('AddClient', 'default'));
        self::assertSame('AddClient4XXContent', InlinePayloadName::response('AddClient', '4XX'));
    }

    /**
     * A status key with a character outside `[A-Za-z0-9_]` is mangled only as
     * far as making it a legal PHP identifier fragment requires.
     */
    public function testAStatusWithAnIllegalCharacterIsMangledToAnUnderscore(): void
    {
        self::assertSame('AddClient2_XContent', InlinePayloadName::response('AddClient', '2-X'));
    }

    public function testStatusTokenIsTheSameMangleTheDerivationUses(): void
    {
        self::assertSame('4XX', InlinePayloadName::statusToken('4XX'));
        self::assertSame('default', InlinePayloadName::statusToken('default'));
        self::assertSame('2_X', InlinePayloadName::statusToken('2-X'));
    }
}
