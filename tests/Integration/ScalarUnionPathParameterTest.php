<?php

declare(strict_types=1);

namespace Poagen\Generator\Tests\Integration;

use PHPUnit\Framework\TestCase;
use Poagen\Generator\Generator\Profile;
use Poagen\Generator\Tests\Support\GeneratedTreeSandbox;

/**
 * scalar-union-path-parameter-degrades-to-mixed: a path parameter typed
 * `anyOf`/`oneOf` over scalars — DigitalOcean's `images_get` `image_id`, an
 * id-or-slug, and GitHub's equivalent — must resolve to a real PHP union
 * (`int|string`) instead of degrading to `mixed`. `mixed` there violated
 * two standards at once: fail-loud-never-silent (a construct the generator
 * cannot represent should stop the run, not widen silently) and
 * generated-types-are-total (the emitted surface carries no `mixed`, and
 * this was on a path parameter, the most caller-facing position there is).
 * Since `int|string` is expressible in PHP and Endpoint::path() accepts
 * `string|int|float|bool|BackedEnum|Stringable` — a supertype of
 * `int|string` — resolving is the stronger answer; refusing would leave a
 * representable construct unrepresented.
 *
 * Fixture: tests/fixtures/schemas/scalar-union-path-parameter-3.0.yaml,
 * kept independent of the two vendor documents that surfaced the bug so
 * the regression guarantee survives either one leaving the repository.
 */
final class ScalarUnionPathParameterTest extends TestCase
{
    use GeneratedTreeSandbox;

    private const string SCHEMA = __DIR__ . '/../fixtures/schemas/scalar-union-path-parameter-3.0.yaml';
    private const string NAMESPACE = 'Poagen\\Generator\\Tests\\Tmp\\ScalarUnionPathParameter';

    public static function tearDownAfterClass(): void
    {
        self::removeSandboxDirs();
    }

    public function testAnyOfScalarPathParameterResolvesToARealUnionTypeNotMixed(): void
    {
        $plan = self::generator()->plan(new Profile(
            schema: self::SCHEMA,
            output: self::makeSandboxDir('poagen-scalar-union-path-'),
            namespace: self::NAMESPACE,
        ));

        self::assertSame([], $plan->skippedOperations, 'a scalar union path parameter is representable — it must not be skipped');

        $sources = implode("\n", array_values($plan->writes));

        self::assertStringContainsString('int|string $imageId', $sources);
        self::assertStringNotContainsString('mixed $imageId', $sources);
    }
}
