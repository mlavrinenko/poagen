<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Integration;

use Mlavrinenko\Paogen\Exception\UnrepresentableConstructsException;
use Mlavrinenko\Paogen\Generator\GenerationPlan;
use Mlavrinenko\Paogen\Generator\Profile;
use Mlavrinenko\Paogen\Runtime\Marshal\Marshaller;
use Mlavrinenko\Paogen\Runtime\Marshal\XmlWriter;
use Mlavrinenko\Paogen\Tests\Support\GeneratedTreeSandbox;
use Mlavrinenko\Paogen\Tests\Unit\Runtime\Fixtures\Contact;
use PHPUnit\Framework\TestCase;

use function json_encode;

use const DIRECTORY_SEPARATOR;
use const JSON_THROW_ON_ERROR;

/**
 * xml-content-type-policy: an `application/xml` request body is serialised, and
 * the element names the specification does not supply are asked for.
 *
 * See `truth/decisions/xml-request-bodies-are-serialised-not-refused.decision-260730.typ`
 * for why serialising beat refusing: the schema is fully declared, every response
 * in the corpus is JSON so XML is request-only and bounded, and refusing would
 * have cost two of kilbil's thirty-six operations over the last step of a pipeline
 * that already had every earlier one.
 */
final class XmlRequestBodyTest extends TestCase
{
    use GeneratedTreeSandbox;

    private const string SCHEMA = __DIR__ . '/../../examples/kilbil/schemas/loyalty_v1.yaml';
    private const string NAMESPACE = 'Mlavrinenko\\Paogen\\Tests\\Tmp\\KilbilXml';

    /** @var array<string,string> */
    private const array ELEMENTS = [
        'goodsxml' => 'goods',
        'goodsxml.item' => 'good',
        'goodslistxml' => 'goodslist',
        'goodslistxml.item' => 'good',
    ];

    public static function tearDownAfterClass(): void
    {
        self::removeSandboxDirs();
    }

    public function testAnXmlBodyWithNamedElementsIsEmittedAndTyped(): void
    {
        $surface = $this->callerSurface($this->plan(self::ELEMENTS));

        // Typed exactly as the JSON twin is — the schema is the same, only the
        // encoding differs.
        // No methodRenames here, so the method keeps the vendor's spelling.
        self::assertStringContainsString('public function goodsxml(array $body', $surface);
        self::assertStringContainsString('GoodsxmlRequestContentItem> $body', $surface);
        // The element names the document supplies travel with the body; how it
        // is rendered and which content type it carries are the transport's.
        self::assertStringContainsString("->xmlList(\$body, 'goods', 'good')", $surface);
        self::assertStringNotContainsString('Content-Type', $surface);
    }

    public function testTheMarshallerStaysInThePathSoBothContentTypesAgree(): void
    {
        // Wire names, scalar bindings and date formats are decided once, not
        // twice differently: the writer renders what the marshaller produced,
        // so a `#[WireName]` that JSON honours reaches the XML too.
        $marshalled = new Marshaller()->marshal(new Contact('Grace'));

        self::assertSame('{"display-name":"Grace","email":null}', json_encode($marshalled, JSON_THROW_ON_ERROR));
        self::assertStringContainsString(
            '<display-name>Grace</display-name>',
            new XmlWriter()->renderObject($marshalled, 'contact'),
        );
    }

    public function testEveryOperationInTheDocumentIsEmittedOnceXmlIsHandled(): void
    {
        $plan = $this->plan(self::ELEMENTS);

        self::assertSame([], $plan->skippedOperations);
        self::assertSame(36, $this->operationMethodCount($plan));
    }

