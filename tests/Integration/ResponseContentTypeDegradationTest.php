<?php

declare(strict_types=1);

namespace Poagen\Generator\Tests\Integration;

use PHPUnit\Framework\TestCase;
use Poagen\Generator\Exception\UnrepresentableConstructsException;
use Poagen\Generator\Generator\Profile;
use Poagen\Generator\Tests\Support\GeneratedTreeSandbox;
use Poagen\Generator\Tests\Support\SkipPlanFixture;

use const DIRECTORY_SEPARATOR;

/**
 * default-deny-on-degradation: a 2xx response the generator cannot represent
 * as a typed return must refuse the run, the same way an unsupported request
 * body already does — not collapse to `ReturnSpec::void()` and silently throw
 * the vendor's body away.
 *
 * Fixture: tests/fixtures/schemas/response-degradation-3.0.yaml carries three
 * independently unrepresentable responses (application/xml, see
 * xml-responses-refused-at-generation-time; a broken `$ref`; and an array of
 * non-`$ref` items) plus three fully representable operations (`okOperation`,
 * the `text/plain` `getPlainText`, and the `format: binary` `getBinaryBlob`),
 * so a single run proves the generator collects every remaining problem and
 * that `Profile::$skip` only affects what it names.
 *
 * `getPlainText` moved from the first group to the second in
 * represent-non-json-request-and-response-bodies. The refusal it used to
 * prove was never about decoding — a `text/*` response over a `type: string`
 * schema needs no decoding at all — so the test that asserted it is now the
 * test that it returns a string. `getBinaryBlob` made the identical move in
 * return-a-binary-2xx-as-the-stream-a-done-task-already-promised: a
 * `format: binary` body returns the PSR-7 stream now rather than refusing.
 */
final class ResponseContentTypeDegradationTest extends TestCase
{
    use GeneratedTreeSandbox;
    use SkipPlanFixture;

    private const string SCHEMA = __DIR__ . '/../fixtures/schemas/response-degradation-3.0.yaml';
    private const string NAMESPACE = 'Poagen\\Generator\\Tests\\Tmp\\ResponseDegradation';

    public static function tearDownAfterClass(): void
    {
        self::removeSandboxDirs();
    }

    public function testAPlainTextResponseIsReturnedAsAStringRatherThanRefused(): void
    {
        $sources = implode("\n", array_values($this->plan($this->acceptAllExcept(''))->writes));

        // `string`, not a Model and not a decoded array: the schema said
        // `type: string` and nothing about the response needs a JSON decode.
        self::assertStringContainsString('function getPlainText(): Envelope', $sources);
        self::assertStringContainsString('ResponseType::string()', $sources);
    }

    public function testABinaryResponseReturnsTheStreamRatherThanBeingRefused(): void
    {
        $sources = implode("\n", array_values($this->plan($this->acceptAllExcept(''))->writes));

        // A PSR-7 stream, not a decoded value and not a refusal: the schema
        // said `format: binary` and that is the whole shape, handed back
        // exactly as the transport produced it.
        self::assertStringContainsString('function getBinaryBlob(): Envelope', $sources);
        self::assertStringContainsString('ResponseType::stream()', $sources);
    }

    public function testAnXmlResponseAbortsTheRunRatherThanBeingDecodedOrPassedThroughRaw(): void
    {
        try {
            $this->plan($this->acceptAllExcept('getXmlLabel'));
            self::fail('expected UnrepresentableConstructsException');
        } catch (UnrepresentableConstructsException $e) {
            $message = $e->getMessage();

            self::assertStringContainsString('getXmlLabel', $message);
            self::assertStringContainsString('application/xml', $message);
            self::assertStringContainsString('application/json', $message);
        }
    }

    public function testAResponseWithABrokenRefAbortsTheRun(): void
    {
        try {
            $this->plan($this->acceptAllExcept('getBrokenRef'));
            self::fail('expected UnrepresentableConstructsException');
        } catch (UnrepresentableConstructsException $e) {
            $message = $e->getMessage();

            self::assertStringContainsString('getBrokenRef', $message);
            self::assertStringContainsString('$ref', $message);
        }
    }

    public function testAResponseWithAnArrayItemThatDeclaresNothingAbortsTheRun(): void
    {
        try {
            $this->plan($this->acceptAllExcept('listInlineItems'));
            self::fail('expected UnrepresentableConstructsException');
        } catch (UnrepresentableConstructsException $e) {
            $message = $e->getMessage();

            self::assertStringContainsString('listInlineItems', $message);
            self::assertStringContainsString('array', $message);
            // An inline item is fine now if it declares a scalar type; what
            // is left unrepresentable is an item that declares nothing.
            self::assertStringContainsString('scalar `type`', $message);
        }
    }

    public function testAllThreeProblemsAreCollectedInOnePass(): void
    {
        try {
            $this->plan([]);
            self::fail('expected UnrepresentableConstructsException');
        } catch (UnrepresentableConstructsException $e) {
            self::assertStringContainsString('3 problems found', $e->getMessage());
        }
    }

    public function testAStaleSkipOnAResponseOperationThatNowGeneratesCleanlyIsRefused(): void
    {
        try {
            $this->plan([
                'getXmlLabel' => 'application/xml not decoded',
                'getBrokenRef' => 'broken $ref, fix the schema',
                'listInlineItems' => 'inline array items unsupported',
                // `getPlainText` was genuinely unrepresentable when this
                // entry would have been written, and is not any more. That
                // is precisely the entry a consumer would carry forward
                // forever without the staleness check.
                'getPlainText' => 'text/plain not decoded',
            ]);
            self::fail('expected UnrepresentableConstructsException');
        } catch (UnrepresentableConstructsException $e) {
            self::assertStringContainsString("Profile::\$skip['getPlainText']", $e->getMessage());
            self::assertStringContainsString('stale', $e->getMessage());
        }
    }

    public function testSkipHonouredOmitsFromOutputAndRunSucceedsWithoutAnnouncingSuccess(): void
    {
        $plan = $this->plan($this->acceptAllExcept(''));

        self::assertCount(3, $plan->skippedOperations);

        $sources = implode("\n", array_values($plan->writes));
        self::assertStringContainsString('function okOperation(', $sources);
        self::assertStringContainsString('function getPlainText(', $sources);
        self::assertStringContainsString('function getBinaryBlob(', $sources);
        self::assertStringNotContainsString('function getXmlLabel(', $sources);
        self::assertStringNotContainsString('function getBrokenRef(', $sources);
        self::assertStringNotContainsString('function listInlineItems(', $sources);
    }

    public function testNothingIsWrittenToTheOutputDirectoryOnAbort(): void
    {
        $outputDir = self::makeSandboxDir('poagen-response-degradation-');

        try {
            self::generator()->generate(new Profile(
                schema: self::SCHEMA,
                output: $outputDir,
                namespace: self::NAMESPACE,
            ));
            self::fail('expected UnrepresentableConstructsException');
        } catch (UnrepresentableConstructsException) {
            self::assertDirectoryDoesNotExist($outputDir . DIRECTORY_SEPARATOR . 'Generated');
        }
    }

    /**
     * @return array<string,string>
     */
    private function acceptAllExcept(string $exclude): array
    {
        $all = [
            'getXmlLabel' => 'application/xml not decoded',
            'getBrokenRef' => 'broken $ref, fix the schema',
            'listInlineItems' => 'inline array items unsupported',
        ];

        unset($all[$exclude]);

        return $all;
    }
}
