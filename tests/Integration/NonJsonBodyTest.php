<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Integration;

use Mlavrinenko\Paogen\Exception\UnrepresentableConstructsException;
use Mlavrinenko\Paogen\Generator\GenerationPlan;
use Mlavrinenko\Paogen\Generator\Profile;
use Mlavrinenko\Paogen\Tests\Support\GeneratedTreeSandbox;
use PHPUnit\Framework\TestCase;

use function array_values;
use function implode;
use function substr_count;

/**
 * represent-non-json-request-and-response-bodies: six operations across the
 * vendored profiles were refused for their media type alone, and the payloads
 * behind them are a string and a stream.
 *
 * Fixture: tests/fixtures/schemas/non-json-bodies-3.0.yaml, whose header
 * records which vendored operation each path was read from.
 */
final class NonJsonBodyTest extends TestCase
{
    use GeneratedTreeSandbox;

    private const string SCHEMA = __DIR__ . '/../fixtures/schemas/non-json-bodies-3.0.yaml';
    private const string NAMESPACE = 'Mlavrinenko\\Paogen\\Tests\\Tmp\\NonJsonBodies';

    public static function tearDownAfterClass(): void
    {
        self::removeSandboxDirs();
    }

    public function testSeveralTextContentTypesOnOneBodyStayOneMethod(): void
    {
        $sources = $this->sources();

        // GitHub declares text/plain and text/x-markdown over the same
        // `type: string` schema. A method per content type would ask the
        // caller to answer a question the document already answered; the
        // first declared type is what paogen sends.
        //
        // Twice, not once: the emitted client declares it and the emitted
        // interface mirrors it. A method per content type would read four.
        self::assertSame(2, substr_count($sources, 'function renderRaw('));
        self::assertStringContainsString('function renderRaw(string $body): string', $sources);
        self::assertStringContainsString("->text(\$body, 'text/plain')", $sources);
        self::assertStringNotContainsString('text/x-markdown', $sources);
    }

    public function testATextResponseIsReturnedAsAStringWithoutDecoding(): void
    {
        $sources = $this->sources();

        // `ResponseType::string()` reads the body straight off the response;
        // no branch of the decoder runs `json_decode` on it.
        self::assertStringContainsString('ResponseType::string()', $sources);
    }

    public function testAVendorStreamSubtypeOverAStringSchemaIsAString(): void
    {
        // GitHub's `application/octocat-stream` names a stream and declares
        // `type: string`. The schema is the evidence, not the subtype.
        self::assertStringContainsString('function getOctocat(): string', $this->sources());
    }

    public function testAnOctetStreamBodyTakesAPsr7Stream(): void
    {
        $sources = $this->sources();

        self::assertStringContainsString('use Psr\Http\Message\StreamInterface;', $sources);
        self::assertStringContainsString('function uploadAsset(StreamInterface $body): void', $sources);
        self::assertStringContainsString("->binary(\$body, 'application/octet-stream')", $sources);
    }

    public function testBinaryIsReadOffTheSchemaSoAnyContentTypeCanCarryIt(): void
    {
        $sources = $this->sources();

        // DigitalOcean declares `format: binary` under application/pdf. The
        // content type travels with the body rather than being implied by
        // the kind, so the vendor's own type reaches the wire.
        self::assertStringContainsString('function renderPdf(StreamInterface $body): void', $sources);
        self::assertStringContainsString("->binary(\$body, 'application/pdf')", $sources);
    }

    public function testMultipartStaysRefusedByName(): void
    {
        try {
            self::generator()->plan(new Profile(
                schema: self::SCHEMA,
                output: self::makeSandboxDir('paogen-non-json-'),
                namespace: self::NAMESPACE,
            ));
            self::fail('expected UnrepresentableConstructsException');
        } catch (UnrepresentableConstructsException $e) {
            $message = $e->getMessage();

            self::assertStringContainsString('uploadForm', $message);
            self::assertStringContainsString('multipart/form-data', $message);
            // Refusing is only honest while it says why, and the reason is
            // the shape of multipart rather than a gap in the content-type
            // list it sits next to.
            self::assertStringContainsString('own content type and encoding', $message);
        }
    }

    public function testOnlyMultipartIsRefused(): void
    {
        self::assertCount(1, $this->plan()->skippedOperations);
    }

    private function sources(): string
    {
        return implode("\n", array_values($this->plan()->writes));
    }

    private function plan(): GenerationPlan
    {
        return self::generator()->plan(new Profile(
            schema: self::SCHEMA,
            output: self::makeSandboxDir('paogen-non-json-'),
            namespace: self::NAMESPACE,
            skip: ['uploadForm' => 'multipart/form-data is out of scope'],
        ));
    }
}
