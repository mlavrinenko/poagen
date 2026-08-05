<?php

declare(strict_types=1);

namespace Poagen\Generator\Tests\Integration;

use PHPUnit\Framework\TestCase;
use Poagen\Generator\Tests\Fixtures\Generated\UnionSelection\Generated\Model\Cat;
use Poagen\Generator\Tests\Fixtures\Generated\UnionSelection\Generated\Model\Celsius;
use Poagen\Generator\Tests\Fixtures\Generated\UnionSelection\Generated\Model\Dog;
use Poagen\Generator\Tests\Fixtures\Generated\UnionSelection\Generated\Model\Enclosure;
use Poagen\Generator\Tests\Fixtures\Generated\UnionSelection\Generated\Model\Habitat;
use Poagen\Generator\Tests\Fixtures\Generated\UnionSelection\Generated\Model\Reading;
use Poagen\Generator\Tests\Fixtures\Generated\UnionSelection\Generated\Model\Sighting;
use Poagen\Generator\Tests\Fixtures\Generated\UnionSelection\Generated\Model\Vacant;
use Poagen\Runtime\Marshal\Hydrator;
use Poagen\Runtime\Marshal\UnionBranchException;

/**
 * declare-an-undiscriminated-union-as-raw-data, both halves at once.
 *
 * Hydrates the *emitted* classes rather than hand-written stand-ins, so the
 * attribute the generator writes and the rule the runtime applies are pinned
 * against each other: a change to either that the other does not follow fails
 * here rather than in a consumer's production data.
 *
 * The contract under test is one sentence. Exactly one branch, or an exception —
 * a payload matching zero branches and a payload matching two both raise, and
 * neither is ever resolved by taking the first match. That is the whole reason
 * computing a discriminating field at generation time is safe.
 *
 * Lives in `tests/Integration/`, not `runtime/tests/`
 * (`bundle-the-runtime-package-with-its-own-ci-tooling`): this is a deliberate
 * pin between two packages, not a unit test of either alone, and it needs the
 * generator's committed `union-selection` golden tree to exist at all. Moving
 * it under `runtime/` would either break the moment the generator is absent
 * (the whole point of that task) or force a duplicate copy of the golden tree
 * to live there too — which would just as quietly drift from the real one,
 * the exact failure mode a pin exists to catch. `Poagen\Runtime\Tests\
 * UnionBranchSelectionTest` does not exist — the runtime's own hydrator
 * branch-selection unit coverage lives across `runtime/tests/
 * MarshalRoundTripTest.php` (discriminated unions) and
 * `runtime/tests/TransportResponseKindsTest.php` (`ResponseType::union()`
 * directly), both against this package's own hand-written fixtures rather
 * than emitted ones.
 */
final class UnionBranchSelectionTest extends TestCase
{
    public function testDiscriminatingFieldSelectsTheBranchThatDeclaresIt(): void
    {
        $sighting = new Hydrator()->hydrate(Sighting::class, ['creature' => ['bark' => 'woof']]);

        self::assertInstanceOf(Dog::class, $sighting->creature);
        self::assertSame('woof', $sighting->creature->bark);
    }

    public function testTheOtherBranchIsSelectedByItsOwnField(): void
    {
        $sighting = new Hydrator()->hydrate(Sighting::class, ['creature' => ['meow' => 'mrrp']]);

        self::assertInstanceOf(Cat::class, $sighting->creature);
    }

    /**
     * Zero matches. The payload is a real object and carries none of the fields
     * any branch made decisive, so nothing names a branch.
     */
    public function testAPayloadMatchingNoBranchRaises(): void
    {
        $this->expectException(UnionBranchException::class);
        $this->expectExceptionMessage('matched none of the union branches');

        new Hydrator()->hydrate(Sighting::class, ['creature' => ['scales' => 'green']]);
    }

    /**
     * Two matches — the kitchen-sink payload strict validation worries about.
     * It becomes an exception here rather than a silently wrong object, which
     * is the trade the whole design rests on.
     */
    public function testAPayloadMatchingTwoBranchesRaises(): void
    {
        $this->expectException(UnionBranchException::class);
        $this->expectExceptionMessage('matched 2 union branches at once');

        new Hydrator()->hydrate(Sighting::class, ['creature' => ['bark' => 'woof', 'meow' => 'mrrp']]);
    }

