<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Fixtures\Generated\Parameters\Generated;

use Mlavrinenko\Paogen\Tests\Fixtures\Generated\Parameters\Generated\Model\Order;
use Mlavrinenko\Paogen\Tests\Fixtures\Generated\Parameters\Generated\Model\Pet;
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

    /**
     * @return list<\Mlavrinenko\Paogen\Tests\Fixtures\Generated\Parameters\Generated\Model\Order>
     */
    public function listOrders(?int $limit = null, ?string $api_key = null): array
    {
        $path = '/order';
        $query = [];
        if ($limit !== null) {
            $query[] = 'limit=' . \urlencode((string) $limit);
        }
        if ($query !== []) { $path .= '?' . \implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        if ($api_key !== null) { $request = $request->withHeader('api_key', $api_key); }
        $response = $this->httpClient->sendRequest($request);
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            static fn(mixed $item): Order => self::hydrate(Order::class, $item),
            $data,
        ));
    }

    public function placeOrder(Order $body): Order
    {
        $path = '/order';
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($body, \JSON_THROW_ON_ERROR)));
        $response = $this->httpClient->sendRequest($request);
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        return self::hydrate(Order::class, $data);
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

    /**
     * @return list<\Mlavrinenko\Paogen\Tests\Fixtures\Generated\Parameters\Generated\Model\Order>
     */
    public function listStoreItems(int $storeId): array
    {
        $path = '/store/{storeId}/items';
        $path = \str_replace('{storeId}', (string) $storeId, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            static fn(mixed $item): Order => self::hydrate(Order::class, $item),
            $data,
        ));
    }

    public function clearStore(int $storeId): void
    {
        $path = '/store/{storeId}/items';
        $path = \str_replace('{storeId}', (string) $storeId, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $this->httpClient->sendRequest($request);
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

        /** @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}}> $map */
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

            [$kind, $itemType] = $shape;

            if ($kind === 'scalar' && $itemType !== null) {
                if ($value === null || $value instanceof $itemType) {
                    $args[$phpName] = $value;
                    continue;
                }
                $args[$phpName] = $itemType::fromScalar($value);
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
}
