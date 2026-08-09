<?php

declare(strict_types=1);

namespace Poagen\Generator\Tests\Unit;

use cebe\openapi\spec\OpenApi;
use Nette\PhpGenerator\PhpNamespace;
use PHPUnit\Framework\TestCase;
use Poagen\Generator\Generator\Emit\EnvelopeSpec;
use Poagen\Generator\Generator\Emit\InlinePayloadCatalog;
use Poagen\Generator\Generator\Emit\ReturnSpec;
use Poagen\Generator\Generator\Emit\SharedResponseMapPlan;
use Poagen\Generator\SchemaReader;

use function dirname;

/**
 * `opt-in-collapse-for-repeated-response-maps`: the half of
 * `Profile::$responseMaps` validation only the document can answer, and the
 * lookup an emitted operation reads to find its shared declaration.
 *
 * Driven from a hand-built {@see InlinePayloadCatalog} rather than a full
 * generation run, because the three cases that matter here — an operation the
 * document never had, an operation the document has but this run does not
 * emit, and two operations whose maps disagree — are three states of that one
 * catalog, and telling them apart in the message is the whole point.
 */
final class SharedResponseMapPlanTest extends TestCase
{
    private const string CLIENT_NAMESPACE = 'Acme\\Gateway\\Generated';

    private const string MODEL_NAMESPACE = 'Acme\\Gateway\\Generated\\Model';

    public function testAGroupWhoseMembersShareOneMapPlansOneDeclaration(): void
    {
        $plan = $this->pairedWith($this->mutationEnvelope());

        self::assertSame([], $plan->failures);
        self::assertFalse($plan->isEmpty());
        self::assertSame(['deleteInvoice', 'voidInvoice'], $plan->membersOf('gatewayMutation'));
        self::assertSame(
            'ResponseMaps::gatewayMutation()',
            $plan->expressionFor(new PhpNamespace(self::CLIENT_NAMESPACE), 'deleteInvoice'),
        );
    }

    public function testAnOperationNoGroupNamesHasNoExpression(): void
    {
        $plan = $this->pairedWith($this->mutationEnvelope());

        self::assertNull($plan->expressionFor(new PhpNamespace(self::CLIENT_NAMESPACE), 'getCustomer'));
    }

    public function testNoGroupsPlansNothing(): void
    {
        $plan = $this->build([], ['deleteInvoice' => $this->mutationEnvelope()]);

        self::assertTrue($plan->isEmpty());
        self::assertSame([], $plan->failures);
        self::assertNull($plan->expressionFor(new PhpNamespace(self::CLIENT_NAMESPACE), 'deleteInvoice'));
    }

    public function testAnOperationAbsentFromTheDocumentFails(): void
    {
        $plan = $this->build(
            ['gatewayMutation' => ['deleteInvoice', 'archiveInvoice']],
            ['deleteInvoice' => $this->mutationEnvelope()],
        );

        self::assertCount(1, $plan->failures);
        self::assertStringContainsString("names the operation id 'archiveInvoice'", $plan->failures[0]);
        self::assertStringContainsString('absent from the schema', $plan->failures[0]);
        self::assertTrue($plan->isEmpty(), 'a group that failed plans no declaration');
    }

    /**
     * Told apart from the case above on purpose: the entry is not stale, the
     * operation is simply one this run does not emit, and "remove this entry,
     * or point it at the operation id the vendor now uses" would be the wrong
     * advice for it.
     */
    public function testAnOperationTheRunDoesNotEmitFailsDifferently(): void
    {
        $plan = $this->build(
            ['gatewayMutation' => ['deleteInvoice', 'voidInvoice']],
            ['deleteInvoice' => $this->mutationEnvelope()],
        );

        self::assertCount(1, $plan->failures);
        self::assertStringContainsString("names the operation id 'voidInvoice'", $plan->failures[0]);
        self::assertStringContainsString('no response map to share', $plan->failures[0]);
        self::assertStringNotContainsString('absent from the schema', $plan->failures[0]);
    }

    public function testMapsDifferingOnAStatusBodyFailNamingBothAndTheStatus(): void
    {
        $failures = $this->pairedWith($this->envelope([
            ['204', ReturnSpec::model('Customer')],
            ['404', ReturnSpec::void()],
        ]))->failures;

        self::assertCount(1, $failures);
        self::assertStringContainsString("'deleteInvoice' and 'voidInvoice' differ on", $failures[0]);
        self::assertStringContainsString("status '204'", $failures[0]);
        self::assertStringContainsString('ResponseType::object(Customer::class)', $failures[0]);
    }

    public function testMapsDifferingOnADeclaredStatusFailNamingIt(): void
    {
        $failures = $this->pairedWith($this->envelope([['204', ReturnSpec::void()]]))->failures;

        self::assertCount(1, $failures);
        self::assertStringContainsString("status '404'", $failures[0]);
        self::assertStringContainsString('the first declares and the second does not', $failures[0]);
    }

    public function testMapsDifferingOnlyInStatusOrderFail(): void
    {
        $failures = $this->pairedWith($this->envelope([
            ['404', ReturnSpec::void()],
            ['204', ReturnSpec::void()],
        ]))->failures;

        self::assertCount(1, $failures);
        self::assertStringContainsString('the order their statuses are declared in', $failures[0]);
    }

    private function mutationEnvelope(): EnvelopeSpec
    {
        return $this->envelope([['204', ReturnSpec::void()], ['404', ReturnSpec::void()]]);
    }

    /**
     * @param list<array{0: string, 1: ReturnSpec}> $exact
     */
    private function envelope(array $exact): EnvelopeSpec
    {
        return new EnvelopeSpec(exact: $exact, default: ReturnSpec::void());
    }

    /**
     * One group of two, `deleteInvoice` always carrying the mutation map and
     * `voidInvoice` carrying whatever the case under test wants to compare
     * against it.
     */
    private function pairedWith(EnvelopeSpec $second): SharedResponseMapPlan
    {
        return $this->build(
            ['gatewayMutation' => ['deleteInvoice', 'voidInvoice']],
            ['deleteInvoice' => $this->mutationEnvelope(), 'voidInvoice' => $second],
        );
    }

    /**
     * @param array<string, list<string>> $groups
     * @param array<string, EnvelopeSpec> $envelopes
     */
    private function build(array $groups, array $envelopes): SharedResponseMapPlan
    {
        return SharedResponseMapPlan::build(
            $groups,
            $this->document(),
            new InlinePayloadCatalog(envelopes: $envelopes),
            self::CLIENT_NAMESPACE,
            self::MODEL_NAMESPACE,
        );
    }

    private function document(): OpenApi
    {
        return SchemaReader::read(
            dirname(__DIR__, 2) . '/tests/fixtures/schemas/shared-response-maps-3.0.yaml',
        );
    }
}
