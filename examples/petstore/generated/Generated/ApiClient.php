<?php

declare(strict_types=1);

namespace Acme\Petstore\Generated;

use Acme\Petstore\Generated\Enum\FindPetsByStatusStatus;
use Acme\Petstore\Generated\Model\Order;
use Acme\Petstore\Generated\Model\Pet;
use Acme\Petstore\Generated\Model\User;
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
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
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
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        return self::hydrate(Pet::class, $data);
    }

    /**
     * @return list<\Acme\Petstore\Generated\Model\Pet>
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
            static fn(mixed $item): Pet => self::hydrate(Pet::class, $item),
            $data,
        ));
    }

    /**
     * @param list<string> $tags
     * @return list<\Acme\Petstore\Generated\Model\Pet>
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
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        return self::hydrate(Pet::class, $data);
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
        return self::hydrate(Pet::class, $data);
    }

    public function deletePet(int $petId, ?string $api_key = null): void
    {
        $path = '/pet/{petId}';
        $path = \str_replace('{petId}', (string) $petId, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        if ($api_key !== null) { $request = $request->withHeader('api_key', $api_key); }
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * @psalm-return never
     *
     * TODO(multipart): see task 011 — unsupported body content type
     * Body content-type: application/octet-stream
     */
    public function uploadFile(int $petId, ?string $additionalMetadata = null): never
    {
        throw new \RuntimeException('application/octet-stream not yet supported: operationId \'uploadFile\'');
    }

    /**
     * @return array<string, int>
     */
    public function getInventory(): array
    {
        $path = '/store/inventory';
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var array<string, int> $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        return $data;
    }

    public function placeOrder(Order $body): Order
    {
        $path = '/store/order';
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($body, \JSON_THROW_ON_ERROR)));
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
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
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        return self::hydrate(Order::class, $data);
    }

    public function deleteOrder(int $orderId): void
    {
        $path = '/store/order/{orderId}';
        $path = \str_replace('{orderId}', (string) $orderId, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function createUser(User $body): User
    {
        $path = '/user';
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($body, \JSON_THROW_ON_ERROR)));
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        return self::hydrate(User::class, $data);
    }

    /**
     * @param list<\Acme\Petstore\Generated\Model\User> $body
     */
    public function createUsersWithListInput(array $body): User
    {
        $path = '/user/createWithList';
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($body, \JSON_THROW_ON_ERROR)));
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        return self::hydrate(User::class, $data);
    }

    public function loginUser(?string $username = null, ?string $password = null): string
    {
        $path = '/user/login';
        $query = [];
        if ($username !== null) {
            $query[] = 'username=' . \urlencode($username);
        }
        if ($password !== null) {
            $query[] = 'password=' . \urlencode($password);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        return (string) $response->getBody();
    }

    public function logoutUser(): void
    {
        $path = '/user/logout';
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function getUserByName(string $username): User
    {
        $path = '/user/{username}';
        $path = \str_replace('{username}', $username, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
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
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function deleteUser(string $username): void
    {
        $path = '/user/{username}';
        $path = \str_replace('{username}', $username, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    /**
     * Deserialise a JSON-decoded value into an instance of $class.
     *
     * Uses the Model's `PROPERTY_MAP` const (ADR-007) to translate
     * wire keys into PHP property names and to recurse into nested
     * models / list-of-model items.
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

        /** @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: 'union', 1: list<class-string>, 2: ?string}}> $map */
        $map = $class::PROPERTY_MAP;

        $args = [];

        foreach ($map as $phpName => [$wireKey, $shape]) {
            if (!\array_key_exists($wireKey, $data)) {
                continue;
            }

            $value = $data[$wireKey];

            if ($shape === null) {
                $args[$phpName] = $value;
                continue;
            }

            if (\is_string($shape)) {
                $args[$phpName] = \is_array($value) ? self::hydrate($shape, $value) : $value;
                continue;
            }

            $kind = $shape[0];

            if ($kind === 'union' && \is_array($shape[1])) {
                $args[$phpName] = self::hydrateUnion($shape[1], $shape[2] ?? null, $value);
                continue;
            }

            $itemType = \is_array($shape[1]) ? null : $shape[1];

            if ($kind === 'scalar' && $itemType !== null) {
                if ($value === null || $value instanceof $itemType) {
                    $args[$phpName] = $value;
                    continue;
                }
                $args[$phpName] = $itemType::fromScalar($value);
                continue;
            }

            if ($kind === 'datetime' || $kind === 'date') {
                if ($value === null || $value instanceof \DateTimeImmutable) {
                    $args[$phpName] = $value;
                    continue;
                }
                if (!\is_string($value)) {
                    throw new \RuntimeException(\sprintf(
                        'Expected string for %s::$%s, got %s.',
                        $class,
                        $phpName,
                        \get_debug_type($value),
                    ));
                }
                $args[$phpName] = new \DateTimeImmutable($value);
                continue;
            }

            if ($kind === 'enum' && $itemType !== null) {
                if ($value === null || $value instanceof $itemType) {
                    $args[$phpName] = $value;
                    continue;
                }
                $args[$phpName] = $itemType::from($value);
                continue;
            }

            // ['list', null] or ['list', class-string].
            if (!\is_array($value)) {
                $args[$phpName] = $value;
                continue;
            }

            if ($itemType === null) {
                $args[$phpName] = $value;
                continue;
            }

            $args[$phpName] = \array_values(\array_map(
                static fn(mixed $item): mixed => \is_array($item) ? self::hydrate($itemType, $item) : $item,
                $value,
            ));
        }

        return new $class(...$args);
    }

    /**
     * Pick the right branch of a oneOf/anyOf union.
     *
     * Strategy:
     *   1. If a discriminator property name is given and the payload carries it,
     *      match its wire value against each branch's short class name (the
     *      component name, case-sensitive). First match wins.
     *   2. Otherwise, pick the first branch whose required-key set is a subset of
     *      the payload's keys.
     *   3. Fall back to the first branch.
     *
     * @param list<class-string> $branches
     */
    private static function hydrateUnion(array $branches, ?string $discriminator, mixed $value): mixed
    {
        if (!\is_array($value)) {
            return $value;
        }

        if ($discriminator !== null && \array_key_exists($discriminator, $value)) {
            $tag = $value[$discriminator];

            if (\is_string($tag)) {
                foreach ($branches as $branch) {
                    $short = \substr((string) \strrchr('\\' . $branch, '\\'), 1);

                    if ($short === $tag) {
                        return self::hydrate($branch, $value);
                    }
                }
            }
        }

        $payloadKeys = \array_keys($value);

        foreach ($branches as $branch) {
            /** @var array<string, array{0: string, 1: mixed}> $map */
            $map = $branch::PROPERTY_MAP;
            $wireKeys = [];

            foreach ($map as [$wire]) {
                $wireKeys[] = $wire;
            }

            // Structural match: all payload keys are explained by this branch.
            if (\array_diff($payloadKeys, $wireKeys) === []) {
                return self::hydrate($branch, $value);
            }
        }

        return self::hydrate($branches[0], $value);
    }
}
