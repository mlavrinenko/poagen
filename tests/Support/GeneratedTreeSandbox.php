<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Support;

use Composer\Autoload\ClassLoader;
use Mlavrinenko\Paogen\GenerateCommand;
use Mlavrinenko\Paogen\Generator\AttributeScanner;
use Mlavrinenko\Paogen\Generator\Generator;
use Mlavrinenko\Paogen\Generator\Profile;
use PHPUnit\Framework\Assert;
use ReflectionClass;

use function assert;
use function basename;
use function get_declared_classes;
use function is_array;
use function str_ends_with;
use function strlen;
use function strpos;
use function substr;

/**
 * Scaffolding an integration test needs to generate a client into a scratch
 * directory, autoload it, and clean up afterwards.
 *
 * Every test under `tests/Integration/` grows its own copy of these four
 * helpers, which is a good share of the duplication `adopt-jscpd-duplication-gate`
 * measures in the suite. This is the shared one; `deduplicate-the-test-suite`
 * moves the remaining tests onto it.
 *
 * The scratch-directory half lives in {@see SandboxDirectories}, composed in
 * below so a test still writes one `use` and reaches everything. That is the
 * linecop 250-line cap on PHP, not a second concept.
 */
trait GeneratedTreeSandbox
{
    use SandboxDirectories;

    /** The emitted `ApiClient.php` source from {@see generateRootClientOnce}. */
    private static string $rootClientSource = '';

    /** @var ReflectionClass<object>|null the class {@see generateRootClientOnce} required */
    private static ?ReflectionClass $rootClientReflection = null;

    /**
     * A `Generator` wired to the live autoload chain — the one piece of
     * `new Generator(new AttributeScanner(...))` every integration test
     * needs and none of them vary. What the generator is asked to produce
     * (the schema, the profile, the namespace) stays at the call site.
     */
    private static function generator(): Generator
    {
        return new Generator(new AttributeScanner(self::composerLoader()));
    }

    /**
     * Runs `paogen generate` against a profile file already on disk and
     * captures its exit code, stdout and stderr in memory rather than the
     * process's real streams. The profile path and any CLI flags — the
     * part that varies between a `--dry-run`, a `--diff` and a plain run —
     * stay the caller's; this only owns capturing what the command printed.
     *
     * @param  list<string>              $argv the profile path, then any CLI flags
     * @return array{0:int,1:string,2:string}
     */
    private static function runGenerateCommand(array $argv): array
    {
        $stdout = fopen('php://memory', 'w+');
        $stderr = fopen('php://memory', 'w+');
        assert($stdout !== false && $stderr !== false);

        $exit = GenerateCommand::run($argv, self::composerLoader(), $stdout, $stderr);

        rewind($stdout);
        rewind($stderr);
        $out = (string) stream_get_contents($stdout);
        $err = (string) stream_get_contents($stderr);
        fclose($stdout);
        fclose($stderr);

        return [$exit, $out, $err];
    }

    /**
     * The live Composer loader, so a generated namespace can be mapped onto
     * the scratch directory it was just written to.
     */
    private static function composerLoader(): ClassLoader
    {
        foreach (spl_autoload_functions() as $fn) {
            if (is_array($fn) && $fn[0] instanceof ClassLoader) {
                return $fn[0];
            }
        }

        Assert::fail('Composer ClassLoader not found in autoload chain.');
    }

    /**
     * Requires the three files every emitted root client needs — the
     * exception, the interface, then the class — from a sandbox `$outputDir`
     * already populated by {@see Generator::generate}, and hands back a
     * reflection on the class actually declared.
     *
     * A class written into a throwaway namespace at test run time has no
     * compile-time literal FQCN PHPStan can check, so this scans
     * `get_declared_classes()` for one ending in `\Generated\ApiClient`
     * rather than referencing the namespaced name directly — the same trap
     * {@see self::declaredClassEnding} exists to route around generally.
     *
     * @return ReflectionClass<object>
     */
    private static function requireGeneratedClient(string $outputDir, string $namespace): ReflectionClass
    {
        $exceptionPath = $outputDir . '/Generated/ApiException.php';
        $interfacePath = $outputDir . '/Generated/ApiClientInterface.php';
        $clientPath = $outputDir . '/Generated/ApiClient.php';

        Assert::assertFileExists($exceptionPath);
        // The client implements an emitted interface, so load the contract first.
        Assert::assertFileExists($interfacePath);
        Assert::assertFileExists($clientPath);

        require $exceptionPath;
        require $interfacePath;
        require $clientPath;

        return new ReflectionClass(self::declaredClassEnding($namespace . '\\Generated\\ApiClient'));
    }

