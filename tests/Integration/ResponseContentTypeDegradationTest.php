<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Integration;

use Mlavrinenko\Paogen\Exception\UnrepresentableConstructsException;
use Mlavrinenko\Paogen\Generator\AttributeScanner;
use Mlavrinenko\Paogen\Generator\GenerationPlan;
use Mlavrinenko\Paogen\Generator\Generator;
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
 * independently unrepresentable responses (two non-JSON content types —
 * text/plain and application/xml, see xml-responses-refused-at-generation-time
 * — a broken `$ref`, and an array of non-`$ref` items) plus one fully
 * representable operation (`okOperation`), so a single run proves the
 * generator collects every one of them and that `Profile::$skip` only
 * affects what it names.
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

    public function testAResponseWithNoApplicationJsonAbortsTheRun(): void
    {
        try {
            $this->plan($this->acceptAllExcept('getPlainText'));
            self::fail('expected UnrepresentableConstructsException');
        } catch (UnrepresentableConstructsException $e) {
            $message = $e->getMessage();

            self::assertStringContainsString('getPlainText', $message);
            self::assertStringContainsString('text/plain', $message);
            self::assertStringContainsString('application/json', $message);
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
                'getPlainText' => 'text/plain not decoded',
                'getXmlLabel' => 'application/xml not decoded',
                'getBrokenRef' => 'broken $ref, fix the schema',
                'listInlineItems' => 'inline array items unsupported',
                // okOperation was never unrepresentable — this entry has
                // outlived whatever it was meant to guard against.
                'okOperation' => 'no longer needed',
            ]);
            self::fail('expected UnrepresentableConstructsException');
        } catch (UnrepresentableConstructsException $e) {
            self::assertStringContainsString("Profile::\$skip['okOperation']", $e->getMessage());
            self::assertStringContainsString('stale', $e->getMessage());
        }
    }

    public function testSkipHonouredOmitsFromOutputAndRunSucceedsWithoutAnnouncingSuccess(): void
    {
        $plan = $this->plan([
            'getPlainText' => 'text/plain not decoded',
            'getXmlLabel' => 'application/xml not decoded',
            'getBrokenRef' => 'broken $ref, fix the schema',
            'listInlineItems' => 'inline array items unsupported',
        ]);

        self::assertCount(4, $plan->skippedOperations);

        $sources = implode("\n", array_values($plan->writes));
        self::assertStringContainsString('function okOperation(', $sources);
        self::assertStringNotContainsString('function getPlainText(', $sources);
        self::assertStringNotContainsString('function getXmlLabel(', $sources);
        self::assertStringNotContainsString('function getBrokenRef(', $sources);
        self::assertStringNotContainsString('function listInlineItems(', $sources);
    }

    public function testNothingIsWrittenToTheOutputDirectoryOnAbort(): void
    {
        $outputDir = self::makeSandboxDir('paogen-response-degradation-');

        try {
            new Generator(new AttributeScanner(self::composerLoader()))->generate(new Profile(
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
            'getPlainText' => 'text/plain not decoded',
            'getXmlLabel' => 'application/xml not decoded',
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
        $generator = new Generator(new AttributeScanner(self::composerLoader()));

        return $generator->plan(new Profile(
            schema: self::SCHEMA,
            output: self::makeSandboxDir('paogen-response-degradation-'),
            namespace: self::NAMESPACE,
            skip: $skip,
        ));
    }
}
