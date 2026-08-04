<?php

declare(strict_types=1);

namespace Poagen\Generator\Tests\Integration;

use PHPUnit\Framework\TestCase;
use Poagen\Generator\Exception\UnrepresentableConstructsException;
use Poagen\Generator\Generator\GenerationPlan;
use Poagen\Generator\Generator\Profile;
use Poagen\Generator\Tests\Support\GeneratedTreeSandbox;

use const DIRECTORY_SEPARATOR;

/**
 * operationid-word-splitting: separators are honoured, runs-together are
 * reported, and the answer comes from the profile.
 *
 * The two halves of the contract are easy to get wrong in opposite directions.
 * A document that *did* supply word boundaries must get them used — the old
 * "already camelCase" test admitted `_`, so `legal_info` passed through
 * untouched. A document that supplied none must not be guessed at, because a
 * dictionary gives a different answer per schema and moves names between runs.
 *
 * Uses the kilbil loyalty document, which is where both cases live: 33 of its
 * 36 operation ids are lowercase runs, two carry underscores, and one is a
 * single word with nothing to split.
 */
final class OperationIdNamingTest extends TestCase
{
    use GeneratedTreeSandbox;

    private const string SCHEMA = __DIR__ . '/../../examples/kilbil/schemas/loyalty_v1.yaml';
    private const string NAMESPACE = 'Poagen\\Generator\\Tests\\Tmp\\Kilbil';

    /**
     * The two XML bodies are a separate task (xml-content-type-policy); naming
     * them here keeps this test about names.
     *
     * @var array<string,string>
     */
    private const array XML_SKIP = [
        'goodsxml' => 'application/xml request body — xml-content-type-policy',
        'goodslistxml' => 'application/xml request body — xml-content-type-policy',
    ];

    public static function tearDownAfterClass(): void
    {
        self::removeSandboxDirs();
    }

    public function testAnIdentifierWithARealSeparatorIsSplitOnIt(): void
    {
        $client = $this->clientSource($this->plan());

        self::assertStringContainsString('public function generatePromocode(', $client);
        self::assertStringContainsString('public function legalInfo(', $client);
        self::assertStringNotContainsString('generate_promocode(', $client);
        self::assertStringNotContainsString('legal_info(', $client);
    }

    public function testAnIdentifierWithNoSeparatorKeepsTheVendorSpelling(): void
    {
        $client = $this->clientSource($this->plan());

        // No guess. `getclientfullbalance` has no algorithmic path to
        // `getClientFullBalance`, so the literal name is what is emitted until
        // the consumer says otherwise.
        self::assertStringContainsString('public function getclientfullbalance(', $client);
    }

    public function testUnseparatedIdentifiersAreReportedWithTheGuidanceThatFixesThem(): void
    {
        $notice = $this->operationIdNotice($this->plan());

        self::assertStringContainsString('getclientfullbalance', $notice);
        self::assertStringContainsString('methodRenames', $notice);
        // A notice is never a failure: nothing was omitted, the client is only
        // less pleasant to call.
        self::assertNotSame([], $this->plan()->writes);
    }

    public function testAMethodRenameNamesBothTheMethodAndItsPayloadModels(): void
    {
        $plan = $this->plan(['getclientfullbalance' => 'getClientFullBalance']);

        self::assertStringContainsString('public function getClientFullBalance(', $this->clientSource($plan));

        // One entry, two improvements: the synthesised payload classes are
        // derived from the normalised method name, not the raw id. This
        // operation's 2xx response is an array of inline objects, so the class
        // poagen names for it is the item.
        $models = $this->emittedNames($plan);
        self::assertContains('GetClientFullBalanceRequestContent', $models);
        self::assertContains('GetClientFullBalance200ContentItem', $models);
        self::assertNotContains('GetclientfullbalanceRequestContent', $models);
    }

    public function testAnAnsweredIdentifierDropsOutOfTheReport(): void
    {
        // The notice's own worked example names `getclientfullbalance`, so the
        // count is what moves rather than the presence of the string.
        self::assertStringContainsString('34 operation id(s)', $this->operationIdNotice($this->plan()));
        self::assertStringContainsString(
            '33 operation id(s)',
            $this->operationIdNotice($this->plan(['getclientfullbalance' => 'getClientFullBalance'])),
        );
    }

    /**
     * The plan's notices carry the unrecognised-format report too; this is the
     * operation-id one.
     */
    private function operationIdNotice(GenerationPlan $plan): string
    {
        foreach ($plan->notices as $notice) {
            if (str_contains($notice, 'operation id(s) carry no word boundary')) {
                return $notice;
            }
        }

        self::fail('no operation-id notice was reported');
    }

    public function testARenameNamingAnAbsentOperationIdFailsTheRun(): void
    {
        try {
            $this->plan(['noSuchOperation' => 'whatever']);
            self::fail('expected UnrepresentableConstructsException');
        } catch (UnrepresentableConstructsException $e) {
            self::assertStringContainsString('noSuchOperation', $e->getMessage());
            self::assertStringContainsString('absent from the schema', $e->getMessage());
        }
    }

    /**
     * @param array<string,string> $methodRenames
     */
    private function plan(array $methodRenames = []): GenerationPlan
    {
        return self::generator()->plan(new Profile(
            schema: self::SCHEMA,
            output: self::makeSandboxDir('poagen-opid-'),
            namespace: self::NAMESPACE,
            skip: self::XML_SKIP,
            methodRenames: $methodRenames,
        ));
    }

    /**
     * The whole caller surface, concatenated. kilbil tags every operation, so the
     * methods live on the tag sub-clients rather than on the root — and which tag
     * a method landed on is not what these assertions are about.
     */
    private function clientSource(GenerationPlan $plan): string
    {
        $out = '';

        foreach ($plan->writes as $path => $source) {
            if (!str_contains($path, DIRECTORY_SEPARATOR . 'Model' . DIRECTORY_SEPARATOR)
                && !str_contains($path, DIRECTORY_SEPARATOR . 'Enum' . DIRECTORY_SEPARATOR)) {
                $out .= $source . "\n";
            }
        }

        self::assertNotSame('', $out, 'the plan wrote no caller surface at all');

        return $out;
    }

    /**
     * @return list<string>
     */
    private function emittedNames(GenerationPlan $plan): array
    {
        $out = [];

        foreach (array_keys($plan->writes) as $path) {
            $out[] = basename($path, '.php');
        }

        return $out;
    }
}
