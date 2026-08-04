<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Integration;

use Mlavrinenko\Paogen\Generator\GenerationPlan;
use Mlavrinenko\Paogen\Generator\Profile;
use Mlavrinenko\Paogen\Tests\Support\GeneratedTreeSandbox;
use Mlavrinenko\Paogen\Tests\Support\InlinePayloadPlanAssertions;
use PHPUnit\Framework\TestCase;

/**
 * name-inline-schemas-by-operation-and-status: every response status earns a
 * class, not only the one 2xx that drives the operation's return type.
 *
 * `getWidget` declares `200`, `403` and `default`, all inline objects. Before
 * this task only `200` was ever named — the other two were dropped without a
 * word, the same shrinkage `default-deny-on-degradation` names elsewhere.
 */
final class InlineMultiStatusResponseTest extends TestCase
{
    use GeneratedTreeSandbox;
    use InlinePayloadPlanAssertions;

    private const string SCHEMA = __DIR__ . '/../fixtures/schemas/inline-payload-multi-status-3.0.yaml';
    private const string NAMESPACE = 'Mlavrinenko\\Paogen\\Tests\\Tmp\\InlineMultiStatus';

    public static function tearDownAfterClass(): void
    {
        self::removeSandboxDirs();
    }

    public function testThePickedStatusStillDrivesTheReturnType(): void
    {
        $client = self::plannedSource($this->plan()->writes, 'ApiClient');

        self::assertStringContainsString('public function getWidget(string $id): GetWidget200Content', $client);
    }

    public function testEveryOtherStatusStillEarnsItsOwnClass(): void
    {
        $models = self::emittedNames($this->plan(), 'Model');

        self::assertContains('GetWidget200Content', $models);
        self::assertContains('GetWidget403Content', $models);
        self::assertContains('GetWidgetdefaultContent', $models);
    }

    public function testAnExtraStatusClassIsNotReferencedByTheClientYet(): void
    {
        // typed-error-responses is what wires a non-picked status into the
        // method signature or into ApiException — this task only names the
        // class. Not asserting the model is unreferenced would silently stop
        // covering the split the moment someone wires it in early.
        $client = self::plannedSource($this->plan()->writes, 'ApiClient');

        self::assertStringNotContainsString('GetWidget403Content', $client);
        self::assertStringNotContainsString('GetWidgetdefaultContent', $client);
    }

    /**
     * @param array<string, string|list<string>> $inlineModels
     */
    private function plan(array $inlineModels = []): GenerationPlan
    {
        $output = self::makeSandboxDir('paogen-inline-multi-status-');

        return self::generator()->plan(new Profile(
            schema: self::SCHEMA,
            output: $output,
            namespace: self::NAMESPACE,
            inlineModels: $inlineModels,
        ));
    }
}
