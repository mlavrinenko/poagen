<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Unit\Runtime;

use DateTimeImmutable;
use Mlavrinenko\Paogen\Runtime\Attribute\BranchSelector;
use Mlavrinenko\Paogen\Runtime\Contract\Endpoint;
use Mlavrinenko\Paogen\Runtime\Contract\ResponseType;
use Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated\Model\Pet;
use Mlavrinenko\Paogen\Tests\Fixtures\Generated\UnionResponse\Generated\Model\Cat;
use Mlavrinenko\Paogen\Tests\Fixtures\Generated\UnionResponse\Generated\Model\Dog;
use Mlavrinenko\Paogen\Tests\Fixtures\ValueObject\Email;
use Mlavrinenko\Paogen\Tests\Support\PetstoreHttpTransport;
use Nyholm\Psr7\Response;
use PHPUnit\Framework\TestCase;

/**
 * The five shapes a schema produces, decoded by the runtime rather than by
 * thirty-six copies of the same emitted branch. `KIND_ENVELOPE` is
 * {@see EnvelopeTransportTest}'s own file, split out to keep both under the
 * linecop limit (`quality-gates-at-maximum-strictness`) — the two share
 * {@see PetstoreHttpTransport} rather than each keeping its own copy of the
 * transport builder.
 */
final class TransportResponseKindsTest extends TestCase
{
    use PetstoreHttpTransport;

    public function testNothingReadsNoBodyAtAll(): void
    {
        $transport = $this->transport(new Response(204, [], ''));

        self::assertNull($transport->send(Endpoint::delete('/pet/1'), ResponseType::nothing()));
    }

    public function testAnObjectIsHydratedIntoTheNamedModel(): void
    {
        $transport = $this->transport(
            new Response(200, ['Content-Type' => 'application/json'], '{"name":"Rex","photoUrls":["a"],"id":7}'),
        );

        $pet = $transport->send(Endpoint::get('/pet/7'), ResponseType::object(Pet::class));

        self::assertSame('Rex', $pet->name);
        self::assertSame(7, $pet->id);
        self::assertSame(['a'], $pet->photoUrls);
    }

    public function testAListHydratesEveryItemAndKeepsListKeys(): void
    {
        $transport = $this->transport(new Response(
            200,
            ['Content-Type' => 'application/json'],
            '[{"name":"Rex","photoUrls":[]},{"name":"Mia","photoUrls":[]}]',
        ));

        $pets = $transport->send(Endpoint::get('/pet/findByStatus'), ResponseType::listOf(Pet::class));

        self::assertCount(2, $pets);
        self::assertSame('Rex', $pets[0]->name);
        self::assertSame('Mia', $pets[1]->name);
    }

    public function testAScalarIsReadOffTheBodyWithoutDecoding(): void
    {
        self::assertSame(
            'session-token',
            $this->transport(new Response(200, [], 'session-token'))
                ->send(Endpoint::get('/user/login'), ResponseType::string()),
        );
        self::assertSame(
            42,
            $this->transport(new Response(200, [], '42'))
                ->send(Endpoint::get('/count'), ResponseType::int()),
        );
        self::assertSame(
            1.5,
            $this->transport(new Response(200, [], '1.5'))
                ->send(Endpoint::get('/ratio'), ResponseType::float()),
        );
        self::assertTrue(
            $this->transport(new Response(200, [], '1'))
                ->send(Endpoint::get('/flag'), ResponseType::bool()),
        );
    }

    public function testAMapIsDecodedAndHandedBackWithoutHydration(): void
    {
        $transport = $this->transport(
            new Response(200, ['Content-Type' => 'application/json'], '{"available":7,"sold":2}'),
        );

        self::assertSame(
            ['available' => 7, 'sold' => 2],
            $transport->send(Endpoint::get('/store/inventory'), ResponseType::mapOf(ResponseType::int())),
        );
    }

    public function testAnUnconstrainedObjectComesBackAsTheDecodedBody(): void
    {
        $transport = $this->transport(
            new Response(200, ['Content-Type' => 'application/json'], '{"anything":[1,2]}'),
        );

        self::assertSame(
            ['anything' => [1, 2]],
            $transport->send(Endpoint::get('/opaque'), ResponseType::mapOf(ResponseType::mixed())),
        );
    }

    public function testAScalarListIsDecodedWithoutHydratingAnything(): void
    {
        $transport = $this->transport(
            new Response(200, ['Content-Type' => 'application/json'], '["Actionscript","Ada","Agda"]'),
        );

        $templates = $transport->send(
            Endpoint::get('/gitignore/templates'),
            ResponseType::scalarListOf(ResponseType::string()),
        );

        // A list of strings, keyed 0..n. No model class was named and none
        // was needed — that is the whole shape the document declared.
        self::assertSame(['Actionscript', 'Ada', 'Agda'], $templates);
    }

    public function testADateFormattedListItemArrivesAsADateNotAString(): void
    {
        $transport = $this->transport(
            new Response(200, ['Content-Type' => 'application/json'], '["2022-11-28","2022-08-09"]'),
        );

        $versions = $transport->send(
            Endpoint::get('/versions'),
            ResponseType::scalarListOf(ResponseType::dateTime()),
        );

        self::assertCount(2, $versions);
        self::assertInstanceOf(DateTimeImmutable::class, $versions[0]);
        self::assertSame('2022-11-28', $versions[0]->format('Y-m-d'));
        self::assertSame('2022-08-09', $versions[1]->format('Y-m-d'));
    }

    public function testAListItemBoundToAValueObjectRoundTripsThroughFromScalar(): void
    {
        $transport = $this->transport(
            new Response(200, ['Content-Type' => 'application/json'], '["a@example.test","b@example.test"]'),
        );

        $emails = $transport->send(
            Endpoint::get('/emails'),
            ResponseType::scalarListOf(ResponseType::binding(Email::class)),
        );

        self::assertCount(2, $emails);
        self::assertInstanceOf(Email::class, $emails[0]);
        self::assertSame('a@example.test', $emails[0]->value);
    }

    /**
     * `ResponseType::union()` directly, sixth of the shapes this class
     * proves and the one `a-union-response-selects-its-branch` added.
     * {@see ResponseUnionSelectionTest}
     * drives the same runtime through the emitted `union-response` fixture;
     * this pins the bare {@see ResponseType} contract on its own, the way
     * every other kind above already is.
     */
    public function testAUnionResponseIsHydratedIntoTheBranchItsPresentFieldNames(): void
    {
        $transport = $this->transport(
            new Response(200, ['Content-Type' => 'application/json'], '{"bark":"woof"}'),
        );

        $dog = $transport->send(
            Endpoint::get('/creatures'),
            ResponseType::union(null, new BranchSelector(['bark' => Dog::class, 'meow' => Cat::class]), 'creature'),
        );

        self::assertInstanceOf(Dog::class, $dog);
        self::assertSame('woof', $dog->bark);
    }
}
