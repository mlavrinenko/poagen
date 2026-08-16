<?php

declare(strict_types=1);

namespace Poagen\Generator\Tests\Integration;

use PHPUnit\Framework\TestCase;
use Poagen\Generator\Generator\GenerationPlan;
use Poagen\Generator\Generator\Profile;
use Poagen\Generator\Tests\Support\GeneratedTreeSandbox;

use function array_filter;
use function array_values;
use function str_contains;

/**
 * `report-a-datetime-the-document-left-offset-free`: a `date-time` shown
 * without an offset is off-spec by RFC 3339, and poagen resolves it against
 * the process timezone. The type is right and the value is hours wrong, which
 * is the sort of defect found by comparing two screens rather than by reading
 * a client — so the run says it.
 *
 * Advisory, not a failure: nothing is omitted from the emitted tree, which is
 * the line `silence-means-success` draws.
 */
final class OffsetFreeDateTimeReportTest extends TestCase
{
    use GeneratedTreeSandbox;

    private const string OFFSET_FREE = __DIR__ . '/../fixtures/schemas/offset-free-datetime-3.0.yaml';
    private const string OFFSET_BEARING = __DIR__ . '/../fixtures/schemas/offset-bearing-datetime-3.0.yaml';
    private const string NO_DATETIME = __DIR__ . '/../fixtures/schemas/single-server-3.0.yaml';

    public static function tearDownAfterClass(): void
    {
        self::removeSandboxDirs();
    }

    public function testADocumentShowingAnOffsetFreeDateTimeIsReportedOnceWithACountAndALocation(): void
    {
        $notices = $this->offsetNotices(self::OFFSET_FREE, 'OffsetFree');

        self::assertCount(1, $notices);
        // Both properties count — one by `example`, one by `default` — and the
        // plain string beside them does not.
        self::assertStringContainsString('2 example(s)', $notices[0]);
        self::assertStringContainsString('first at ', $notices[0]);
    }

    public function testTheReportNamesBothWaysToAnswerIt(): void
    {
        $notice = $this->offsetNotices(self::OFFSET_FREE, 'OffsetFreeAdvice')[0];

        self::assertStringContainsString('Profile::$dateTimeZone', $notice);
        self::assertStringContainsString('Runtime\\BindingContext', $notice);
    }

    public function testADocumentThatCarriesItsOffsetsSaysNothing(): void
    {
        self::assertSame([], $this->offsetNotices(self::OFFSET_BEARING, 'OffsetBearing'));
    }

    public function testADocumentWithNoDateTimeAtAllSaysNothing(): void
    {
        self::assertSame([], $this->offsetNotices(self::NO_DATETIME, 'NoDateTime'));
    }

    public function testTheRunStillSucceedsAndEmitsEverything(): void
    {
        // Nothing was omitted, so this is a run that could be more correct,
        // not one that shrank the client.
        self::assertNotSame([], $this->plan(self::OFFSET_FREE, 'OffsetFreeStillEmits')->writes);
    }

    /**
     * @return list<string>
     */
    private function offsetNotices(string $schema, string $suffix): array
    {
        return array_values(array_filter(
            $this->plan($schema, $suffix)->notices,
            static fn(string $notice): bool => str_contains($notice, 'without a UTC offset'),
        ));
    }

    private function plan(string $schema, string $suffix): GenerationPlan
    {
        return self::generator()->plan(new Profile(
            schema: $schema,
            output: self::makeSandboxDir('poagen-offset-' . $suffix . '-'),
            namespace: 'Poagen\\Generator\\Tests\\Tmp\\' . $suffix,
        ));
    }
}
