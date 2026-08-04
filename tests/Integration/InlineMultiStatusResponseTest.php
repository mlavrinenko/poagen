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
 * class. typed-error-responses wires every one of them into the operation's
 * envelope — `getWidget` declares `200`, `403` and `default`, all inline
 * objects, and all three now appear in the method's body-type union rather
 * than only the `200` that used to drive a bare return type.
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

    public function testEveryStatusDrivesTheEnvelopesBodyUnion(): void
    {
        $client = self::plannedSource($this->plan()->writes, 'ApiClient');

        self::assertStringContainsString(
            '@return Envelope<GetWidget200Content|GetWidget403Content|GetWidgetdefaultContent>',
            $client,
        );
        self::assertStringContainsString('public function getWidget(string $id): Envelope', $client);
    }

    public function testEveryStatusEarnsItsOwnClass(): void
    {
        $models = self::emittedNames($this->plan(), 'Model');

        self::assertContains('GetWidget200Content', $models);
        self::assertContains('GetWidget403Content', $models);
        self::assertContains('GetWidgetdefaultContent', $models);
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