    public function testAnXmlBodyWithNoNamedRootFailsTheRunRatherThanInventingOne(): void
    {
        try {
            $this->plan([]);
            self::fail('expected UnrepresentableConstructsException');
        } catch (UnrepresentableConstructsException $e) {
            $message = $e->getMessage();

            // A guessed root element does not fail visibly — it produces
            // well-formed XML the vendor rejects at runtime.
            self::assertStringContainsString('goodsxml', $message);
            self::assertStringContainsString('application/xml', $message);

            // default-deny-on-degradation: the diagnostic used to describe a
            // limitation that no longer holds ("paogen supports
            // application/json ... and application/x-www-form-urlencoded ...
            // only") and pointed at the skip list, even though XML request
            // bodies are implemented — the actual remedy is naming the root
            // element in Profile::$xmlElements.
            self::assertStringContainsString('Profile::$xmlElements', $message);
            self::assertStringNotContainsString(
                'paogen supports application/json',
                $message,
                'the stale "XML is unsupported" message should not resurface',
            );
        }
    }

    public function testTheWriterFollowsTheOpenApiElementDefaults(): void
    {
        $xml = new XmlWriter()->renderList(
            [['code' => 'A1', 'BC' => ['111', '222'], 'is_group' => 0, 'full_name' => null]],
            'goods',
            'good',
        );

        // A property becomes an element of the same name; an array is unwrapped,
        // so its element repeats; an absent optional property is absent rather
        // than an empty element, because `<full_name/>` and "no full_name" mean
        // different things to a parser.
        self::assertStringContainsString('<goods>', $xml);
        self::assertStringContainsString('<good>', $xml);
        self::assertStringContainsString('<code>A1</code>', $xml);
        self::assertStringContainsString('<BC>111</BC>', $xml);
        self::assertStringContainsString('<BC>222</BC>', $xml);
        self::assertStringContainsString('<is_group>0</is_group>', $xml);
        self::assertStringNotContainsString('full_name', $xml);
    }

    public function testTheWriterSpellsBooleansAsJsonEncodeDoes(): void
    {
        $xml = new XmlWriter()->renderObject(['active' => true, 'archived' => false], 'item');

        self::assertStringContainsString('<active>true</active>', $xml);
        self::assertStringContainsString('<archived>false</archived>', $xml);
    }

    public function testTheWriterIsByteStable(): void
    {
        $payload = ['code' => 'A1', 'nested' => ['a' => 1, 'b' => 2]];

        self::assertSame(
            new XmlWriter()->renderObject($payload, 'item'),
            new XmlWriter()->renderObject($payload, 'item'),
        );
    }

    /**
     * @param array<string,string> $xmlElements
     */
    private function plan(array $xmlElements): GenerationPlan
    {
        return self::generator()->plan(new Profile(
            schema: self::SCHEMA,
            output: self::makeSandboxDir('paogen-xml-'),
            namespace: self::NAMESPACE,
            xmlElements: $xmlElements,
        ));
    }

    private function callerSurface(GenerationPlan $plan): string
    {
        $out = '';

        foreach ($plan->writes as $path => $source) {
            if (!str_contains($path, DIRECTORY_SEPARATOR . 'Model' . DIRECTORY_SEPARATOR)
                && !str_contains($path, DIRECTORY_SEPARATOR . 'Enum' . DIRECTORY_SEPARATOR)) {
                $out .= $source . "\n";
            }
        }

        return $out;
    }

    /**
     * Counts operation methods on the emitted classes, skipping the interfaces
     * that mirror them and the constructors and tag accessors.
     */
    private function operationMethodCount(GenerationPlan $plan): int
    {
        $count = 0;

        foreach ($plan->writes as $path => $source) {
            if (!str_ends_with($path, 'Client.php')) {
                continue;
            }

            preg_match_all('/^    public function (\w+)\(/m', $source, $matches);

            foreach ($matches[1] as $name) {
                // A tag accessor takes no arguments and returns an interface; an
                // operation method always has a body or parameters. Distinguish on
                // the return type instead, which is unambiguous.
                if ($name !== '__construct' && preg_match('/public function ' . $name . '\(\): \w+ClientInterface/', $source) !== 1) {
                    ++$count;
                }
            }
        }

        return $count;
    }
}
