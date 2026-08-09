<?php

declare(strict_types=1);

namespace Poagen\Generator\Tests\Support;

use PHPUnit\Framework\Assert;
use Poagen\Generator\Generator\GenerationPlan;
use Poagen\Generator\Generator\Profile;
use ReflectionClass;

use function str_contains;
use function str_ends_with;

/**
 * The `poagen generate` + plan-reading boilerplate `FormatBindingTest` and
 * `FormatBindingByteTest` both need against the same synthetic
 * `format-binding-3.0.yaml` schema — split off once `base64-binding-for-
 * format-byte` needed its own test class to keep `FormatBindingTest` under
 * linecop's 250-line cap (`quality-gates-at-maximum-strictness`), rather
 * than let the pair grow two copies of it.
 *
 * Composes {@see GeneratedTreeSandbox} rather than requiring the consuming
 * class to `use` both: every caller already needs `generator()` and
 * `makeSandboxDir()` from it, and there is no case here of wanting one
 * without the other.
 */
trait FormatBindingFixture
{
    use GeneratedTreeSandbox;

    private const string FORMAT_BINDING_SCHEMA = __DIR__ . '/../fixtures/schemas/format-binding-3.0.yaml';

    /**
     * @param array<string,string> $formats
     * @param list<string>         $discoverIn
     * @param array<string,string> $propertyFormats
     */
    private function formatBindingPlan(
        string $namespace,
        array $formats,
        array $discoverIn = [],
        array $propertyFormats = [],
    ): GenerationPlan {
        return self::generator()->plan(new Profile(
            schema: self::FORMAT_BINDING_SCHEMA,
            output: self::makeSandboxDir('poagen-format-binding-'),
            namespace: $namespace,
            discoverIn: $discoverIn,
            formats: $formats,
            propertyFormats: $propertyFormats,
        ));
    }

    private function formatBindingModelSource(GenerationPlan $plan, string $className): string
    {
        return $this->formatBindingWrite($plan, '/Model/' . $className . '.php');
    }

    private function formatBindingClientSource(GenerationPlan $plan): string
    {
        return $this->formatBindingWrite($plan, '/Generated/ApiClient.php');
    }

    private function formatBindingWrite(GenerationPlan $plan, string $suffix): string
    {
        foreach ($plan->writes as $path => $source) {
            if (str_ends_with($path, $suffix)) {
                return $source;
            }
        }

        Assert::fail("no write found ending in '{$suffix}'");
    }

    private function formatBindingNoticeFor(GenerationPlan $plan, string $format): ?string
    {
        foreach ($plan->notices as $notice) {
            if (str_contains($notice, "format '{$format}' is not one poagen recognises")) {
                return $notice;
            }
        }

        return null;
    }

    /**
     * Generates `Account` for real (not into `$plan->writes` alone) and
     * `require`s it, for a wire-boundary round trip through {@see Hydrator}/
     * {@see Marshaller} rather than a string match on emitted source — the
     * shape `testABoundUuidRoundTripsHydrationAndMarshalling` and
     * `testAByteRoundTripsHydrationAndMarshalling` both need.
     *
     * @param array<string,string> $formats
     *
     * @return ReflectionClass<object>
     */
    private function formatBindingRequireAccount(string $namespace, array $formats = []): ReflectionClass
    {
        $output = self::makeSandboxDir('poagen-format-binding-');
        self::generator()->generate(new Profile(
            schema: self::FORMAT_BINDING_SCHEMA,
            output: $output,
            namespace: $namespace,
            formats: $formats,
        ));

        $path = $output . '/Generated/Model/Account.php';
        Assert::assertFileExists($path);
        require $path;

        return new ReflectionClass(self::declaredClassEnding($namespace . '\\Generated\\Model\\Account'));
    }
}
