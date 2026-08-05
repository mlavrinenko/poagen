<?php

declare(strict_types=1);

namespace Poagen\Generator\Tests\Integration;

use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Poagen\Generator\Tests\Fixtures\Generated\UnionResponse\Generated\ApiClient;
use Poagen\Generator\Tests\Fixtures\Generated\UnionResponse\Generated\ApiException;
use Poagen\Generator\Tests\Fixtures\Generated\UnionResponse\Generated\Model\Cat;
use Poagen\Generator\Tests\Fixtures\Generated\UnionResponse\Generated\Model\Celsius;
use Poagen\Generator\Tests\Fixtures\Generated\UnionResponse\Generated\Model\Dog;
use Poagen\Generator\Tests\Fixtures\Generated\UnionResponse\Generated\Model\GetRestrictionsResponseBranch2;
use Poagen\Generator\Tests\Generated\RecordingClient;
use Poagen\Runtime\Contract\ResponseType;
use Poagen\Runtime\Http\HttpTransport;
use Poagen\Runtime\Marshal\UnionBranchException;

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
 *
 * Lives in `tests/Integration/`, not `runtime/tests/`
 * (`bundle-the-runtime-package-with-its-own-ci-tooling`): the whole point of
 * this file, stated in its own first paragraph, is driving the runtime
 * through the *emitted* `union-response` fixture rather than a hand-built
 * `ResponseType` — so it needs the generator's committed golden tree to
 * exist, and cannot run with the generator absent. `runtime/tests/
 * TransportResponseKindsTest.php`'s
 * `testAUnionResponseIsHydratedIntoTheBranchItsPresentFieldNames()` pins the
 * bare `ResponseType::union()` contract this file drives through generated
 * code, so the same mechanics are covered on both sides of the split.
 */
final class ResponseUnionSelectionTest extends TestCase
{
    public function testAPayloadCarryingOnlyOneBranchsFieldSelectsThatBranch(): void
    {
        $dog = $this->client('{"bark":"woof"}')->getCreature()->body;

        self::assertInstanceOf(Dog::class, $dog);
        self::assertSame('woof', $dog->bark);
    }

    public function testTheOtherBranchIsSelectedByItsOwnField(): void
    {
        $cat = $this->client('{"meow":"mrrp"}')->getCreature()->body;

        self::assertInstanceOf(Cat::class, $cat);
        self::assertSame('mrrp', $cat->meow);
    }

    /**
     * A payload matching no branch is a {@see UnionBranchException} the
     * hydrator raises — and, per `typed-error-responses`, a declared body
     * that fails to hydrate is one more case the envelope cannot honestly
     * represent, so the transport catches it and raises the profile's
     * `ApiException` instead, carrying the original message as its reason.
     */
    public function testAPayloadMatchingNeitherBranchRaises(): void
    {
        $this->assertReasonContains(
            'matched none of the union branches',
            fn(): mixed => $this->client('{"scales":"green"}')->getCreature(),
        );
    }

    public function testAPayloadMatchingBothBranchesRaises(): void
    {
        $this->assertReasonContains(
            'matched 2 union branches at once',
            fn(): mixed => $this->client('{"bark":"woof","meow":"mrrp"}')->getCreature(),
        );
    }

    /**
     * Layer one: the document's own `discriminator`, carrying an explicit
     * `mapping` whose wire values (`canine`/`feline`) are not either
     * branch's class name — the reading no property-position union in
     * either vendored corpus has ever exercised, because none declares one.
     */
    public function testADocumentDiscriminatorWithAnExplicitMappingSelectsByItsWireValue(): void
    {
        $dog = $this->client('{"kind":"canine","bark":"woof"}')->getTaggedCreature()->body;

        self::assertInstanceOf(Dog::class, $dog);
    }

    public function testTheMappingsOtherValueSelectsTheOtherBranch(): void
    {
        $cat = $this->client('{"kind":"feline","meow":"mrrp"}')->getTaggedCreature()->body;

        self::assertInstanceOf(Cat::class, $cat);
    }

    public function testATagValueTheMappingDoesNotNameRaises(): void
    {
        $this->assertReasonContains(
            "carries 'reptile', which no branch is mapped to",
            fn(): mixed => $this->client('{"kind":"reptile","scales":"green"}')->getTaggedCreature(),
        );
    }

    /**
     * The closed-shape predicate, mirrored from
     * `interactions/get-restrictions-for-org`'s exact shape: an empty
     * payload selects the branch that declared no properties and closed
     * itself, and a non-empty one never does.
     */
    public function testAnEmptyPayloadSelectsTheClosedBranch(): void
    {
        $result = $this->client('{}')->getRestrictions()->body;

        self::assertInstanceOf(GetRestrictionsResponseBranch2::class, $result);
    }

    public function testANonEmptyPayloadSelectsTheOtherBranchInstead(): void
    {
        $result = $this->client('{"bark":"woof"}')->getRestrictions()->body;

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
        $items = $this->client('[{"bark":"woof"},{"meow":"mrrp"}]')->listCreatures()->body;

        self::assertCount(2, $items);
        self::assertInstanceOf(Dog::class, $items[0]);
        self::assertInstanceOf(Cat::class, $items[1]);
    }

    public function testAnEmptyListRaisesNothingBecauseNoItemNeedsAPick(): void
    {
        self::assertSame([], $this->client('[]')->listCreatures()->body);
    }

    public function testAListItemMatchingNoBranchRaises(): void
    {
        $this->assertReasonContains(
            'matched none of the union branches',
            fn(): mixed => $this->client('[{"scales":"green"}]')->listCreatures(),
        );
    }

    /**
     * A pin types the response as its single branch directly — there is no
     * union left for the runtime to pick between, and a Fahrenheit-shaped
     * payload hydrates as a Celsius without complaint, the same
     * wrong-looking-right shape a pinned property's own notice warns about.
     */
    public function testAPinnedResponseHydratesAsTheSingleClassItWasTypedAs(): void
    {
        $reading = $this->client('{"degrees":42.0}')->getUndecidableCreature()->body;

        self::assertInstanceOf(Celsius::class, $reading);
        self::assertSame(42.0, $reading->degrees);
    }

    private function assertReasonContains(string $needle, callable $call): void
    {
        try {
            $call();
            self::fail('expected ApiException');
        } catch (ApiException $e) {
            self::assertStringContainsString($needle, $e->getReason());
        }
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
