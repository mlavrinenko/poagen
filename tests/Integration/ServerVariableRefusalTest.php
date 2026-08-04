<?php

declare(strict_types=1);

namespace Poagen\Generator\Tests\Integration;

use PHPUnit\Framework\TestCase;
use Poagen\Generator\Exception\UnrepresentableConstructsException;
use Poagen\Generator\Generator\Profile;
use Poagen\Generator\Tests\Support\GeneratedTreeSandbox;

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
    private const string NAMESPACE = 'Poagen\\Generator\\Tests\\Tmp\\ServerVariable';

    public static function tearDownAfterClass(): void
    {
        self::removeSandboxDirs();
    }

    public function testAServerVariableAbortsTheRunNamingTheVariableAndTheServer(): void
    {
        try {
            self::generator()->plan(new Profile(
                schema: self::SCHEMA,
                output: self::makeSandboxDir('poagen-server-variable-'),
                namespace: self::NAMESPACE,
            ));
            self::fail('expected UnrepresentableConstructsException');
        } catch (UnrepresentableConstructsException $e) {
            $message = $e->getMessage();

            self::assertStringContainsString('#/servers/0', $message);
            self::assertStringContainsString('https://{region}.api.example.com', $message);
            self::assertStringContainsString("'region'", $message);
            self::assertStringContainsString('does not substitute', $message);
            // Profile::$skip cannot accept this — a server is neither an
            // operation nor a component — so the message says so rather
            // than pointing a consumer at a remedy that will not work.
            self::assertStringContainsString('Profile::$skip cannot accept it', $message);
        }
    }

    public function testNothingIsWrittenWhenAServerVariableIsDeclared(): void
    {
        $outputDir = self::makeSandboxDir('poagen-server-variable-');

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
