<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Integration;

use Mlavrinenko\Paogen\Exception\UnrepresentableConstructsException;
use Mlavrinenko\Paogen\Generator\Profile;
use Mlavrinenko\Paogen\Tests\Support\GeneratedTreeSandbox;
use PHPUnit\Framework\TestCase;

use const DIRECTORY_SEPARATOR;

/**
 * emit-declared-servers-so-the-base-address-comes-from-the-document: a
 * server variable — a `{region}`-style template with a declared enum and
 * default — is refused by name rather than substituted. What must not
 * happen is a constant carrying the unsubstituted template, which reads
 * like a usable URL and is not one. No vendored document (kilbil, petstore,
 * DigitalOcean, GitHub) declares a server variable, so
 * `server-variables-3.0.yaml` is the only thing that exercises this path.
 */
final class ServerVariableRefusalTest extends TestCase
{
    use GeneratedTreeSandbox;

    private const string SCHEMA = __DIR__ . '/../fixtures/schemas/server-variables-3.0.yaml';
    private const string NAMESPACE = 'Mlavrinenko\\Paogen\\Tests\\Tmp\\ServerVariable';

    public static function tearDownAfterClass(): void
    {
        self::removeSandboxDirs();
    }

    public function testAServerVariableAbortsTheRunNamingTheVariableAndTheServer(): void
    {
        try {
            self::generator()->plan(new Profile(
                schema: self::SCHEMA,
                output: self::makeSandboxDir('paogen-server-variable-'),
                namespace: self::NAMESPACE,
            ));
            self::fail('expected UnrepresentableConstructsException');
        } catch (UnrepresentableConstructsException $e) {
            $message = $e->getMessage();

            self::assertStringContainsString('#/servers/0', $message);
            self::assertStringContainsString('https://{region}.api.example.com', $message);
            self::assertStringContainsString("'region'", $message);
            self::assertStringContainsString('does not substitute', $message);
        }
    }

    public function testNothingIsWrittenWhenAServerVariableIsDeclared(): void
    {
        $outputDir = self::makeSandboxDir('paogen-server-variable-');

        try {
            self::generator()->generate(new Profile(
                schema: self::SCHEMA,
                output: $outputDir,
                namespace: self::NAMESPACE,
            ));
            self::fail('expected UnrepresentableConstructsException');
        } catch (UnrepresentableConstructsException) {
            self::assertDirectoryDoesNotExist($outputDir . DIRECTORY_SEPARATOR . 'Generated');
        }
    }
}
