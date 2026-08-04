<?php

declare(strict_types=1);

namespace Poagen\Generator\Tests\Integration\Kilbil;

use Acme\Kilbil\Generated\Model\GoodsListXmlRequestContentItem;
use Acme\Kilbil\Generated\Model\GoodsListXmlRequestContentItemInsideItem;
use Acme\Kilbil\Generated\Model\GoodsXmlRequestContentItem;
use cebe\openapi\Reader;
use cebe\openapi\spec\MediaType;
use cebe\openapi\spec\OpenApi;
use cebe\openapi\spec\Operation;
use cebe\openapi\spec\RequestBody;
use DOMDocument;
use DOMElement;
use DOMText;
use PHPUnit\Framework\TestCase;
use Poagen\Generator\Tests\Generated\RecordingClient;

use function assert;
use function is_string;
use function preg_match;
use function preg_replace;
use function trim;
use function usort;

/**
 * kilbil-xml-nesting-is-unrepresentable, acceptance criterion 2: the two
 * kilbil XML operations emit a body structurally matching the vendor's own
 * samples at schemas/loyalty_v1.yaml lines 4305 (`/load/goodsxml`) and 4570
 * (`/load/goodslistxml`) — proven here by parsing both the vendor's own
 * embedded `example:` text and the real, committed `ApiClient`'s emitted
 * request body with `DOMDocument`, and comparing the two trees
 * structurally, rather than by reading either XML string.
 *
 * Runs the real generated `CatalogueClient` over the real `HttpTransport`
 * against an in-memory PSR-18 stub ({@see KilbilHttpHarness}) — the same
 * harness `KilbilRequestAndErrorTest` uses, with no custom `XmlWriter` at
 * all: `goodsXml()`/`goodsListXml()` now carry the nested-container map
 * themselves (thread-the-validated-nested-container-map-into-the-generated-client),
 * so the plain default transport a consumer gets from README.md is enough.
 *
 * `/load/goodsxml`'s own sample is not well-formed XML — an unclosed
 * `<SKU>` tag, and a second group missing its own opening `<good>` — so the
 * full document cannot be parsed. The first `<inside>...</inside>` block is
 * internally well-formed on its own, and is the one this task's defect is
 * about, so that is what gets compared. `/load/goodslistxml`'s sample has
 * no such defect, so its comparison covers the whole rendered body.
 */
final class KilbilXmlNestedContainerTest extends TestCase
{
    private static ?OpenApi $openApi = null;

    public static function setUpBeforeClass(): void
    {
        KilbilGeneratedAutoload::register();
    }

    public function testGoodsXmlNestedInsideMatchesTheVendorSample(): void
    {
        $http = new RecordingClient(KilbilHttpHarness::jsonResponse(200, '{"result_code":"0"}'));
        $client = KilbilHttpHarness::client($http);

        $client->catalogue()->goodsXml([new GoodsXmlRequestContentItem(
            code: '1',
            name: 'Название группы',
            is_group: 1,
            delete_mark: 0,
            full_name: '',
            // The vendor's own sample has an unclosed <SKU> tag right here
            // (schemas/loyalty_v1.yaml:4316) — the value itself, not this
            // task's nesting, so it is carried over corrected rather than
            // reproduced broken.
            SKU: 'd9ad966b-3098-11e7-922d-002381219ac7',
            inside: [
                [
                    'is_group' => 0, 'delete_mark' => 0, 'code' => '704',
                    'name' => 'Наименование товара', 'full_name' => 'Полное наименование товара',
                    'variant' => 'Синий, 39', 'SKU' => '55cd3f03-cb38-11e7-8376-58fb84fa9d6b',
                    'price1' => 10, 'price2' => 10, 'price3' => 10,
                ],
                [
                    'is_group' => 0, 'delete_mark' => 0, 'code' => '608',
                    'name' => 'Наименование товара', 'full_name' => 'Полное наименование товара',
                    'variant' => 'Синий, 39', 'SKU' => '7f8431b6-a1e9-11e7-b80e-58fb84fa9d6b',
                    'price1' => 10, 'price2' => 10, 'price3' => 10,
                ],
            ],
        )]);

        $body = (string) $http->lastRequest?->getBody();
        $rendered = $this->rootOf($body);

        self::assertSame('goods', $rendered->tagName);
        $goodElements = $this->directChildren($rendered, 'good');
        self::assertCount(1, $goodElements);

        $insideElements = $this->directChildren($goodElements[0], 'inside');
        // The regression this task fixes: one <inside> wrapping its
        // children, not one <inside> per entry.
        self::assertCount(1, $insideElements);
        self::assertCount(2, $this->directChildren($insideElements[0], 'good'));

        $vendorInside = $this->firstVendorInside('goodsxml');
        self::assertSame(self::signature($vendorInside), self::signature($insideElements[0]));
    }

