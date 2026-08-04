<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Integration;

use Mlavrinenko\Paogen\Generator\GenerationPlan;
use Mlavrinenko\Paogen\Generator\Profile;
use Mlavrinenko\Paogen\Tests\Support\GeneratedTreeSandbox;
use PHPUnit\Framework\TestCase;

use const DIRECTORY_SEPARATOR;

/**
 * path-parameter-skip-leaks-its-payload-model-the-same-way: the sibling of
 * {@see SkippedOperationPayloadReachabilityTest}. That task filtered
 * {@see InlinePayloadPlanner} on the document-wide schema-scan refusals
 * {@see Generator::plan()} computes before payload naming runs. But
 * {@see OperationEmitter::emit()} can also drop an operation for a path
 * parameter that does not resolve, and that decision used to surface only at
 * emission time — after model planning had already queued the operation's
 * inline payload model.
 *
 * `keepsShared` and `dropsShared` both `$ref` the same
 * `components.requestBodies` entry and are pinned to the same class name, so
 * the shared node is claimed from two places; `dropsShared` is skip-covered
 * for an unresolvable path parameter entirely unrelated to that shared body.
 * `soleOwner` carries the same unresolvable path parameter but owns its
 * inline request model outright — nothing else references it.
 */
final class SkippedOperationPathParameterPayloadReachabilityTest extends TestCase
{
    use GeneratedTreeSandbox;

    private const string SCHEMA = __DIR__ . '/../fixtures/schemas/skipped-operation-unresolvable-path-parameter-3.1.yaml';
    private const string NAMESPACE = 'Mlavrinenko\\Paogen\\Tests\\Tmp\\SkippedOperationPathParameterPayloadReachability';

    public static function tearDownAfterClass(): void
    {
        self::removeSandboxDirs();
    }

    public function testTheSharedModelStillEmitsForTheSurvivingOperation(): void
    {
        self::assertTrue($this->hasModel($this->plan(), 'SharedPayload'));
    }

    public function testTheSurvivingOperationStillReferencesTheSharedModel(): void
    {
        $client = self::plannedSource($this->plan()->writes, 'ApiClient');

        self::assertStringContainsString('public function keepsShared(SharedPayload $body): void', $client);
    }

    public function testTheSkippedOperationsMethodStillDoesNotEmit(): void
    {
        $client = self::plannedSource($this->plan()->writes, 'ApiClient');

        self::assertStringNotContainsString('public function dropsShared(', $client);
    }

    /**
     * The leak this task closes: `soleOwner` is the only operation naming its
     * own inline request body, so accepting its skip has to drop the
     * synthesised model along with the method — otherwise the emitted tree
     * carries a class nothing calls, referencing nothing else either.
     */
    public function testTheSkippedOperationsOwnPayloadModelDoesNotEmitEither(): void
    {
        self::assertFalse($this->hasModel($this->plan(), 'SoleOwnerRequest'));
    }

    public function testTheSoleOwnersMethodDoesNotEmit(): void
    {
        $client = self::plannedSource($this->plan()->writes, 'ApiClient');

        self::assertStringNotContainsString('public function soleOwner(', $client);
    }

    private function plan(): GenerationPlan
    {
        return self::generator()->plan(new Profile(
            schema: self::SCHEMA,
            output: self::makeSandboxDir('paogen-path-parameter-shared-payload-'),
            namespace: self::NAMESPACE,
            skip: [
                'dropsShared' => "parameter 'selector' (in: path, type: object) is outside paogen's supported parameter shapes",
                'soleOwner' => "parameter 'selector' (in: path, type: object) is outside paogen's supported parameter shapes",
            ],
            inlineModels: [
                'keepsShared.request' => 'SharedPayload',
                'dropsShared.request' => 'SharedPayload',
            ],
        ));
    }

    /** Whether a model class named `$class` is among `$plan`'s writes. */
    private function hasModel(GenerationPlan $plan, string $class): bool
    {
        foreach (array_keys($plan->writes) as $path) {
            if (basename($path, '.php') !== $class) {
                continue;
            }

            if (str_contains($path, DIRECTORY_SEPARATOR . 'Model' . DIRECTORY_SEPARATOR)) {
                return true;
            }
        }

        return false;
    }
}
