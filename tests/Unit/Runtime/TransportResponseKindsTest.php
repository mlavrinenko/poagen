<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Unit\Runtime;

use Mlavrinenko\Paogen\Runtime\Contract\ApiErrorInterface;
use Mlavrinenko\Paogen\Runtime\Contract\Endpoint;
use Mlavrinenko\Paogen\Runtime\Contract\ResponseType;
use Mlavrinenko\Paogen\Runtime\Http\HttpTransport;
use Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated\ApiException;
use Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated\Model\Pet;
use Mlavrinenko\Paogen\Tests\Generated\RecordingClient;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7\Response;
use PHPUnit\Framework\TestCase;

/**
 * The five shapes a schema produces, decoded by the runtime rather than by
 * thirty-six copies of the same emitted branch.
 *
 * The failure case is here too: ADR-009 says a non-2xx response throws the
 * profile's own `ApiException` carrying the original request and response,
 * and moving the status branch into the transport must not change that.
 */
final class TransportResponseKindsTest extends TestCase
{
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

    public function testANon2xxThrowsTheProfilesApiExceptionCarryingRequestAndResponse(): void
    {
        $http = new RecordingClient(
            new Response(404, ['Content-Type' => 'application/json'], '{"message":"not found"}'),
        );
        $transport = $this->transport(null, $http);

        try {
            $transport->send(Endpoint::get('/pet/999'), ResponseType::object(Pet::class));
            self::fail('expected ApiException');
        } catch (ApiException $e) {
            self::assertSame(404, $e->getStatusCode());
            self::assertSame(['message' => 'not found'], $e->getDecodedBody());
            self::assertSame($http->lastRequest, $e->getRequest());
            self::assertSame(404, $e->getResponse()->getStatusCode());
            self::assertSame(
                'https://petstore.example/api/v3/pet/999',
                (string) $e->getRequest()->getUri(),
            );
        }
    }

    public function testTheFailureIsAlsoCatchableThroughTheRuntimeContract(): void
    {
        $http = new RecordingClient(
            new Response(429, ['Content-Type' => 'application/json'], '{"message":"slow down"}'),
        );

        try {
            $this->transport(null, $http)->send(Endpoint::get('/pet/1'), ResponseType::nothing());
            self::fail('expected an API error');
        } catch (ApiErrorInterface $e) {
            // One handler covers every paogen client in a project, without
            // naming any one profile's generated class.
            self::assertSame(429, $e->getStatusCode());
            self::assertSame(['message' => 'slow down'], $e->getDecodedBody());
            self::assertSame($http->lastRequest, $e->getRequest());
            self::assertSame(429, $e->getResponse()->getStatusCode());
        }
    }

    private function transport(?Response $response, ?RecordingClient $http = null): HttpTransport
    {
        $factory = new Psr17Factory();
        $http ??= new RecordingClient($response ?? new Response(204, [], ''));

        return new HttpTransport(
            'https://petstore.example/api/v3',
            ApiException::class,
            $http,
            $factory,
            $factory,
        );
    }
}
