<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Integration;

use Mlavrinenko\Paogen\Generator\GenerationPlan;
use Mlavrinenko\Paogen\Generator\Profile;
use Mlavrinenko\Paogen\Tests\Support\GeneratedTreeSandbox;
use PHPUnit\Framework\TestCase;

use const DIRECTORY_SEPARATOR;
use const SORT_STRING;

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

    private const string SCHEMA = __DIR__ . '/../fixtures/schemas/inline-payload-multi-status-3.0.yaml';
    private const string NAMESPACE = 'Mlavrinenko\\Paogen\\Tests\\Tmp\\InlineMultiStatus';

    public static function tearDownAfterClass(): void
    {
        self::removeSandboxDirs();
    }

    public function testThePickedStatusStillDrivesTheReturnType(): void
    {
        $client = $this->clientSource($this->plan());

        self::assertStringContainsString('public function getWidget(string $id): GetWidget200Content', $client);
    }

    public function testEveryOtherStatusStillEarnsItsOwnClass(): void
    {
        $models = $this->modelNames($this->plan());

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
        $client = $this->clientSource($this->plan());

        self::assertStringNotContainsString('GetWidget403Content', $client);
        self::assertStringNotContainsString('GetWidgetdefaultContent', $client);
    }

    /**
     * @param array<string,string> $inlineModels
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

    private function clientSource(GenerationPlan $plan): string
    {
        foreach ($plan->writes as $path => $source) {
            if (str_ends_with($path, DIRECTORY_SEPARATOR . 'ApiClient.php')) {
                return $source;
            }
        }

        self::fail('the plan wrote no ApiClient.php');
    }

    /**
     * @return list<string>
     */
    private function modelNames(GenerationPlan $plan): array
    {
        $needle = DIRECTORY_SEPARATOR . 'Model' . DIRECTORY_SEPARATOR;
        $out = [];

        foreach (array_keys($plan->writes) as $path) {
            if (str_contains($path, $needle)) {
                $out[] = basename($path, '.php');
            }
        }

        sort($out, SORT_STRING);

        return $out;
    }
}
