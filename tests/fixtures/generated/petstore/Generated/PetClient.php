<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated;

use Mlavrinenko\Paogen\Runtime\Marshal\Hydrator;
use Mlavrinenko\Paogen\Runtime\Marshal\Marshaller;
use Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated\Enum\FindPetsByStatusStatus;
use Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated\Model\Pet;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

final readonly class PetClient implements PetClientInterface
{
    public function __construct(
        private ClientInterface $httpClient,
        private RequestFactoryInterface $requestFactory,
        private StreamFactoryInterface $streamFactory,
        private string $baseUri,
        private Hydrator $hydrator = new Hydrator(),
        private Marshaller $marshaller = new Marshaller(),
    ) {
    }

    public function updatePet(Pet $body): Pet
    {
        $path = '/pet';
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(Pet::class, $data);
    }

    public function addPet(Pet $body): Pet
    {
        $path = '/pet';
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(Pet::class, $data);
    }

    /**
     * @return list<\Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated\Model\Pet>
     */
    public function findPetsByStatus(FindPetsByStatusStatus $status): array
    {
        $path = '/pet/findByStatus';
        $query = [];
        $query[] = 'status=' . \urlencode($status->value);
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): Pet => $this->hydrator->hydrate(Pet::class, (array) $item),
            $data,
        ));
    }

    /**
     * @param list<string> $tags
     * @return list<\Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated\Model\Pet>
     */
    public function findPetsByTags(array $tags): array
    {
        $path = '/pet/findByTags';
        $query = [];
        foreach ($tags as $__v) { $query[] = 'tags=' . \urlencode($__v); }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): Pet => $this->hydrator->hydrate(Pet::class, (array) $item),
            $data,
        ));
    }

    public function getPetById(int $petId): Pet
    {
        $path = '/pet/{petId}';
        $path = \str_replace('{petId}', (string) $petId, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(Pet::class, $data);
    }

    public function updatePetWithForm(int $petId, ?string $name = null, ?string $status = null): Pet
    {
        $path = '/pet/{petId}';
        $path = \str_replace('{petId}', (string) $petId, $path);
        $query = [];
        if ($name !== null) {
            $query[] = 'name=' . \urlencode($name);
        }
        if ($status !== null) {
            $query[] = 'status=' . \urlencode($status);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(Pet::class, $data);
    }

    public function deletePet(int $petId, ?string $apiKey = null): void
    {
        $path = '/pet/{petId}';
        $path = \str_replace('{petId}', (string) $petId, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        if ($apiKey !== null) { $request = $request->withHeader('api_key', $apiKey); }
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }
}
