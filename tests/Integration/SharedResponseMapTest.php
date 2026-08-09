<?php

declare(strict_types=1);

namespace Poagen\Generator\Tests\Integration;

use PHPUnit\Framework\TestCase;
use Poagen\Generator\Generator\GenerationPlan;
use Poagen\Generator\Generator\Profile;
use Poagen\Generator\Tests\Support\GeneratedTreeSandbox;

use function basename;
use function dirname;
use function substr_count;

/**
 * `opt-in-collapse-for-repeated-response-maps`: a consumer names the
 * operations whose response map is one shared declaration, and the emitter
 * writes it once — across sub-client classes, which is where the duplication
 * a per-class helper could never reach actually lives.
 *
 * The fixture document declares four operations. Three of them — two on
 * `billing`, one on `customers` — carry the identical response map, and the
 * fourth shares two of its three statuses. Only the three the profile names
 * collapse; the fourth keeps its own literal, which is the whole point of the
 * feature being opt-in rather than a shape-matching pass.
 */
final class SharedResponseMapTest extends TestCase
{
    use GeneratedTreeSandbox;

    private const string SCHEMA = 'tests/fixtures/schemas/shared-response-maps-3.0.yaml';

    private const string NAMESPACE = 'Poagen\\Generator\\Tests\\Fixtures\\Generated\\SharedResponseMaps';

    private const string PROFILE = 'tests/fixtures/profiles/shared-response-maps.php';

    /** @var array<string, list<string>> */
    private const array GROUPS = ['gatewayMutation' => ['deleteInvoice', 'voidInvoice', 'deleteCustomer']];

    public static function tearDownAfterClass(): void
    {
        self::removeSandboxDirs();
    }

    public function testTheSharedDeclarationIsEmittedOnceAndCalledFromBothSubClients(): void
    {
        $writes = $this->plan(self::GROUPS)->writes;

        $holder = self::plannedSource($writes, 'ResponseMaps');
        self::assertSame(1, substr_count($holder, 'public static function '), 'one method per declaration');
        self::assertStringContainsString('public static function gatewayMutation(): ResponseType', $holder);
        self::assertStringContainsString(
            "return ResponseType::envelope(new StatusResponseMap(exact: [['204', null], ['404', null]], "
                . 'default: ResponseType::nothing()));',
            $holder,
        );

        $billing = self::plannedSource($writes, 'BillingClient');
        $customers = self::plannedSource($writes, 'CustomersClient');

        self::assertStringContainsString('ResponseMaps::gatewayMutation(),', self::methodSlice($billing, 'deleteInvoice'));
        self::assertStringContainsString('ResponseMaps::gatewayMutation(),', self::methodSlice($billing, 'voidInvoice'));
        self::assertStringContainsString('ResponseMaps::gatewayMutation(),', self::methodSlice($customers, 'deleteCustomer'));
    }

    public function testAnOperationNoGroupNamesKeepsItsOwnLiteral(): void
    {
        $customers = self::plannedSource($this->plan(self::GROUPS)->writes, 'CustomersClient');
        $slice = self::methodSlice($customers, 'getCustomer');

        self::assertStringContainsString('ResponseType::envelope(new StatusResponseMap(', $slice);
        self::assertStringNotContainsString('ResponseMaps::', $slice);
    }

    /**
     * The collapsed client stops importing the two runtime contracts it no
     * longer names, and the shared declaration imports them instead — the
     * imports follow the code rather than being left behind as dead ones the
     * consumer's own style gate would then report.
     */
    public function testACollapsedClientDropsTheImportsItNoLongerUses(): void
    {
        $billing = self::plannedSource($this->plan(self::GROUPS)->writes, 'BillingClient');

        self::assertStringNotContainsString('use Poagen\\Runtime\\Contract\\StatusResponseMap;', $billing);
        self::assertStringNotContainsString('use Poagen\\Runtime\\Contract\\ResponseType;', $billing);
    }

    /**
     * The committed golden tree is what `just lint-jscpd-generated` and the
     * generated-tier PHPStan config actually measure, so it has to be the
     * bytes a run produces rather than a snapshot someone edited.
     */
    public function testTheRunMatchesTheCommittedGoldenTree(): void
    {
        $output = self::makeSandboxDir('poagen-sharedmaps-golden-');

        self::generator()->generate(new Profile(
            schema: $this->root() . '/' . self::SCHEMA,
            output: $output,
            namespace: self::NAMESPACE,
            responseMaps: self::GROUPS,
            source: self::PROFILE,
        ));

        self::assertSame(
            self::snapshotPhpTree($this->root() . '/tests/fixtures/generated/shared-response-maps'),
            self::snapshotPhpTree($output),
        );
    }

    /**
     * The byte-identity property the feature is judged on: a profile that
     * names nothing emits no holder, and every operation spells out its own
     * map exactly as it did before any of this existed. Both runs are of the
     * same document, so everything the group did not touch — the models, the
     * exception, the interfaces, the root client, and the client whose
     * operations no group named — must come back byte for byte identical.
     */
    public function testDeclaringNoGroupChangesNothing(): void
    {
        $inert = $this->plan([])->writes;
        $collapsed = $this->plan(self::GROUPS)->writes;

        self::assertSame([], $this->sourcesOf($inert, 'ResponseMaps'), 'no holder is emitted for an empty profile');

        $billing = self::plannedSource($inert, 'BillingClient');
        self::assertStringContainsString('ResponseType::envelope(new StatusResponseMap(', $billing);
        self::assertStringNotContainsString('ResponseMaps::', $billing);

        foreach (['Customer', 'ApiException', 'ApiClient', 'ApiClientInterface', 'BillingClientInterface'] as $class) {
            self::assertSame(
                self::plannedSource($inert, $class),
                self::plannedSource($collapsed, $class),
                "{$class} must not move when a group is declared elsewhere",
            );
        }
    }

    /**
     * @param array<string, list<string>> $responseMaps
     */
    private function plan(array $responseMaps): GenerationPlan
    {
        return self::generator()->plan(new Profile(
            schema: $this->root() . '/' . self::SCHEMA,
            output: self::makeSandboxDir('poagen-sharedmaps-'),
            namespace: self::NAMESPACE,
            responseMaps: $responseMaps,
            source: self::PROFILE,
        ));
    }

    /**
     * @param  array<string,string> $writes
     * @return list<string>         the sources declaring `$class`, empty when none does
     */
    private function sourcesOf(array $writes, string $class): array
    {
        $out = [];

        foreach ($writes as $path => $source) {
            if (basename($path, '.php') === $class) {
                $out[] = $source;
            }
        }

        return $out;
    }

    private function root(): string
    {
        return dirname(__DIR__, 2);
    }
}
