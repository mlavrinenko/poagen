<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Integration;

use Mlavrinenko\Paogen\Exception\UnrepresentableConstructsException;
use Mlavrinenko\Paogen\Generator\GenerationPlan;
use Mlavrinenko\Paogen\Generator\Profile;
use Mlavrinenko\Paogen\Tests\Support\GeneratedTreeSandbox;
use PHPUnit\Framework\TestCase;

use const DIRECTORY_SEPARATOR;

/**
 * default-deny-on-degradation: a 2xx response the generator cannot represent
 * as a typed return must refuse the run, the same way an unsupported request
 * body already does — not collapse to `ReturnSpec::void()` and silently throw
 * the vendor's body away.
 *
 * Fixture: tests/fixtures/schemas/response-degradation-3.0.yaml carries four
 * independently unrepresentable responses (application/xml, see
 * xml-responses-refused-at-generation-time; a `format: binary` body; a broken
 * `$ref`; and an array of non-`$ref` items) plus two fully representable
 * operations (`okOperation`, and the `text/plain` `getPlainText`), so a
 * single run proves the generator collects every one of them and that
 * `Profile::$skip` only affects what it names.
 *
 * `getPlainText` moved from the first group to the second in
 * represent-non-json-request-and-response-bodies. The refusal it used to
 * prove was never about decoding — a `text/*` response over a `type: string`
 * schema needs no decoding at all — so the test that asserted it is now the
 * test that it returns a string.
 */
final class ResponseContentTypeDegradationTest extends TestCase
{
    use GeneratedTreeSandbox;

    private const string SCHEMA = __DIR__ . '/../fixtures/schemas/response-degradation-3.0.yaml';
    private const string NAMESPACE = 'Mlavrinenko\\Paogen\\Tests\\Tmp\\ResponseDegradation';

    public static function tearDownAfterClass(): void
    {
        self::removeSandboxDirs();
    }

    public function testAPlainTextResponseIsReturnedAsAStringRatherThanRefused(): void
    {
        $sources = implode("\n", array_values($this->plan($this->acceptAllExcept(''))->writes));

        // `string`, not a Model and not a decoded array: the schema said
        // `type: string` and nothing about the response needs a JSON decode.
        self::assertStringContainsString('function getPlainText(): string', $sources);
        self::assertStringContainsString('ResponseType::string()', $sources);
    }

    public function testABinaryResponseStillAbortsBecauseTheReturnContractCannotNameAStream(): void
    {
        try {
            $this->plan($this->acceptAllExcept('getBinaryBlob'));
            self::fail('expected UnrepresentableConstructsException');
        } catch (UnrepresentableConstructsException $e) {
            $message = $e->getMessage();

            self::assertStringContainsString('getBinaryBlob', $message);
            self::assertStringContainsString('binary', $message);
            // The remedy is real and named, which is what separates a
            // refusal from a dead end (abort-on-unrepresentable-constructs).
            self::assertStringContainsString('Profile::$skip', $message);
        }
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

    public function testAResponseWithAnInlineNonRefArrayItemAbortsTheRun(): void
    {
        try {
            $this->plan($this->acceptAllExcept('listInlineItems'));
            self::fail('expected UnrepresentableConstructsException');
        } catch (UnrepresentableConstructsException $e) {
            $message = $e->getMessage();

            self::assertStringContainsString('listInlineItems', $message);
            self::assertStringContainsString('array', $message);
        }
    }

    public function testAllFourProblemsAreCollectedInOnePass(): void
    {
        try {
            $this->plan([]);
            self::fail('expected UnrepresentableConstructsException');
        } catch (UnrepresentableConstructsException $e) {
            self::assertStringContainsString('4 problems found', $e->getMessage());
        }
    }

    public function testAStaleSkipOnAResponseOperationThatNowGeneratesCleanlyIsRefused(): void
    {
        try {
            $this->plan([
                'getXmlLabel' => 'application/xml not decoded',
                'getBinaryBlob' => 'binary body, no stream return yet',
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

        self::assertCount(4, $plan->skippedOperations);

        $sources = implode("\n", array_values($plan->writes));
        self::assertStringContainsString('function okOperation(', $sources);
        self::assertStringContainsString('function getPlainText(', $sources);
        self::assertStringNotContainsString('function getXmlLabel(', $sources);
        self::assertStringNotContainsString('function getBinaryBlob(', $sources);
        self::assertStringNotContainsString('function getBrokenRef(', $sources);
        self::assertStringNotContainsString('function listInlineItems(', $sources);
    }

    public function testNothingIsWrittenToTheOutputDirectoryOnAbort(): void
    {
        $outputDir = self::makeSandboxDir('paogen-response-degradation-');

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
            'getBinaryBlob' => 'binary body, no stream return yet',
            'getBrokenRef' => 'broken $ref, fix the schema',
            'listInlineItems' => 'inline array items unsupported',
        ];

        unset($all[$exclude]);

        return $all;
    }

    /**
     * @param array<string,string> $skip
     */
    private function plan(array $skip): GenerationPlan
    {
        return self::generator()->plan(new Profile(
            schema: self::SCHEMA,
            output: self::makeSandboxDir('paogen-response-degradation-'),
            namespace: self::NAMESPACE,
            skip: $skip,
        ));
    }
}
