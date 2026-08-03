<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Integration;

use Mlavrinenko\Paogen\Exception\UnrepresentableConstructsException;
use Mlavrinenko\Paogen\Generator\GenerationPlan;
use Mlavrinenko\Paogen\Generator\Profile;
use Mlavrinenko\Paogen\Tests\Support\GeneratedTreeSandbox;
use PHPUnit\Framework\TestCase;

use const DIRECTORY_SEPARATOR;

/**
 * `a-media-type-with-no-schema-takes-a-raw-body`: a media type carrying no
 * `schema` key at all declares nothing about its body, which is not the
 * same claim as a schema paogen cannot type — only the first passes.
 *
 * `postRaw` mirrors `repos/get-content`'s exact shape: `examples` and no
 * `schema`. `postUnrepresentable` proves the distinction holds the other
 * way — a `schema` paogen genuinely cannot represent still refuses,
 * unchanged, and mixing the two in one document is the fixture bullet 5
 * asks for.
 */
final class SchemalessBodyTest extends TestCase
{
    use GeneratedTreeSandbox;

    private const string SCHEMA = __DIR__ . '/../fixtures/schemas/schemaless-body-3.0.yaml';
    private const string NAMESPACE = 'Mlavrinenko\\Paogen\\Tests\\Tmp\\SchemalessBody';

    public static function tearDownAfterClass(): void
    {
        self::removeSandboxDirs();
    }

    /**
     * Bullet 1: a raw `array` parameter with an `array<string, mixed>`
     * docblock — the `KIND_JSON_MAP` surface a genuinely shapeless object
     * body already reaches, here arrived at by a media type with no
     * `schema` at all.
     */
    public function testAMediaTypeWithNoSchemaEmitsARawArrayParameter(): void
    {
        $client = $this->clientSource();

        self::assertStringContainsString('@param array<string, mixed> $body', $client);
        self::assertStringContainsString('public function postRaw(array $body): void', $client);
    }

    /**
     * Bullet 2: reported once per site on the notice channel, never moving
     * the exit status.
     */
    public function testTheRunReportsTheSiteOnTheNoticeChannel(): void
    {
        $plan = $this->plan(['postUnrepresentable' => 'fixture-only refusal']);

        $joined = implode("\n", $plan->notices);
        self::assertStringContainsString('/paths/~1raw/post/requestBody', $joined);
        self::assertStringContainsString('no `schema`', $joined);
        self::assertStringContainsString('array<string, mixed>', $joined);
    }

    /**
     * Bullet 3: a media type declaring a schema paogen cannot represent —
     * here a bare `type: string` JSON body, neither a `$ref`, an inline
     * object, nor an array of either — still refuses, unchanged.
     */
    public function testAMediaTypeWithAnUnrepresentableSchemaStillRefuses(): void
    {
        $message = $this->refusalMessage(['postRaw' => 'not under test here']);

        self::assertStringContainsString('postUnrepresentable', $message);
        self::assertStringContainsString('application/json request body with an inline (non-$ref) schema', $message);
    }

    /**
     * Only the genuinely unrepresentable operation needs a skip entry —
     * the schemaless one generates on its own.
     */
    public function testOnlyTheUnrepresentableOperationIsSkipped(): void
    {
        $plan = $this->plan(['postUnrepresentable' => 'fixture-only refusal']);

        self::assertCount(1, $plan->skippedOperations);
        self::assertSame('postUnrepresentable', $plan->skippedOperations[0]->operationId);
    }

    /**
     * @param array<string,string> $skip
     */
    private function plan(array $skip): GenerationPlan
    {
        return self::generator()->plan(new Profile(
            schema: self::SCHEMA,
            output: self::makeSandboxDir('paogen-schemaless-body-'),
            namespace: self::NAMESPACE,
            skip: $skip,
        ));
    }

    /**
     * @param array<string,string> $skip every refusal except the one under test —
     *                                    left unlisted so it surfaces in the exception
     */
    private function refusalMessage(array $skip): string
    {
        try {
            $this->plan($skip);
            self::fail('expected UnrepresentableConstructsException');
        } catch (UnrepresentableConstructsException $e) {
            return $e->getMessage();
        }
    }

    private function clientSource(): string
    {
        $plan = $this->plan(['postUnrepresentable' => 'fixture-only refusal']);

        foreach ($plan->writes as $path => $source) {
            if (str_ends_with($path, DIRECTORY_SEPARATOR . 'ApiClient.php')) {
                return $source;
            }
        }

        self::fail('the plan wrote no ApiClient.php');
    }

}
