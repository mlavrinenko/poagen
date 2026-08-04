<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Integration;

use Mlavrinenko\Paogen\Exception\UnrepresentableConstructsException;
use Mlavrinenko\Paogen\Generator\GenerationPlan;
use Mlavrinenko\Paogen\Generator\Profile;
use Mlavrinenko\Paogen\Runtime\Marshal\XmlWriter;
use Mlavrinenko\Paogen\Tests\Integration\Kilbil\KilbilXmlNestedContainerTest;
use Mlavrinenko\Paogen\Tests\Support\GeneratedTreeSandbox;
use PHPUnit\Framework\TestCase;

use function preg_replace;
use function substr_count;
use function trim;

/**
 * kilbil-xml-nesting-is-unrepresentable: the `'<operationId>.item.<property>'`
 * form of `Profile::$xmlElements`, and the runtime `XmlWriter` constructor
 * config it documents.
 *
 * {@see KilbilXmlNestedContainerTest}
 * carries the end-to-end proof against the vendor's own samples; this file
 * covers the two pieces that make that possible in isolation — the profile
 * validating (or refusing to) and the writer itself wrapping instead of
 * unwrapping.
 */
final class XmlNestedContainerTest extends TestCase
{
    use GeneratedTreeSandbox;

    private const string SCHEMA = __DIR__ . '/../../examples/kilbil/schemas/loyalty_v1.yaml';
    private const string NAMESPACE = 'Mlavrinenko\\Paogen\\Tests\\Tmp\\KilbilXmlNested';

    /** @var array<string,string> */
    private const array ELEMENTS = [
        'goodsxml' => 'goods',
        'goodsxml.item' => 'good',
        'goodsxml.item.inside' => 'good',
        'goodslistxml' => 'goodslist',
        'goodslistxml.item' => 'goodlist',
        'goodslistxml.item.inside' => 'goodlist',
    ];

    public static function tearDownAfterClass(): void
    {
        self::removeSandboxDirs();
    }

    public function testTheProfileExpressesANestedContainerAndValidatesCleanly(): void
    {
        $plan = $this->plan(self::ELEMENTS);

        // Nothing about the nested-container entries changes what gets
        // emitted — Endpoint::xmlList() still only takes root and item — so
        // the same 36 operations that generate without them still do with
        // them.
        self::assertSame([], $plan->skippedOperations);
        self::assertNotSame([], $plan->writes);
    }

    public function testANestedBindingNamingAnAbsentPropertyFailsTheRun(): void
    {
        $elements = [...self::ELEMENTS, 'goodsxml.item.no_such_property' => 'good'];

        try {
            $this->plan($elements);
            self::fail('expected UnrepresentableConstructsException');
        } catch (UnrepresentableConstructsException $e) {
            $message = $e->getMessage();

            self::assertStringContainsString('goodsxml.item.no_such_property', $message);
            self::assertStringContainsString('no_such_property', $message);
            self::assertStringContainsString('goodsxml', $message);
        }
    }

    public function testANestedBindingNamingAnAbsentOperationFailsTheRun(): void
    {
        $elements = [...self::ELEMENTS, 'no_such_operation.item.inside' => 'good'];

        try {
            $this->plan($elements);
            self::fail('expected UnrepresentableConstructsException');
        } catch (UnrepresentableConstructsException $e) {
            $message = $e->getMessage();

            self::assertStringContainsString('no_such_operation.item.inside', $message);
            self::assertStringContainsString('operation id absent from the schema', $message);
        }
    }

    public function testTheWriterWrapsAConfiguredNestedArrayInANamedContainer(): void
    {
        $writer = new XmlWriter(['good' => ['inside' => 'good']]);

        $xml = $writer->renderList(
            [['code' => 'A1', 'inside' => [['code' => 'B1'], ['code' => 'B2']]]],
            'goods',
            'good',
        );

        // One <inside>, wrapping two repeated <good> children — not two
        // sibling <inside> elements, which is the defect this task fixes.
        self::assertSame(1, substr_count($xml, '<inside>'));
        self::assertStringContainsString('<inside><good><code>B1</code></good><good><code>B2</code></good></inside>', $this->collapsed($xml));
    }

    public function testTheWriterLeavesAnUnconfiguredNestedArrayUnwrappedByteForByte(): void
    {
        $payload = ['code' => 'A1', 'inside' => [['code' => 'B1'], ['code' => 'B2']]];

        // Same payload, no config at all — AC5: a body that needs no
        // nesting renders exactly as it always has.
        $withEmptyConfig = new XmlWriter([])->renderList([$payload], 'goods', 'good');
        $withNoConfig = new XmlWriter()->renderList([$payload], 'goods', 'good');

        self::assertSame($withNoConfig, $withEmptyConfig);
        self::assertSame(2, substr_count($withNoConfig, '<inside>'));
        self::assertStringContainsString('<inside><code>B1</code></inside>', $this->collapsed($withNoConfig));
        self::assertStringContainsString('<inside><code>B2</code></inside>', $this->collapsed($withNoConfig));
    }

    public function testAConfiguredContainerOnlyAppliesUnderItsOwnEnclosingElement(): void
    {
        // 'inside' means "wrap" under a <good>, but this payload is rendered
        // directly under the root ('goods'), which the config says nothing
        // about — it must fall back to the OpenAPI default rather than
        // wrapping anywhere a property named 'inside' happens to appear.
        $writer = new XmlWriter(['good' => ['inside' => 'good']]);

        $xml = $writer->renderObject(['inside' => [['code' => 'B1'], ['code' => 'B2']]], 'goods');

        self::assertSame(2, substr_count($xml, '<inside>'));
    }

    private function collapsed(string $xml): string
    {
        $withoutProlog = (string) preg_replace('/^<\?xml[^>]*\?>\s*/', '', $xml);

        return (string) preg_replace('/>\s+</', '><', trim($withoutProlog));
    }

    /**
     * @param array<string,string> $xmlElements
     */
    private function plan(array $xmlElements): GenerationPlan
    {
        return self::generator()->plan(new Profile(
            schema: self::SCHEMA,
            output: self::makeSandboxDir('paogen-xml-nested-'),
            namespace: self::NAMESPACE,
            xmlElements: $xmlElements,
        ));
    }
}
