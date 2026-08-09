<?php

declare(strict_types=1);

namespace Poagen\Generator\Tests\Integration;

use PHPUnit\Framework\TestCase;
use Poagen\Generator\Generator\GenerationPlan;
use Poagen\Generator\Tests\Fixtures\ValueObject\Slug;
use Poagen\Generator\Tests\Support\FormatBindingFixture;
use Poagen\Runtime\Marshal\Hydrator;
use Poagen\Runtime\Marshal\Marshaller;

use function base64_decode;
use function base64_encode;

/**
 * `base64-binding-for-format-byte`, split off {@see FormatBindingTest} to
 * keep that file under linecop (`quality-gates-at-maximum-strictness`).
 *
 * `byte` is the dependency-free case `uuid` could never be: both directions
 * are PHP core, so poagen binds it by default rather than waiting for a
 * `Profile::$formats` entry — the same reason `date-time` needs none.
 * `format-binding-3.0.yaml`'s `Account.avatarBytes` carries it.
 */
final class FormatBindingByteTest extends TestCase
{
    use FormatBindingFixture;

    private const string NAMESPACE = 'Poagen\\Generator\\Tests\\Tmp\\FormatBindingByte';

    public static function tearDownAfterClass(): void
    {
        self::removeSandboxDirs();
    }

    public function testByteBindsToTheBase64CodecWithNoProfileEntry(): void
    {
        $account = $this->formatBindingModelSource($this->plan([]), 'Account');

        self::assertStringContainsString("#[Format(format: 'byte', codec: Base64Codec::class)]", $account);
        self::assertStringContainsString('public ?string $avatarBytes = null,', $account);
    }

    public function testByteStopsBeingReportedAsUnrecognised(): void
    {
        self::assertNull($this->formatBindingNoticeFor($this->plan([]), 'byte'));
    }

    /**
     * The built-in loses to explicit guidance exactly as `date-time` already
     * does — a `$propertyFormats` entry for `byte` beats the codec poagen
     * would otherwise pick.
     */
    public function testAPerPropertyEntryBeatsTheByteBuiltIn(): void
    {
        $plan = $this->plan([], propertyFormats: ['Account.avatarBytes' => Slug::class]);

        self::assertStringContainsString('public ?Slug $avatarBytes = null,', $this->formatBindingModelSource($plan, 'Account'));
    }

    /**
     * A `Profile::$formats['byte']` entry beats the built-in the same way
     * one for `uuid` beats going unbound — the built-in is a fallback, not a
     * floor nothing can override.
     */
    public function testAProfileEntryBeatsTheByteBuiltIn(): void
    {
        $plan = $this->plan(['byte' => Slug::class]);

        self::assertStringContainsString('public ?Slug $avatarBytes = null,', $this->formatBindingModelSource($plan, 'Account'));
    }

    /**
     * The wire boundary, end to end: the payload carries base64 text, the
     * model carries the *decoded* bytes as a plain `string`, and marshalling
     * puts the base64 back — `Base64Codec::decode()` / `encode()`, not a
     * passthrough of whatever the payload happened to spell.
     */
    public function testAByteRoundTripsHydrationAndMarshalling(): void
    {
        $reflection = $this->formatBindingRequireAccount(self::NAMESPACE);
        $encoded = base64_encode('hydraulic press');

        $hydrated = new Hydrator()->hydrate(
            $reflection->getName(),
            ['id' => '2b1a7f60-4c2c-4a5b-9c6e-6a2f0d1e3b44', 'avatarBytes' => $encoded],
        );
        $bytes = $reflection->getProperty('avatarBytes')->getValue($hydrated);

        self::assertSame('hydraulic press', $bytes);
        self::assertSame(base64_decode($encoded, true), $bytes);
        self::assertSame($encoded, new Marshaller()->marshal($hydrated)['avatarBytes']);
    }

    /**
     * @param array<string,string> $formats
     * @param array<string,string> $propertyFormats
     */
    private function plan(array $formats, array $propertyFormats = []): GenerationPlan
    {
        return $this->formatBindingPlan(self::NAMESPACE, $formats, propertyFormats: $propertyFormats);
    }
}
