<?php

declare(strict_types=1);

namespace Poagen\Generator\Tests\Integration;

use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Poagen\Generator\Tests\Fixtures\Generated\Petstore\Generated\ApiClient;
use Poagen\Generator\Tests\Fixtures\Generated\Petstore\Generated\ApiException;
use Poagen\Generator\Tests\Fixtures\Generated\Petstore\Generated\Model\Pet;
use Poagen\Generator\Tests\Fixtures\Generated\Petstore\Generated\Model\Tag;
use Poagen\Generator\Tests\Generated\RecordingClient;
use Poagen\Generator\Tests\Support\RecordingRuntime;
use Poagen\Generator\Tests\Support\RecordingTransport;
use Poagen\Runtime\Contract\Endpoint;
use Poagen\Runtime\Contract\Envelope;
use Poagen\Runtime\Contract\ResponseType;
use Poagen\Runtime\Contract\TransportInterface;
use Poagen\Runtime\Http\HttpTransport;
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
        $envelope = new Envelope(200, $pet, new Response(200));
        $transport = new RecordingTransport([$envelope]);

        // Petstore requires `api_key` and `petstore_auth` on this operation,
        // so the emitted constructor takes both credentials after the
        // transport. Neither reaches a substitute transport, which never
        // builds a request — that is the point of substituting it.
        $returned = new ApiClient($transport, 'unused-api-key', 'unused-access-token')->pet()->getPetById(42);

        // The substitute was called, and what it returned is what the caller
        // got — no generated file was edited to make that true.
        self::assertSame($envelope, $returned);
        self::assertSame($pet, $returned->body);
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
        ), 'unused-api-key', 'unused-access-token');

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

    /**
     * thread-the-validated-nested-container-map-into-the-generated-client:
     * `Endpoint::xmlList()`'s nested-container binding is passed straight
     * through to whichever `XmlWriterInterface` the transport holds, rather
     * than a stock writer being quietly swapped in for exactly the calls
     * that carry one. The substitute here owns a plain `XmlWriter`
     * internally, so a wrapped `<tags>` in the wire output is only possible
     * if the binding reached the substitute's own `renderList()` call.
     */
    public function testASubstituteXmlWriterRendersAnOperationCarryingANestedContainerBinding(): void
    {
        $runtime = new RecordingRuntime();
        $http = new RecordingClient(new Response(204, [], ''));
        $factory = new Psr17Factory();

        $transport = new HttpTransport(
            'https://petstore.example/api/v3',
            ApiException::class,
            $http,
            $factory,
            $factory,
            xmlWriter: $runtime,
        );

        $pet = new Pet(name: 'Rex', photoUrls: [], tags: [new Tag(id: 1, name: 'a'), new Tag(id: 2, name: 'b')]);
        $transport->send(
            Endpoint::post('/pets')->xmlList([$pet], 'pets', 'pet', ['tags' => 'tag']),
            ResponseType::nothing(),
        );

        // The substitute was the thing that rendered — nothing swapped it
        // out for a stock writer on this call.
        self::assertTrue(in_array('renderList', $runtime->calls, true));

        $body = (string) $http->lastRequest?->getBody();
        self::assertStringContainsString('<tags>', $body);
        self::assertStringContainsString('<tag>', $body);
    }

    public function testAConsumerWhoReplacesNothingWiresNothingBeyondTheAddressAndTheErrorType(): void
    {
        // Two facts only the consumer can supply about the transport: where
        // the API lives, and which exception this profile throws. Everything
        // else — the PSR factories, the hydrator, the marshaller, the XML
        // writer, the descriptor parser — defaults to a working
        // implementation. The credentials beside it are the third kind of
        // fact only the consumer has, and the document names each one.
        $transport = new HttpTransport('https://petstore.example/api/v3', ApiException::class);
        $client = new ApiClient($transport, 'unused-api-key', 'unused-access-token');

        self::assertInstanceOf(TransportInterface::class, $transport);
        // A PSR-18 client is discovered on first send, not in the
        // constructor, so wiring in a container never fails for an
        // application that has not made a call yet.
        self::assertInstanceOf(ApiClient::class, $client);
    }
}