    public function testGoodsListXmlMatchesTheVendorSampleWholesale(): void
    {
        $http = new RecordingClient(KilbilHttpHarness::jsonResponse(200, '{"result_code":"0"}'));
        $client = KilbilHttpHarness::client($http);

        $client->catalogue()->goodsListXml([new GoodsListXmlRequestContentItem(
            ID: 393,
            inside: [
                new GoodsListXmlRequestContentItemInsideItem(code: '704', variant: 'Синий, 39', K: 2.0),
                new GoodsListXmlRequestContentItemInsideItem(code: '608', K: 1.0),
                new GoodsListXmlRequestContentItemInsideItem(code: '610', K: 3.0),
            ],
        )]);

        $body = (string) $http->lastRequest?->getBody();
        $rendered = $this->rootOf($body);

        // The vendor's own goodslistxml sample is well-formed end to end
        // (schemas/loyalty_v1.yaml:4570), so the whole tree is compared, not
        // just the nested fragment.
        $vendorRoot = $this->vendorSampleRoot('goodslistxml');
        self::assertSame(self::signature($vendorRoot), self::signature($rendered));
    }

    /**
     * Parses `$xml` as UTF-8 regardless of what prolog (if any) it carries.
     * The vendor's own samples declare `windows-1251`
     * (schemas/loyalty_v1.yaml:4304, :4569) but the schema file itself, and
     * therefore the Cyrillic text `Reader` hands back, is UTF-8 — libxml
     * would otherwise mis-decode every Cyrillic byte trusting that stale
     * declaration.
     */
    private function rootOf(string $xml): DOMElement
    {
        $withoutProlog = (string) preg_replace('/^\s*<\?xml[^>]*\?>\s*/', '', $xml);
        $document = new DOMDocument();
        $document->loadXML('<?xml version="1.0" encoding="UTF-8"?>' . "\n" . $withoutProlog);
        $root = $document->documentElement;
        assert($root instanceof DOMElement);

        return $root;
    }

    /**
     * @return list<DOMElement>
     */
    private function directChildren(DOMElement $parent, string $tag): array
    {
        $out = [];

        foreach ($parent->childNodes as $node) {
            if ($node instanceof DOMElement && $node->tagName === $tag) {
                $out[] = $node;
            }
        }

        return $out;
    }

    /**
     * The document's own literal `example:` text for `$operationId`'s
     * `application/xml` request body — read from the schema rather than
     * copied into this file, so a vendor edit to the sample is what a
     * future run would compare against, not a snapshot of it.
     */
    private function vendorExample(string $operationId): string
    {
        $openApi = $this->schema();
        $path = $operationId === 'goodsxml' ? '/load/goodsxml' : '/load/goodslistxml';
        $operation = $openApi->paths?->getPath($path)?->post;
        assert($operation instanceof Operation);

        $body = $operation->requestBody;
        assert($body instanceof RequestBody);
        $media = $body->content['application/xml'] ?? null;
        assert($media instanceof MediaType);
        $example = $media->example;
        assert(is_string($example));

        return $example;
    }

    private function schema(): OpenApi
    {
        self::$openApi ??= Reader::readFromYamlFile(
            __DIR__ . '/../../../examples/kilbil/schemas/loyalty_v1.yaml',
            OpenApi::class,
            false,
        );

        return self::$openApi;
    }

    private function vendorSampleRoot(string $operationId): DOMElement
    {
        return $this->rootOf($this->vendorExample($operationId));
    }

    /**
     * The first `<inside>...</inside>` fragment out of the goodsxml sample
     * — internally well-formed even though the sample around it is not
     * (see the class docblock) — parsed as its own document.
     */
    private function firstVendorInside(string $operationId): DOMElement
    {
        $matched = preg_match('/<inside>.*?<\/inside>/s', $this->vendorExample($operationId), $matches);
        self::assertSame(1, $matched, 'expected an <inside>...</inside> fragment in the vendor sample');

        return $this->rootOf($matches[0]);
    }

    /**
     * A structural, order-insensitive fingerprint of an element: its tag,
     * its own text, and the same fingerprint of every child element —
     * comparable with a plain `assertSame()` regardless of the two trees'
     * attribute formatting or field order.
     *
     * @return array{tag:string,text:string,children:list<mixed>}
     */
    private static function signature(DOMElement $element): array
    {
        $children = [];
        $text = '';

        foreach ($element->childNodes as $node) {
            if ($node instanceof DOMElement) {
                $children[] = self::signature($node);
            } elseif ($node instanceof DOMText) {
                $text .= $node->wholeText;
            }
        }

        usort($children, static fn(array $a, array $b): int => $a <=> $b);

        return ['tag' => $element->tagName, 'text' => trim($text), 'children' => $children];
    }
}
