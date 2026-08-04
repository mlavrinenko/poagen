<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Integration;

use Mlavrinenko\Paogen\Generator\GenerationPlan;
use Mlavrinenko\Paogen\Generator\Profile;
use Mlavrinenko\Paogen\Tests\Support\GeneratedTreeSandbox;
use PHPUnit\Framework\TestCase;

use const DIRECTORY_SEPARATOR;

/**
 * skipped-operation-still-emits-its-payload-model: reachability, not the
 * skip entry alone, decides whether a synthesised payload model survives.
 *
 * {@see TypeListTest::testTheSkippedOperationsPayloadModelDoesNotEmitEither()}
 * covers the half where a skipped operation is the model's only owner. This
 * covers the other half — {@see InlinePayloadPlanner::build()} must not
 * remove a class a second, surviving operation still needs just because a
 * skipped one also named it. `keepsShared` and `dropsShared` both `$ref`
 * the same `components.requestBodies` entry and are pinned to the same
 * class name, so the shared node is claimed from two places; `dropsShared`
 * is skip-covered for a reason entirely unrelated to that shared body.
 */
final class SkippedOperationPayloadReachabilityTest extends TestCase
{
    use GeneratedTreeSandbox;

    private const string SCHEMA = __DIR__ . '/../fixtures/schemas/skipped-operation-shared-payload-3.1.yaml';
    private const string NAMESPACE = 'Mlavrinenko\\Paogen\\Tests\\Tmp\\SkippedOperationPayloadReachability';

    public static function tearDownAfterClass(): void
    {
        self::removeSandboxDirs();
    }

    public function testTheSharedModelStillEmitsForTheSurvivingOperation(): void
    {
        $plan = $this->plan();

        self::assertContains('SharedPayload', $this->modelNames($plan));
    }

    public function testTheSurvivingOperationStillReferencesTheSharedModel(): void
    {
        $client = $this->clientSource($this->plan());

        self::assertStringContainsString('public function keepsShared(SharedPayload $body): void', $client);
    }

    public function testTheSkippedOperationsMethodStillDoesNotEmit(): void
    {
        $client = $this->clientSource($this->plan());

        self::assertStringNotContainsString('public function dropsShared(', $client);
    }

    private function plan(): GenerationPlan
    {
        return self::generator()->plan(new Profile(
            schema: self::SCHEMA,
            output: self::makeSandboxDir('paogen-shared-payload-'),
            namespace: self::NAMESPACE,
            skip: ['dropsShared' => 'a `type: [object, string]` response — narrowing it needs the vendor'],
            inlineModels: [
                'SharedPayload' => ['keepsShared.request', 'dropsShared.request'],
            ],
        ));
    }

    /**
     * @return list<string>
     */
    private function modelNames(GenerationPlan $plan): array
    {
        $out = [];

        foreach (array_keys($plan->writes) as $path) {
            if (str_contains($path, DIRECTORY_SEPARATOR . 'Model' . DIRECTORY_SEPARATOR)) {
                $out[] = basename($path, '.php');
            }
        }

        return $out;
    }

    private function clientSource(GenerationPlan $plan): string
    {
        foreach ($plan->writes as $path => $source) {
            if (str_ends_with($path, DIRECTORY_SEPARATOR . 'ApiClient.php')) {
                return $source;
            }
        }

        self::fail('the plan wrote no ApiClient.php');
    }
}
