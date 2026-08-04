<?php

declare(strict_types=1);

namespace Poagen\Generator\Tests\Integration;

use PHPUnit\Framework\TestCase;
use Poagen\Generator\Exception\UnrepresentableConstructsException;
use Poagen\Generator\Generator\GenerationPlan;
use Poagen\Generator\Generator\Profile;
use Poagen\Generator\Tests\Support\GeneratedTreeSandbox;

use function array_values;
use function implode;

/**
 * a-response-of-scalars-has-no-return-shape: `ReturnSpec::KIND_LIST`,
 * `ResponseType::listOf()` and `ResponseDecoder::listOf()` all resolved a
 * class name and hydrated it, so there was no way to say "list of string" —
 * and three GitHub operations that say exactly that were refused for it.
 *
 * Fixture: tests/fixtures/schemas/scalar-list-response-3.0.yaml, whose
 * header records which vendored operation each path was read from.
 */
final class ScalarListResponseTest extends TestCase
{
    use GeneratedTreeSandbox;

    private const string SCHEMA = __DIR__ . '/../fixtures/schemas/scalar-list-response-3.0.yaml';
    private const string NAMESPACE = 'Poagen\\Generator\\Tests\\Tmp\\ScalarList';

    public static function tearDownAfterClass(): void
    {
        self::removeSandboxDirs();
    }

    public function testAnArrayOfStringsIsATypedListHydratedWithoutAModelClass(): void
    {
        $sources = $this->sources();

        self::assertStringContainsString('@return Envelope<list<string>>', $sources);
        self::assertStringContainsString('ResponseType::scalarListOf(ResponseType::string())', $sources);
    }

    public function testAnArrayOfIntegersKeepsItsOwnScalarType(): void
    {
        self::assertStringContainsString(
            'ResponseType::scalarListOf(ResponseType::int())',
            $this->sources(),
        );
    }

    public function testADateFormattedItemBindsTheSameWayItDoesOnAProperty(): void
    {
        $sources = $this->sources();

        // `format: date` is `\DateTimeImmutable` on a model property, so it is
        // `\DateTimeImmutable` here. Arriving as a raw string would make the
        // same annotation mean two different things in one document.
        self::assertStringContainsString('@return Envelope<list<DateTimeImmutable>>', $sources);
        self::assertStringContainsString('ResponseType::scalarListOf(ResponseType::dateTime())', $sources);
    }

    public function testAConsumersOwnFormatBindingWinsOnAListItemToo(): void
    {
        $sources = $this->sources();

        // Email is a `#[BindsFormat('email')]` value object implementing
        // ScalarBinding. A built-in would have left this a plain string.
        self::assertStringContainsString('@return Envelope<list<Email>>', $sources);
        self::assertStringContainsString('ResponseType::scalarListOf(ResponseType::binding(Email::class))', $sources);
    }

    public function testAnArrayOfRefdModelsStillHydratesExactlyAsBefore(): void
    {
        $sources = $this->sources();

        self::assertStringContainsString('ResponseType::listOf(Pet::class)', $sources);
        self::assertStringContainsString('@return Envelope<list<Pet>>', $sources);
    }

    public function testItemsThatDeclareNothingAreRefusedRatherThanWidenedToMixed(): void
    {
        try {
            self::generator()->plan($this->profile([]));
            self::fail('expected UnrepresentableConstructsException');
        } catch (UnrepresentableConstructsException $e) {
            $message = $e->getMessage();

            self::assertStringContainsString('listAnything', $message);
            // A list of mixed hands back the parsing job the consumer came
            // here to be rid of, so the document's silence is refused rather
            // than widened (declared-shapes-become-types).
            self::assertStringContainsString('items declare neither a $ref nor a scalar `type`', $message);
            self::assertStringNotContainsString('list<mixed>', $message);
        }
    }

    public function testTheUnconstrainedItemsAreAlsoReportedByTheExistingAdvisor(): void
    {
        $notices = implode("\n", $this->plan()->notices);

        // The refusal says the operation cannot be emitted; the advisor says
        // where the document went silent. Both, because they answer different
        // questions.
        self::assertStringContainsString('/paths/~1anything/get', $notices);
    }

    private function sources(): string
    {
        return implode("\n", array_values($this->plan()->writes));
    }

    private function plan(): GenerationPlan
    {
        return self::generator()->plan($this->profile([
            'listAnything' => 'items declare nothing at all',
        ]));
    }

    /**
     * @param array<string,string> $skip
     */
    private function profile(array $skip): Profile
    {
        return new Profile(
            schema: self::SCHEMA,
            output: self::makeSandboxDir('poagen-scalar-list-'),
            namespace: self::NAMESPACE,
            discoverIn: ['Poagen\\Generator\\Tests\\Fixtures\\ValueObject'],
            skip: $skip,
        );
    }
}
