<?php

declare(strict_types=1);

namespace Poagen\Generator\Tests\Integration;

use PHPUnit\Framework\TestCase;
use Poagen\Generator\Generator\GenerationPlan;
use Poagen\Generator\Generator\Profile;
use Poagen\Generator\Tests\Support\GeneratedTreeSandbox;

/**
 * report-unrecognised-formats: an unknown `format` falls back to the base type
 * and says so.
 *
 * Exercised against the kilbil loyalty document, where the problem is real: nine
 * distinct format values across 292 uses, of which poagen knows one. `date time`
 * is `date-time` misspelled with a space and `data`/`data time` are further typos
 * of it, so silence would cost 15 timestamps.
 *
 * The example's own profile answers four of the nine with value objects under
 * `examples/kilbil/src/ValueObject/`, which is what makes this testable both
 * ways: bound formats must drop out of the report *and* show up as types in the
 * emitted tree.
 */
final class UnrecognisedFormatReportTest extends TestCase
{
    use GeneratedTreeSandbox;

    private const string SCHEMA = __DIR__ . '/../../examples/kilbil/schemas/loyalty_v1.yaml';
    private const string NAMESPACE = 'Poagen\\Generator\\Tests\\Tmp\\KilbilFormats';
    private const string VALUE_OBJECTS = 'Acme\\Kilbil\\ValueObject';

    /** @var array<string,string> */
    private const array XML_SKIP = [
        'goodsxml' => 'application/xml request body — xml-content-type-policy',
        'goodslistxml' => 'application/xml request body — xml-content-type-policy',
    ];

    public static function tearDownAfterClass(): void
    {
        self::removeSandboxDirs();
    }

    public function testEveryUnrecognisedFormatIsReportedOnceWithACountAndALocation(): void
    {
        $report = $this->formatNotices($this->plan());

        // Once per distinct format, not once per use.
        self::assertCount(8, $report);

        $int = $this->requireNoticeFor($report, 'int');
        self::assertStringContainsString('172 use(s)', $int);
        self::assertStringContainsString('first at /paths/', $int);
    }

    public function testTheReportNamesTheMechanismThatBindsIt(): void
    {
        $notice = $this->requireNoticeFor($this->formatNotices($this->plan()), 'phone');

        self::assertStringContainsString("#[BindsFormat('phone')]", $notice);
        self::assertStringContainsString('discoverIn', $notice);
        self::assertStringContainsString('ScalarBinding', $notice);
    }

    public function testABuiltInFormatIsNotReported(): void
    {
        // `date` is poagen's own; only the vendor's `data` typo is an opportunity.
        self::assertNull($this->noticeFor($this->formatNotices($this->plan()), 'date'));
    }

    public function testABoundFormatDropsOutOfTheReportAndBecomesATypeInTheOutput(): void
    {
        $bound = $this->plan(discoverIn: [self::VALUE_OBJECTS]);
        $report = $this->formatNotices($bound);

        // Four of the nine are answered by the example's value objects.
        self::assertCount(4, $report);

        foreach (['date time', 'data time', 'data', 'phone'] as $answered) {
            self::assertNull($this->noticeFor($report, $answered), "'{$answered}' should be answered");
        }

        // And the answer reaches the emitted tree, which is the half that
        // matters: a report nobody can act on is not a diagnostic.
        $models = implode("\n", array_values($bound->writes));
        self::assertStringContainsString('public Timestamp $doc_open_dt,', $models);
        self::assertStringContainsString('public PhoneNumber $phone,', $models);
    }

    public function testAnUnrecognisedFormatDoesNotFailTheRun(): void
    {
        // Eight unanswered formats and the plan still completes. Nothing was
        // omitted, so nothing here is a failure.
        self::assertNotSame([], $this->plan()->writes);
    }

    /**
     * @param  list<string>  $discoverIn
     */
    private function plan(array $discoverIn = []): GenerationPlan
    {
        return self::generator()->plan(new Profile(
            schema: self::SCHEMA,
            output: self::makeSandboxDir('poagen-formats-'),
            namespace: self::NAMESPACE,
            discoverIn: $discoverIn,
            skip: self::XML_SKIP,
        ));
    }

    /**
     * The plan's notices carry the operation-id advisory too; this is the format
     * half of them.
     *
     * @return list<string>
     */
    private function formatNotices(GenerationPlan $plan): array
    {
        return array_values(array_filter(
            $plan->notices,
            static fn(string $n): bool => str_starts_with($n, 'format '),
        ));
    }

    /**
     * @param list<string> $notices
     */
    private function requireNoticeFor(array $notices, string $format): string
    {
        return $this->noticeFor($notices, $format) ?? self::fail("no notice reported for format '{$format}'");
    }

    /**
     * @param list<string> $notices
     */
    private function noticeFor(array $notices, string $format): ?string
    {
        foreach ($notices as $notice) {
            if (str_starts_with($notice, "format '{$format}' ")) {
                return $notice;
            }
        }

        return null;
    }
}
