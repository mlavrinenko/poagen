<?php

declare(strict_types=1);

namespace Poagen\Generator\Tests\Integration;

use PHPUnit\Framework\TestCase;
use Poagen\Generator\Exception\UnrepresentableConstructsException;
use Poagen\Generator\Generator\Profile;
use Poagen\Generator\Tests\Support\GeneratedTreeSandbox;

use function basename;
use function strpos;
use function substr;

/**
 * `a-profile-states-the-documents-timezone`: a vendor that fixed one zone for
 * every installation has stated a fact about the DOCUMENT, and restating it
 * at each construction site is restatement. The profile says it once and the
 * emitted client carries it.
 *
 * It stays a value the consumer reads, never wiring the client applies to
 * itself — `operations-delegate-to-an-injected-transport` puts the transport
 * in the consumer's hands before a generated client exists, so there is no
 * seam by which emitted code could apply it. Same reading as
 * {@see DeclaredServerConstantsTest}, which pins the identical property for
 * the server constants.
 */
final class ProfileTimezoneConstantTest extends TestCase
{
    use GeneratedTreeSandbox;

    private const string SCHEMA = __DIR__ . '/../fixtures/schemas/single-server-3.0.yaml';

    public static function tearDownAfterClass(): void
    {
        self::removeSandboxDirs();
    }

    public function testAStatedZoneReachesTheClientAsOneConstant(): void
    {
        $source = $this->generate('Europe/Moscow', 'StatedZone');

        self::assertStringContainsString("public const string NAIVE_TIMEZONE = 'Europe/Moscow';", $source);
    }

    /**
     * The property that makes this free for everyone else: a profile that
     * says nothing emits nothing, so no existing golden tree moves.
     */
    public function testStatingNothingEmitsNothing(): void
    {
        $source = $this->generate(null, 'NoZone');

        self::assertStringNotContainsString('NAIVE_TIMEZONE', $source);
    }

    public function testTheConstantIsAValueTheConsumerReadsNotWiring(): void
    {
        $source = $this->generate('Europe/Moscow', 'ZoneIsNotWiring');

        $ctorStart = strpos($source, 'public function __construct(');
        self::assertNotFalse($ctorStart);
        $ctorEnd = strpos($source, "\n    }", $ctorStart);
        self::assertNotFalse($ctorEnd);

        self::assertStringNotContainsString(
            'NAIVE_TIMEZONE',
            substr($source, $ctorStart, $ctorEnd - $ctorStart),
        );
    }

    public function testAZonePhpDoesNotKnowFailsTheRun(): void
    {
        $this->expectException(UnrepresentableConstructsException::class);
        $this->expectExceptionMessageMatches('/Europe\\/Moskow/');

        $this->generate('Europe/Moskow', 'UnknownZone');
    }

    private function generate(?string $zone, string $suffix): string
    {
        $namespace = 'Poagen\\Generator\\Tests\\Tmp\\' . $suffix;

        $plan = self::generator()->generate(new Profile(
            schema: self::SCHEMA,
            output: self::makeSandboxDir('poagen-timezone-' . $suffix . '-'),
            namespace: $namespace,
            dateTimeZone: $zone,
        ));

        foreach ($plan->writes as $path => $written) {
            if (basename($path) === 'ApiClient.php') {
                return $written;
            }
        }

        self::fail('the plan wrote no ApiClient.php');
    }
}
