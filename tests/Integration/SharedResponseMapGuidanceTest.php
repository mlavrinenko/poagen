<?php

declare(strict_types=1);

namespace Poagen\Generator\Tests\Integration;

use PHPUnit\Framework\TestCase;
use Poagen\Generator\Exception\UnrepresentableConstructsException;
use Poagen\Generator\Generator\Profile;
use Poagen\Generator\Tests\Support\GeneratedTreeSandbox;

use function dirname;

/**
 * `opt-in-collapse-for-repeated-response-maps`: every way a
 * `Profile::$responseMaps` entry can be wrong, and the run refusing it by
 * name.
 *
 * A group is a claim that two call sites mean the same thing. poagen cannot
 * check the meaning, but it can check that the claim is about operations the
 * document carries and that those operations do in fact declare one map — so
 * it does, and says which entry failed rather than emitting a client that
 * quietly answers one operation with another's responses.
 */
final class SharedResponseMapGuidanceTest extends TestCase
{
    use GeneratedTreeSandbox;

    private const string SCHEMA = 'tests/fixtures/schemas/shared-response-maps-3.0.yaml';

    private const string NAMESPACE = 'Poagen\\Generator\\Tests\\Fixtures\\Generated\\SharedResponseMaps';

    public static function tearDownAfterClass(): void
    {
        self::removeSandboxDirs();
    }

    public function testAnOperationTheDocumentDoesNotCarryFails(): void
    {
        $message = $this->refusal(['gatewayMutation' => ['deleteInvoice', 'archiveInvoice']]);

        self::assertStringContainsString("Profile::\$responseMaps['gatewayMutation']", $message);
        self::assertStringContainsString("names the operation id 'archiveInvoice'", $message);
        self::assertStringContainsString('absent from the schema', $message);
    }

    public function testOperationsWhoseMapsAreNotIdenticalFailNamingBoth(): void
    {
        $message = $this->refusal(['readOutcome' => ['deleteInvoice', 'getCustomer']]);

        self::assertStringContainsString("Profile::\$responseMaps['readOutcome']", $message);
        self::assertStringContainsString('response maps are not identical', $message);
        self::assertStringContainsString("'deleteInvoice' and 'getCustomer' differ on", $message);
        // The first status the two disagree about, and what each resolves to.
        self::assertStringContainsString("status '204'", $message);
    }

    /**
     * Proof the structural half really does run before the document is read:
     * the schema path names a file that does not exist, so a run that read
     * the document first would fail on the file rather than on the entry.
     */
    public function testAMalformedGroupFailsBeforeTheDocumentIsRead(): void
    {
        $message = $this->refusal(
            ['gatewayMutation' => ['deleteInvoice']],
            'tests/fixtures/schemas/no-such-document-3.0.yaml',
        );

        self::assertStringContainsString("Profile::\$responseMaps['gatewayMutation']", $message);
        self::assertStringContainsString('fewer than two operations', $message);
    }

    public function testEveryDocumentDependentProblemIsReportedInOnePass(): void
    {
        $message = $this->refusal([
            'gatewayMutation' => ['deleteInvoice', 'archiveInvoice'],
            'readOutcome' => ['voidInvoice', 'getCustomer'],
        ]);

        self::assertStringContainsString("names the operation id 'archiveInvoice'", $message);
        self::assertStringContainsString("'voidInvoice' and 'getCustomer' differ on", $message);
        self::assertStringContainsString('2 problems found; nothing was written', $message);
    }

    /**
     * @param array<string, list<string>> $responseMaps
     * @param string|null                 $schema       repo-relative, defaulting to the fixture document
     */
    private function refusal(array $responseMaps, ?string $schema = null): string
    {
        try {
            self::generator()->plan(new Profile(
                schema: $this->root() . '/' . ($schema ?? self::SCHEMA),
                output: self::makeSandboxDir('poagen-sharedmaps-guidance-'),
                namespace: self::NAMESPACE,
                responseMaps: $responseMaps,
            ));
            self::fail('expected UnrepresentableConstructsException');
        } catch (UnrepresentableConstructsException $e) {
            return $e->getMessage();
        }
    }

    private function root(): string
    {
        return dirname(__DIR__, 2);
    }
}