    public function testTheNoMatchMessageNamesThePropertyAndTheKeysItSaw(): void
    {
        try {
            new Hydrator()->hydrate(Sighting::class, ['creature' => ['scales' => 'green']]);
            self::fail('expected UnionBranchException');
        } catch (UnionBranchException $e) {
            self::assertStringContainsString("property 'creature'", $e->getMessage());
            self::assertStringContainsString('the keys scales', $e->getMessage());
        }
    }

    /**
     * The closed-shape predicate: `Vacant` declares no properties and closes
     * itself, so an empty payload names it and nothing else does.
     */
    public function testAnEmptyPayloadSelectsTheClosedBranch(): void
    {
        $enclosure = new Hydrator()->hydrate(Enclosure::class, ['occupant' => []]);

        self::assertInstanceOf(Vacant::class, $enclosure->occupant);
    }

    public function testANonEmptyPayloadNeverSelectsTheClosedBranch(): void
    {
        $enclosure = new Hydrator()->hydrate(Enclosure::class, ['occupant' => ['bark' => 'woof']]);

        self::assertInstanceOf(Dog::class, $enclosure->occupant);
    }

    /**
     * A closed branch is decided by the absence of fields, so a payload with
     * fields nobody claims matches nothing at all rather than falling back to it.
     */
    public function testAnUnknownFieldDoesNotFallBackToTheClosedBranch(): void
    {
        $this->expectException(UnionBranchException::class);

        new Hydrator()->hydrate(Enclosure::class, ['occupant' => ['scales' => 'green']]);
    }

    public function testATagOnTheEnclosingObjectSelectsTheBranch(): void
    {
        $habitat = new Hydrator()->hydrate(Habitat::class, [
            'species' => 'cat',
            'resident' => ['meow' => 'mrrp'],
        ]);

        self::assertInstanceOf(Cat::class, $habitat->resident);
    }

    /**
     * The tag is read from the enclosing payload, so it decides on its own. A
     * payload carrying both branches' decisive fields is exactly the two-match
     * the structural rule refuses; with a tag there is nothing to be ambiguous
     * about, and it resolves.
     */
    public function testTheParentTagResolvesAPayloadTheStructuralRuleWouldRefuse(): void
    {
        $payload = ['bark' => 'woof', 'meow' => 'mrrp'];

        $habitat = new Hydrator()->hydrate(Habitat::class, [
            'species' => 'cat',
            'resident' => $payload,
        ]);

        self::assertInstanceOf(Cat::class, $habitat->resident);
        self::assertSame('mrrp', $habitat->resident->meow);

        // The same payload, without a tag to read, is the refusal case.
        $this->expectException(UnionBranchException::class);
        new Hydrator()->hydrate(Sighting::class, ['creature' => $payload]);
    }

    public function testAnAbsentParentTagRaises(): void
    {
        $this->expectException(UnionBranchException::class);
        $this->expectExceptionMessage('absent from the enclosing payload');

        new Hydrator()->hydrate(Habitat::class, ['resident' => ['meow' => 'mrrp']]);
    }

    public function testAnUnmappedParentTagValueRaises(): void
    {
        $this->expectException(UnionBranchException::class);
        $this->expectExceptionMessage("carries 'ferret', which no branch is mapped to");

        new Hydrator()->hydrate(Habitat::class, [
            'species' => 'ferret',
            'resident' => ['meow' => 'mrrp'],
        ]);
    }

    /**
     * A pinned property is not a union at all by the time it reaches the
     * runtime — the generator typed it as the one class, so there is no branch
     * to pick and nothing to raise. This is also the wrong-looking-right shape
     * the pin's own notice warns about on every run: a Fahrenheit payload
     * arrives as a Celsius without complaint.
     */
    public function testAPinnedPropertyHydratesAsTheSingleClassItWasTypedAs(): void
    {
        $reading = new Hydrator()->hydrate(Reading::class, ['sample' => ['degrees' => 42.0]]);

        self::assertInstanceOf(Celsius::class, $reading->sample);
        self::assertSame(42.0, $reading->sample->degrees);
    }
}
