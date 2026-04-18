<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated;

use Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated\Model\Order;
use Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated\Model\Pet;
use Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated\Model\User;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

final readonly class ApiClient
{
    public function __construct(
        private ClientInterface $httpClient,
        private RequestFactoryInterface $requestFactory,
        private StreamFactoryInterface $streamFactory,
        private string $baseUri,
    ) {
    }

    public function updatePet(Pet $body): Pet
    {
        $path = '/pet';
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($body, \JSON_THROW_ON_ERROR)));
        $response = $this->httpClient->sendRequest($request);
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        return self::hydrate(Pet::class, $data);
    }

    public function addPet(Pet $body): Pet
    {
        $path = '/pet';
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($body, \JSON_THROW_ON_ERROR)));
        $response = $this->httpClient->sendRequest($request);
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        return self::hydrate(Pet::class, $data);
    }

    /**
     * @return list<\Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated\Model\Pet>
     */
    public function findPetsByStatus(string $status): array
    {
        $path = '/pet/findByStatus';
        $query = [];
        $query['status'] = $status;
        $path .= '?' . \http_build_query($query);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            static fn(mixed $item): Pet => self::hydrate(Pet::class, $item),
            $data,
        ));
    }

    public function getPetById(int $petId): Pet
    {
        $path = '/pet/{petId}';
        $path = \str_replace('{petId}', (string) $petId, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        return self::hydrate(Pet::class, $data);
    }

    public function updatePetWithForm(int $petId, ?string $name = null, ?string $status = null): Pet
    {
        $path = '/pet/{petId}';
        $path = \str_replace('{petId}', (string) $petId, $path);
        $query = [];
        if ($name !== null) { $query['name'] = $name; }
        if ($status !== null) { $query['status'] = $status; }
        if ($query !== []) { $path .= '?' . \http_build_query($query); }
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        return self::hydrate(Pet::class, $data);
    }

    public function deletePet(int $petId): void
    {
        $path = '/pet/{petId}';
        $path = \str_replace('{petId}', (string) $petId, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $this->httpClient->sendRequest($request);
    }

    public function getInventory(): void
    {
        $path = '/store/inventory';
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $this->httpClient->sendRequest($request);
    }

    public function placeOrder(Order $body): Order
    {
        $path = '/store/order';
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($body, \JSON_THROW_ON_ERROR)));
        $response = $this->httpClient->sendRequest($request);
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        return self::hydrate(Order::class, $data);
    }

    public function getOrderById(int $orderId): Order
    {
        $path = '/store/order/{orderId}';
        $path = \str_replace('{orderId}', (string) $orderId, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        return self::hydrate(Order::class, $data);
    }

    public function deleteOrder(int $orderId): void
    {
        $path = '/store/order/{orderId}';
        $path = \str_replace('{orderId}', (string) $orderId, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $this->httpClient->sendRequest($request);
    }

    public function createUser(User $body): User
    {
        $path = '/user';
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($body, \JSON_THROW_ON_ERROR)));
        $response = $this->httpClient->sendRequest($request);
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        return self::hydrate(User::class, $data);
    }

    public function loginUser(?string $username = null, ?string $password = null): void
    {
        $path = '/user/login';
        $query = [];
        if ($username !== null) { $query['username'] = $username; }
        if ($password !== null) { $query['password'] = $password; }
        if ($query !== []) { $path .= '?' . \http_build_query($query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $this->httpClient->sendRequest($request);
    }

    public function logoutUser(): void
    {
        $path = '/user/logout';
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $this->httpClient->sendRequest($request);
    }

    public function getUserByName(string $username): User
    {
        $path = '/user/{username}';
        $path = \str_replace('{username}', $username, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        return self::hydrate(User::class, $data);
    }

    public function updateUser(string $username, User $body): void
    {
        $path = '/user/{username}';
        $path = \str_replace('{username}', $username, $path);
        $request = $this->requestFactory->createRequest('PUT', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($body, \JSON_THROW_ON_ERROR)));
        $this->httpClient->sendRequest($request);
    }

    public function deleteUser(string $username): void
    {
        $path = '/user/{username}';
        $path = \str_replace('{username}', $username, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $this->httpClient->sendRequest($request);
    }

    /**
     * Deserialise a JSON-decoded value into an instance of $class.
     *
     * @template T of object
     * @param class-string<T> $class
     * @return T
     */
    private static function hydrate(string $class, mixed $data): object
    {
        if (!\is_array($data)) {
            throw new \RuntimeException(\sprintf('Cannot hydrate %s from non-array data.', $class));
        }

        $reflection = new \ReflectionClass($class);
        $constructor = $reflection->getConstructor();

        if ($constructor === null) {
            /** @var T */
            return $reflection->newInstance();
        }

        $args = [];

        foreach ($constructor->getParameters() as $parameter) {
            $name = $parameter->getName();

            if (!\array_key_exists($name, $data)) {
                if ($parameter->isDefaultValueAvailable()) {
                    $args[$name] = $parameter->getDefaultValue();
                }
                continue;
            }

            $value = $data[$name];
            $type = $parameter->getType();

            if ($type instanceof \ReflectionNamedType && !$type->isBuiltin() && \is_array($value)) {
                /** @var class-string $child */
                $child = $type->getName();
                $value = self::hydrate($child, $value);
            }

            $args[$name] = $value;
        }

        /** @var T */
        return $reflection->newInstanceArgs($args);
    }
}
