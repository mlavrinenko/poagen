<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Integration;

use Mlavrinenko\Paogen\Tests\Support\GeneratedTreeSandbox;
use PHPUnit\Framework\TestCase;

/**
 * emit-declared-servers-so-the-base-address-comes-from-the-document: the
 * document's `servers:` list reaches the emitted `ApiClient` as one
 * `public const string` per server, so a consumer reads the base address
 * off the client instead of retyping it from the schema.
 *
 * `multi-server-3.0.yaml` (three servers, two described, one not) proves the
 * "several declared servers all emit, in declaration order, distinguishable
 * by name or description" criterion — none of the four vendored documents
 * declare more than one server, so this fixture is the only thing that
 * exercises it. `single-server-3.0.yaml` (one server, no description)
 * proves the common single-server case still gets a usable constant name.
 */
final class DeclaredServerConstantsTest extends TestCase
{
    use GeneratedTreeSandbox;

    private const string MULTI_SERVER_SCHEMA = __DIR__ . '/../fixtures/schemas/multi-server-3.0.yaml';
    private const string SINGLE_SERVER_SCHEMA = __DIR__ . '/../fixtures/schemas/single-server-3.0.yaml';

    public static function tearDownAfterClass(): void
    {
        self::removeSandboxDirs();
    }

    public function testEachDeclaredServerEmitsADistinctConstantInDeclarationOrder(): void
    {
        $source = $this->generate(self::MULTI_SERVER_SCHEMA, 'MultiServer');

        self::assertStringContainsString(
            "public const string PRODUCTION = 'https://api.multi-server.example';",
            $source,
        );
        self::assertStringContainsString(
            "public const string STAGING = 'https://staging.multi-server.example';",
            $source,
        );
        self::assertStringContainsString(
            "public const string SERVER_3 = 'https://internal.multi-server.example';",
            $source,
        );

        // The first server is not silently treated as the only one: all
        // three constants are present, in the document's own order.
        $production = strpos($source, 'PRODUCTION');
        $staging = strpos($source, 'STAGING');
        $server3 = strpos($source, 'SERVER_3');

        self::assertNotFalse($production);
        self::assertNotFalse($staging);
        self::assertNotFalse($server3);
        self::assertLessThan($staging, $production, 'PRODUCTION (declared first) must print before STAGING');
        self::assertLessThan($server3, $staging, 'STAGING (declared second) must print before SERVER_3');
    }

    public function testDescribedServersCarryTheirDescriptionAsADocComment(): void
    {
        $source = $this->generate(self::MULTI_SERVER_SCHEMA, 'MultiServerDescriptions');

        self::assertStringContainsString("/** production */\n    public const string PRODUCTION", $source);
        self::assertStringContainsString("/** staging */\n    public const string STAGING", $source);
    }

    public function testASingleUndescribedServerStillGetsAConstant(): void
    {
        $source = $this->generate(self::SINGLE_SERVER_SCHEMA, 'SingleServerConstant');

        self::assertStringContainsString(
            "public const string SERVER_1 = 'https://single-server.example/api/v1';",
            $source,
        );
    }

    public function testTheConstructorStillTakesTheTransportAsAPlainArgument(): void
    {
        // The base address stays a transport constructor argument: nothing
        // about the constants makes the client choose its own address. The
        // constructor signature is unchanged by this feature and no
        // constant is referenced from inside it.
        $source = $this->generate(self::SINGLE_SERVER_SCHEMA, 'SingleServerConstructorUnchanged');

        $ctorStart = strpos($source, 'public function __construct(');
        self::assertNotFalse($ctorStart);
        $ctorEnd = strpos($source, "\n    }", $ctorStart);
        self::assertNotFalse($ctorEnd);
        $ctor = substr($source, $ctorStart, $ctorEnd - $ctorStart);

        self::assertStringContainsString('TransportInterface $transport', $ctor);
        self::assertStringNotContainsString('SERVER_1', $ctor);
        self::assertStringNotContainsString('self::SERVER', $ctor);
    }

    private function generate(string $schema, string $suffix): string
    {
        $result = self::generateRootClient(
            $schema,
            'Mlavrinenko\\Paogen\\Tests\\Tmp\\' . $suffix,
            'paogen-servers-' . $suffix . '-',
        );

        return $result['source'];
    }
}