    /**
     * The full round trip a root-client integration test's `setUpBeforeClass`
     * needs: generate `$schema` into a fresh sandbox under `$namespace`, pull
     * the emitted `ApiClient.php` source out of the plan, and require +
     * reflect the class the same run wrote to disk. Both the in-memory
     * source (for asserting on emitted text) and the reflection (for
     * constructing and calling the real class) come back together, since
     * every caller so far has needed both.
     *
     * @return array{source: string, reflection: ReflectionClass<object>}
     */
    private static function generateRootClient(string $schema, string $namespace, string $sandboxPrefix): array
    {
        $output = self::makeSandboxDir($sandboxPrefix);

        $plan = self::generator()->generate(new Profile(
            schema: $schema,
            output: $output,
            namespace: $namespace,
        ));

        $source = '';

        foreach ($plan->writes as $path => $written) {
            if (basename($path) === 'ApiClient.php') {
                $source = $written;
            }
        }

        Assert::assertNotSame('', $source, 'the plan wrote no ApiClient.php');

        return ['source' => $source, 'reflection' => self::requireGeneratedClient($output, $namespace)];
    }

    /**
     * {@see generateRootClient} into the trait's own two static slots, so a
     * test's `setUpBeforeClass` is one line and does not grow its own copy
     * of the pair of properties plus the reflection accessor that goes with
     * them. That triplet is the next-largest clone family in the suite after
     * the four helpers this trait already collapsed — see
     * `deduplicate-the-test-suite`.
     */
    private static function generateRootClientOnce(string $schema, string $namespace, string $sandboxPrefix): void
    {
        $result = self::generateRootClient($schema, $namespace, $sandboxPrefix);
        self::$rootClientSource = $result['source'];
        self::$rootClientReflection = $result['reflection'];
    }

    /**
     * @return ReflectionClass<object>
     */
    private static function rootClientReflection(): ReflectionClass
    {
        Assert::assertInstanceOf(ReflectionClass::class, self::$rootClientReflection);

        return self::$rootClientReflection;
    }

    /**
     * One emitted file's source out of a plan, by the class it declares.
     *
     * @param array<string,string> $writes {@see GenerationPlan::$writes}
     */
    private static function plannedSource(array $writes, string $class): string
    {
        foreach ($writes as $path => $source) {
            if (basename($path, '.php') === $class) {
                return $source;
            }
        }

        Assert::fail("the plan wrote no {$class}.php");
    }

    /**
     * Calls a method on a dynamically-generated, `require`d client through
     * reflection rather than `$client->$method(...)` — the class lives in a
     * throwaway namespace synthesised at test run time, so static analysis
     * has no way to know its method surface.
     *
     * @param ReflectionClass<object> $reflection
     */
    private static function invokeGenerated(ReflectionClass $reflection, object $client, string $method, mixed ...$args): mixed
    {
        return $reflection->getMethod($method)->invoke($client, ...$args);
    }

    /**
     * Scans `get_declared_classes()` for one ending in `$needle`, which is
     * how every test that `require`s a dynamically-generated file into a
     * throwaway namespace recovers a genuine, checkable class-string —
     * compile-time literal FQCNs don't exist for code that didn't exist
     * until this process wrote and required it.
     *
     * @return class-string
     */
    private static function declaredClassEnding(string $needle): string
    {
        foreach (get_declared_classes() as $declared) {
            // `str_ends_with`, not `===`: PHPStan calls a `class-string` vs.
            // one literal `===` comparison unreachable.
            if (str_ends_with($declared, $needle)) {
                return $declared;
            }
        }

        Assert::fail("expected a class ending in {$needle} to be declared after requiring the generated file");
    }

    /**
     * The full text of one method in an emitted class, from its signature
     * line up to (not including) the blank line PsrPrinter inserts before
     * the next class member.
     */
    private static function methodSlice(string $source, string $method): string
    {
        $start = strpos($source, "\n    public function {$method}(");
        Assert::assertNotFalse($start, "method {$method} not found in emitted source");

        $end = strpos($source, "\n\n", $start);

        return substr($source, $start, ($end === false ? strlen($source) : $end) - $start);
    }
}
