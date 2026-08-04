<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Integration;

use cebe\openapi\Reader;
use cebe\openapi\spec\OpenApi;
use cebe\openapi\spec\Operation;
use cebe\openapi\spec\PathItem;
use cebe\openapi\spec\Reference;
use Mlavrinenko\Paogen\Generator\Emit\EnvelopeResponsePlanner;
use Mlavrinenko\Paogen\Generator\Emit\ResponseAnalyzer;
use Mlavrinenko\Paogen\Generator\Emit\SchemaWalk;
use Mlavrinenko\Paogen\Generator\GenerationPlan;
use Mlavrinenko\Paogen\Generator\Profile;
use Mlavrinenko\Paogen\Tests\Support\GeneratedTreeSandbox;
use Mlavrinenko\Paogen\Tests\Unit\SchemaWalkTest;
use PHPUnit\Framework\TestCase;

/**
 * response-analyzer-picks-a-2xx-without-resolving-a-ref.
 *
 * Before `typed-error-responses` folded every status into
 * {@see EnvelopeResponsePlanner}, the
 * picked-2xx-only reading tested `instanceof Response` directly and a `$ref`
 * to `components.responses` fell through as if the operation declared no
 * body at all, silently earning `void` — the same blindness
 * {@see SchemaWalk} had for the schema
 * walk, fixed separately (`a-referenced-response-component-is-invisible-to-
 * the-schema-walk`). `EnvelopeResponsePlanner::plan()` now resolves a
 * `Reference` response for every status before it ever reaches
 * {@see ResponseAnalyzer}, so by the time
 * that class sees a response it is always a concrete
 * `cebe\openapi\spec\Response` — never the `Reference` it used to be blind
 * to.
 *
 * This test proves the *return type* stays identical across the two ways of
 * declaring the same content, using a JSON body so a real Model return type
 * is on both sides to compare —
 * {@see SchemaWalkTest} already proves the
 * schema-walk side of the same parity with DigitalOcean's `invoice_pdf`
 * shape (a binary body, which never earns a return type either way).
 *
 * Reverting `EnvelopeResponsePlanner`'s `Reference` resolution (the
 * `if ($response instanceof Reference) { ... }` block ahead of
 * `planOneStatus()`) fails this test: `referencedWidget` reverts to `void`
 * while `inlineWidget` keeps resolving to `Widget`, so the two responses the
 * fixture declares as byte-identical stop agreeing.
 */
final class ResponseRefReturnTypeParityTest extends TestCase
{
    use GeneratedTreeSandbox;

    private const string SCHEMA = __DIR__ . '/../fixtures/schemas/response-ref-return-type-parity-3.0.yaml';
    private const string NAMESPACE = 'Mlavrinenko\\Paogen\\Tests\\Tmp\\ResponseRefReturnTypeParity';

    public static function tearDownAfterClass(): void
    {
        self::removeSandboxDirs();
    }

    /**
     * Establishes the fixture's premise: `referencedWidget`'s `200` really
     * is a `Reference` in the parsed document, not an inline `Response` —
     * otherwise the rest of this test would exercise nothing.
     */
    public function testTheReferencedOperationsResponseIsGenuinelyAReferenceInTheParsedDocument(): void
    {
        $openApi = Reader::readFromYamlFile(self::SCHEMA, OpenApi::class, false);
        self::assertInstanceOf(OpenApi::class, $openApi);

        $item = $openApi->paths?->getPath('/referenced');
        self::assertInstanceOf(PathItem::class, $item);
        self::assertInstanceOf(Operation::class, $item->get);

        self::assertInstanceOf(Reference::class, $item->get->responses?->getResponse('200'));
    }

    public function testAReferencedResponseEarnsTheSameReturnTypeAsTheIdenticalInlineOne(): void
    {
        $client = self::plannedSource($this->plan()->writes, 'ApiClient');

        self::assertStringContainsString('function inlineWidget(): Envelope', $client);
        self::assertStringContainsString('function referencedWidget(): Envelope', $client);

        // Same expression, same doc type, on both methods — the fixture's
        // whole point is that a $ref response earns exactly what an inline
        // copy of the identical content would have earned, not merely
        // "some" Model.
        $expectedExpr = "ResponseType::envelope(new StatusResponseMap(exact: [['200', "
            . 'ResponseType::object(Widget::class)]]))';

        self::assertStringContainsString($expectedExpr, self::methodSlice($client, 'inlineWidget'));
        self::assertStringContainsString($expectedExpr, self::methodSlice($client, 'referencedWidget'));

        // Both methods' preceding @return tag narrows to the identical
        // Envelope<Widget> — one occurrence per method, not one shared
        // between them.
        self::assertSame(2, substr_count($client, '@return Envelope<Widget>'));
    }

    private function plan(): GenerationPlan
    {
        return self::generator()->plan(new Profile(
            schema: self::SCHEMA,
            output: self::makeSandboxDir('paogen-response-ref-return-type-parity-'),
            namespace: self::NAMESPACE,
        ));
    }
}
