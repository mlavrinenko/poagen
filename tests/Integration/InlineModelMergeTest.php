<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Integration;

use Mlavrinenko\Paogen\Exception\UnrepresentableConstructsException;
use Mlavrinenko\Paogen\Generator\GenerationPlan;
use Mlavrinenko\Paogen\Generator\Profile;
use Mlavrinenko\Paogen\Tests\Support\GeneratedTreeSandbox;
use Mlavrinenko\Paogen\Tests\Support\InlinePayloadPlanAssertions;
use PHPUnit\Framework\TestCase;

/**
 * name-inline-schemas-by-operation-and-status: `Profile::$inlineModels` reads
 * as one class name to many sites, and nothing merges without an entry there.
 *
 * getA, getB and getC declare structurally identical `200` responses;
 * postE and postF declare structurally identical request bodies; getD's
 * `200` looks the same but its `code` property does not match.
 */
final class InlineModelMergeTest extends TestCase
{
    use GeneratedTreeSandbox;
    use InlinePayloadPlanAssertions;

    private const string SCHEMA = __DIR__ . '/../fixtures/schemas/inline-model-merge-3.0.yaml';
    private const string NAMESPACE = 'Mlavrinenko\\Paogen\\Tests\\Tmp\\InlineModelMerge';

    public static function tearDownAfterClass(): void
    {
        self::removeSandboxDirs();
    }

    public function testNothingMergesWithoutAProfileEntry(): void
    {
        $models = self::emittedNames($this->plan(), 'Model');

        self::assertContains('GetA200Content', $models);
        self::assertContains('GetB200Content', $models);
        self::assertContains('GetC200Content', $models);
    }

    public function testASingleSitePinStillJustRenames(): void
    {
        $models = self::emittedNames($this->plan(['Renamed' => 'getA.200']), 'Model');

        self::assertContains('Renamed', $models);
        self::assertNotContains('GetA200Content', $models);
    }

    public function testSeveralSitesUnderOneClassMergeIntoOneFileAndAreBothReferenced(): void
    {
        $plan = $this->plan(['SharedError' => ['getA.200', 'getB.200', 'getC.200']]);
        $models = self::emittedNames($plan, 'Model');

        // One file, not three.
        self::assertContains('SharedError', $models);
        self::assertNotContains('GetA200Content', $models);
        self::assertNotContains('GetB200Content', $models);
        self::assertNotContains('GetC200Content', $models);

        $client = self::plannedSource($plan->writes, 'ApiClient');
        self::assertStringContainsString('public function getA(): SharedError', $client);
        self::assertStringContainsString('public function getB(): SharedError', $client);
        self::assertStringContainsString('public function getC(): SharedError', $client);
    }

    public function testARequestSiteMergeWorksTheSameWay(): void
    {
        $models = self::emittedNames($this->plan(['SharedRequest' => ['postE.request', 'postF.request']]), 'Model');

        self::assertContains('SharedRequest', $models);
        self::assertNotContains('PostERequestContent', $models);
        self::assertNotContains('PostFRequestContent', $models);
    }

    public function testAMismatchedMergeFailsNamingTheTwoSitesAndTheProperty(): void
    {
        try {
            $this->plan(['SharedError' => ['getA.200', 'getD.200']]);
            self::fail('expected UnrepresentableConstructsException');
        } catch (UnrepresentableConstructsException $e) {
            $message = $e->getMessage();
            self::assertStringContainsString('getA.200', $message);
            self::assertStringContainsString('getD.200', $message);
            self::assertStringContainsString('code', $message);
        }
    }

    public function testASiteAbsentFromTheDocumentFailsTheRun(): void
    {
        try {
            $this->plan(['Whatever' => ['getA.200', 'noSuchOperation.200']]);
            self::fail('expected UnrepresentableConstructsException');
        } catch (UnrepresentableConstructsException $e) {
            $message = $e->getMessage();
            self::assertStringContainsString('noSuchOperation.200', $message);
            self::assertStringContainsString('absent from the schema', $message);
        }
    }

    public function testASiteNamingAStatusTheOperationDoesNotDeclareFailsTheRun(): void
    {
        try {
            $this->plan(['Whatever' => 'getA.403']);
            self::fail('expected UnrepresentableConstructsException');
        } catch (UnrepresentableConstructsException $e) {
            self::assertStringContainsString('getA.403', $e->getMessage());
        }
    }

    /**
     * @param array<string, string|list<string>> $inlineModels
     */
    private function plan(array $inlineModels = []): GenerationPlan
    {
        $output = self::makeSandboxDir('paogen-inline-merge-');

        return self::generator()->plan(new Profile(
            schema: self::SCHEMA,
            output: $output,
            namespace: self::NAMESPACE,
            inlineModels: $inlineModels,
        ));
    }
}
