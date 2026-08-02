<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Unit;

use cebe\openapi\Reader;
use cebe\openapi\spec\OpenApi;
use Mlavrinenko\Paogen\Generator\Emit\ServerCatalog;
use PHPUnit\Framework\TestCase;

/**
 * Unit coverage for {@see ServerCatalog}, one level below the integration
 * tests that generate a whole client (`DeclaredServerConstantsTest`,
 * `ServerVariableRefusalTest`). These exercise the resolution rules
 * directly against a parsed document rather than through the full
 * generator pipeline.
 */
final class ServerCatalogTest extends TestCase
{
    public function testNoServersKeyResolvesToNoConstants(): void
    {
        $openApi = $this->parse("openapi: 3.0.3\ninfo:\n  title: t\n  version: '1'\npaths: {}\n");

        self::assertSame([], ServerCatalog::resolve($openApi));
        self::assertSame([], ServerCatalog::variableProblems($openApi));
    }

    public function testAnExplicitlyEmptyServersKeyResolvesToNoConstants(): void
    {
        // OpenAPI 3.0.3 §4.7.9.1 treats an absent and an explicitly empty
        // `servers:` identically — both default to a synthetic `url: /`
        // entry the document never wrote. Neither should be emitted.
        $openApi = $this->parse("openapi: 3.0.3\ninfo:\n  title: t\n  version: '1'\nservers: []\npaths: {}\n");

        self::assertSame([], ServerCatalog::resolve($openApi));
    }

    public function testTwoServersWithTheSameDescriptionGetDistinctConstantNames(): void
    {
        $openApi = $this->parse(
            "openapi: 3.0.3\ninfo:\n  title: t\n  version: '1'\n"
                . "servers:\n"
                . "  - url: https://a.example\n    description: api\n"
                . "  - url: https://b.example\n    description: api\n"
                . "paths: {}\n",
        );

        $servers = ServerCatalog::resolve($openApi);

        self::assertCount(2, $servers);
        self::assertSame('API', $servers[0]->constantName);
        self::assertSame('https://a.example', $servers[0]->url);
        self::assertSame('API_2', $servers[1]->constantName);
        self::assertSame('https://b.example', $servers[1]->url);
    }

    public function testADescriptionMadeOnlyOfDigitsGetsAPrefixSoTheConstantNameIsValidPhp(): void
    {
        $openApi = $this->parse(
            "openapi: 3.0.3\ninfo:\n  title: t\n  version: '1'\n"
                . "servers:\n  - url: https://a.example\n    description: '42'\n"
                . "paths: {}\n",
        );

        $servers = ServerCatalog::resolve($openApi);

        self::assertSame('SERVER_42', $servers[0]->constantName);
    }

    public function testAServerWithVariablesIsExcludedFromTheResolvedListAndReportedAsAProblem(): void
    {
        $openApi = $this->parse(
            "openapi: 3.0.3\ninfo:\n  title: t\n  version: '1'\n"
                . "servers:\n"
                . "  - url: https://static.example\n"
                . "  - url: https://{region}.example\n"
                . "    variables:\n      region:\n        default: us\n"
                . "paths: {}\n",
        );

        $servers = ServerCatalog::resolve($openApi);
        self::assertCount(1, $servers);
        self::assertSame('https://static.example', $servers[0]->url);

        $problems = ServerCatalog::variableProblems($openApi);
        self::assertCount(1, $problems);
        self::assertStringContainsString('#/servers/1', $problems[0]);
        self::assertStringContainsString("'region'", $problems[0]);
    }

    private function parse(string $yaml): OpenApi
    {
        $openApi = Reader::readFromYaml($yaml, OpenApi::class);
        self::assertInstanceOf(OpenApi::class, $openApi);

        return $openApi;
    }
}
