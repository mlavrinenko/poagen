<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Unit\Runtime;

use Mlavrinenko\Paogen\Runtime\Contract\ResponseType;
use Mlavrinenko\Paogen\Runtime\Http\HttpTransport;
use Mlavrinenko\Paogen\Runtime\Marshal\UnionBranchException;
use Mlavrinenko\Paogen\Tests\Fixtures\Generated\UnionResponse\Generated\ApiClient;
use Mlavrinenko\Paogen\Tests\Fixtures\Generated\UnionResponse\Generated\ApiException;
use Mlavrinenko\Paogen\Tests\Fixtures\Generated\UnionResponse\Generated\Model\Cat;
use Mlavrinenko\Paogen\Tests\Fixtures\Generated\UnionResponse\Generated\Model\Celsius;
use Mlavrinenko\Paogen\Tests\Fixtures\Generated\UnionResponse\Generated\Model\Dog;
use Mlavrinenko\Paogen\Tests\Fixtures\Generated\UnionResponse\Generated\Model\GetRestrictionsResponseBranch2;
use Mlavrinenko\Paogen\Tests\Generated\RecordingClient;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7\Response;
use PHPUnit\Framework\TestCase;

/**
 * `a-union-response-selects-its-branch`, driven through the *emitted*
 * `union-response` fixture rather than through {@see ResponseType}
 * calls this test builds by hand — the same discipline
 * {@see UnionBranchSelectionTest} already applies to a union property: the
 * generator's own output and the runtime's own rule are pinned against each
 * other, so a change to either that the other does not follow fails here
 * rather than in a consumer's production data.
 *
 * `getCreature()`'s plain structural union (no discriminator, no guidance)
 * is the one bullet in the task's acceptance criteria names outright: one
 * payload per branch, a payload matching neither, and a payload matching
 * both — the three outcomes a response union has and no others.
 */
final class ResponseUnionSelectionTest extends TestCase
{
    public function testAPayloadCarryingOnlyOneBranchsFieldSelectsThatBranch(): void
    {
        $dog = $this->client('{"bark":"woof"}')->getCreature();

        self::assertInstanceOf(Dog::class, $dog);
        self::assertSame('woof', $dog->bark);
    }

    public function testTheOtherBranchIsSelectedByItsOwnField(): void
    {
        $cat = $this->client('{"meow":"mrrp"}')->getCreature();

        self::assertInstanceOf(Cat::class, $cat);
        self::assertSame('mrrp', $cat->meow);
    }

    public function testAPayloadMatchingNeitherBranchRaises(): void
    {
        $this->expectException(UnionBranchException::class);
        $this->expectExceptionMessage('matched none of the union branches');

        $this->client('{"scales":"green"}')->getCreature();
    }

    public function testAPayloadMatchingBothBranchesRaises(): void
    {
        $this->expectException(UnionBranchException::class);
        $this->expectExceptionMessage('matched 2 union branches at once');

        $this->client('{"bark":"woof","meow":"mrrp"}')->getCreature();
    }

    /**
     * Layer one: the document's own `discriminator`, carrying an explicit
     * `mapping` whose wire values (`canine`/`feline`) are not either
     * branch's class name — the reading no property-position union in
     * either vendored corpus has ever exercised, because none declares one.
     */
    public function testADocumentDiscriminatorWithAnExplicitMappingSelectsByItsWireValue(): void
    {
        $dog = $this->client('{"kind":"canine","bark":"woof"}')->getTaggedCreature();

        self::assertInstanceOf(Dog::class, $dog);
    }

    public function testTheMappingsOtherValueSelectsTheOtherBranch(): void
    {
        $cat = $this->client('{"kind":"feline","meow":"mrrp"}')->getTaggedCreature();

        self::assertInstanceOf(Cat::class, $cat);
    }

    public function testATagValueTheMappingDoesNotNameRaises(): void
    {
        $this->expectException(UnionBranchException::class);
        $this->expectExceptionMessage("carries 'reptile', which no branch is mapped to");

        $this->client('{"kind":"reptile","scales":"green"}')->getTaggedCreature();
    }

    /**
     * The closed-shape predicate, mirrored from
     * `interactions/get-restrictions-for-org`'s exact shape: an empty
     * payload selects the branch that declared no properties and closed
     * itself, and a non-empty one never does.
     */
    public function testAnEmptyPayloadSelectsTheClosedBranch(): void
    {
        $result = $this->client('{}')->getRestrictions();

        self::assertInstanceOf(GetRestrictionsResponseBranch2::class, $result);
    }

    public function testANonEmptyPayloadSelectsTheOtherBranchInstead(): void
    {
        $result = $this->client('{"bark":"woof"}')->getRestrictions();

        self::assertInstanceOf(Dog::class, $result);
    }

    /**
     * `listCreatures()` reads `anyOf: [array<Dog>, array<Cat>]` as
     * `list<Dog|Cat>` — each element is independently branch-selected, the
     * same rule `getCreature()` applies to a whole body, applied item by
     * item. An empty list has no item to decide and raises nothing, which
     * is what makes an empty paginated list unremarkable rather than a
     * fourth outcome.
     */
    public function testEveryItemInTheListIsIndependentlyBranchSelected(): void
    {
        $items = $this->client('[{"bark":"woof"},{"meow":"mrrp"}]')->listCreatures();

        self::assertCount(2, $items);
        self::assertInstanceOf(Dog::class, $items[0]);
        self::assertInstanceOf(Cat::class, $items[1]);
    }

    public function testAnEmptyListRaisesNothingBecauseNoItemNeedsAPick(): void
    {
        self::assertSame([], $this->client('[]')->listCreatures());
    }

    public function testAListItemMatchingNoBranchRaises(): void
    {
        $this->expectException(UnionBranchException::class);

        $this->client('[{"scales":"green"}]')->listCreatures();
    }

    /**
     * A pin types the response as its single branch directly — there is no
     * union left for the runtime to pick between, and a Fahrenheit-shaped
     * payload hydrates as a Celsius without complaint, the same
     * wrong-looking-right shape a pinned property's own notice warns about.
     */
    public function testAPinnedResponseHydratesAsTheSingleClassItWasTypedAs(): void
    {
        $reading = $this->client('{"degrees":42.0}')->getUndecidableCreature();

        self::assertInstanceOf(Celsius::class, $reading);
        self::assertSame(42.0, $reading->degrees);
    }

    private function client(string $body): ApiClient
    {
        $factory = new Psr17Factory();
        $http = new RecordingClient(new Response(200, ['Content-Type' => 'application/json'], $body));
        $transport = new HttpTransport(
            'https://union-response.example',
            ApiException::class,
            $http,
            $factory,
            $factory,
        );

        return new ApiClient($transport);
    }
}
