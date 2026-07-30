<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Integration;

use Mlavrinenko\Paogen\Runtime\Contract\Endpoint;
use Mlavrinenko\Paogen\Runtime\Contract\ResponseType;
use Mlavrinenko\Paogen\Runtime\Contract\TransportInterface;
use Mlavrinenko\Paogen\Runtime\Http\HttpTransport;
use Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated\ApiClient;
use Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated\ApiException;
use Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated\Model\Pet;
use Mlavrinenko\Paogen\Tests\Generated\RecordingClient;
use Mlavrinenko\Paogen\Tests\Support\RecordingRuntime;
use Mlavrinenko\Paogen\Tests\Support\RecordingTransport;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7\Response;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

use function in_array;

/**
 * swappable-runtime-contracts: every runtime collaborator a generated file
 * names is an interface, and a consumer can replace all of them from their
 * own configuration without editing a generated file.
 *
 * The committed petstore fixture is the subject rather than a freshly
 * generated tree, because the claim is about what a consumer holds after
 * regeneration: an ordinary emitted client, wired by hand.
 */
final class RuntimeSubstitutionTest extends TestCase
{
    public function testAConsumerReplacesTheWholeTransportAndTheGeneratedClientNeverNotices(): void
    {
        $pet = new Pet(name: 'Rex', photoUrls: []);
        $transport = new RecordingTransport([$pet]);

        $returned = new ApiClient($transport)->pet()->getPetById(42);

        // The substitute was called, and what it returned is what the caller
        // got — no generated file was edited to make that true.
        self::assertSame($pet, $returned);
        self::assertCount(1, $transport->sent);

        $endpoint = $transport->lastEndpoint();
        self::assertInstanceOf(Endpoint::class, $endpoint);
        self::assertSame('GET', $endpoint->httpMethod());
        self::assertSame('/pet/{petId}', $endpoint->route());
        self::assertSame('/pet/42', $endpoint->uri());
    }

    public function testASubstituteSatisfiesTheContractOnItsOwnTermsNotJustTheClientS(): void
    {
        $pet = new Pet(name: 'Rex', photoUrls: []);

        // Typed as the contract, called as the contract: what a consumer's
        // own code sees when it holds a transport it wired itself.
        $returned = $this->sendThrough(
            new RecordingTransport([$pet]),
            Endpoint::get('/pet/{petId}')->path('petId', 42),
        );

        self::assertSame($pet, $returned);
    }

    private function sendThrough(TransportInterface $transport, Endpoint $endpoint): Pet
    {
        return $transport->send($endpoint, ResponseType::object(Pet::class));
    }

    public function testTheEmittedTypeHintIsTheInterfaceRatherThanAnImplementation(): void
    {
        $parameter = new ReflectionClass(ApiClient::class)->getConstructor()?->getParameters()[0] ?? null;

        self::assertNotNull($parameter);
        self::assertSame('transport', $parameter->getName());
        self::assertSame(TransportInterface::class, (string) $parameter->getType());
        // Nothing is constructed internally where a consumer might have
        // wanted to supply it, so there is no implementation to be stuck with.
        self::assertFalse($parameter->isDefaultValueAvailable());
    }

    public function testAConsumerReplacesEveryMarshallingImplementationUnderTheDefaultTransport(): void
    {
        $runtime = new RecordingRuntime();
        $http = new RecordingClient(
            new Response(200, ['Content-Type' => 'application/json'], '{"name":"Rex","photoUrls":[]}'),
        );
        $factory = new Psr17Factory();

        $client = new ApiClient(new HttpTransport(
            'https://petstore.example/api/v3',
            ApiException::class,
            $http,
            $factory,
            $factory,
            marshaller: $runtime,
            hydrator: $runtime,
            xmlWriter: $runtime,
            descriptors: $runtime,
        ));

        $client->pet()->addPet(new Pet(name: 'Rex', photoUrls: []));

        // Request and response both went through the consumer's own object.
        self::assertTrue(in_array('marshal', $runtime->calls, true));
        self::assertTrue(in_array('hydrate', $runtime->calls, true));
        self::assertTrue(in_array('descriptorsFor', $runtime->calls, true));
        self::assertNotNull($http->lastRequest);
        self::assertSame(
            '{"name":"Rex","photoUrls":[],"category":null,"id":null,"shipping":null,"status":null,"tags":null}',
            (string) $http->lastRequest->getBody(),
        );
    }

    public function testAConsumerWhoReplacesNothingWiresNothingBeyondTheAddressAndTheErrorType(): void
    {
        // Two facts only the consumer can supply: where the API lives, and
        // which exception this profile throws. Everything else — the PSR
        // factories, the hydrator, the marshaller, the XML writer, the
        // descriptor parser — defaults to a working implementation.
        $transport = new HttpTransport('https://petstore.example/api/v3', ApiException::class);
        $client = new ApiClient($transport);

        self::assertInstanceOf(TransportInterface::class, $transport);
        // A PSR-18 client is discovered on first send, not in the
        // constructor, so wiring in a container never fails for an
        // application that has not made a call yet.
        self::assertInstanceOf(ApiClient::class, $client);
    }
}
