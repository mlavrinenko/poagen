<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Integration;

use Mlavrinenko\Paogen\Generator\GenerationPlan;
use Mlavrinenko\Paogen\Generator\Profile;
use Mlavrinenko\Paogen\Tests\Support\GeneratedTreeSandbox;
use PHPUnit\Framework\TestCase;

use function array_filter;
use function array_values;
use function str_contains;

/**
 * name-inline-schemas-by-operation-and-status: the run reports each group of
 * structurally identical inline schemas on the notice channel
 * `report-unrecognised-formats` established — stderr, never moving the exit
 * status — with the exact `Profile::$inlineModels` block that would merge
 * them, one line per group.
 *
 * Reuses {@see InlineModelMergeTest}'s fixture: getA, getB and getC share a
 * `200` shape; postE and postF share a request shape; getD's `200` looks
 * similar but does not match, so it stays out of every group.
 */
final class InlineModelMergeReportTest extends TestCase
{
    use GeneratedTreeSandbox;

    private const string SCHEMA = __DIR__ . '/../fixtures/schemas/inline-model-merge-3.0.yaml';
    private const string NAMESPACE = 'Mlavrinenko\\Paogen\\Tests\\Tmp\\InlineModelMergeReport';

    public static function tearDownAfterClass(): void
    {
        self::removeSandboxDirs();
    }

    public function testAGroupOfThreeIdenticalResponsesIsReportedAsOneLineNamingAllThreeSites(): void
    {
        $notice = $this->requireNoticeMentioning('getA.200');

        self::assertStringContainsString('3 structurally identical inline schemas', $notice);
        self::assertStringContainsString('getA.200', $notice);
        self::assertStringContainsString('getB.200', $notice);
        self::assertStringContainsString('getC.200', $notice);
    }

    public function testTheNoticePrintsAReadyToPasteInlineModelsBlock(): void
    {
        $notice = $this->requireNoticeMentioning('getA.200');

        self::assertStringContainsString('Profile::$inlineModels', $notice);
        self::assertMatchesRegularExpression("/'\\w+' => \\[/", $notice);
    }

    public function testARequestSiteGroupIsReportedTooNotOnlyResponses(): void
    {
        $notice = $this->requireNoticeMentioning('postE.request');

        self::assertStringContainsString('postF.request', $notice);
        self::assertStringContainsString('2 structurally identical inline schemas', $notice);
    }

    public function testASiteWithNoStructuralTwinIsNotReported(): void
    {
        foreach ($this->mergeNotices() as $notice) {
            self::assertStringNotContainsString('getD.200', $notice);
        }
    }

    public function testTheReportNeverMovesTheExitStatus(): void
    {
        self::assertNotSame([], $this->plan()->writes);
    }

    public function testLargerGroupsAreReportedBeforeSmallerOnes(): void
    {
        $notices = $this->mergeNotices();

        self::assertCount(2, $notices);
        self::assertStringContainsString('3 structurally identical', $notices[0]);
        self::assertStringContainsString('2 structurally identical', $notices[1]);
    }

    private function requireNoticeMentioning(string $needle): string
    {
        foreach ($this->mergeNotices() as $notice) {
            if (str_contains($notice, $needle)) {
                return $notice;
            }
        }

        self::fail("no merge notice mentions '{$needle}'");
    }

    /**
     * @return list<string>
     */
    private function mergeNotices(): array
    {
        return array_values(array_filter(
            $this->plan()->notices,
            static fn(string $n): bool => str_contains($n, 'structurally identical inline schemas'),
        ));
    }

    private function plan(): GenerationPlan
    {
        return self::generator()->plan(new Profile(
            schema: self::SCHEMA,
            output: self::makeSandboxDir('paogen-inline-merge-report-'),
            namespace: self::NAMESPACE,
        ));
    }
}
