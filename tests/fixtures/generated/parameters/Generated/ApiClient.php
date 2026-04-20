<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Fixtures\Generated\Parameters\Generated;

use Mlavrinenko\Paogen\Runtime\Marshal\Hydrator;
use Mlavrinenko\Paogen\Runtime\Marshal\Marshaller;
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
        private string $apiKey,
        private string $bearerToken,
        private Hydrator $hydrator = new Hydrator(),
        private Marshaller $marshaller = new Marshaller(),
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
        $request = $request->withHeader('X-API-Key', $this->apiKey);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): Order => $this->hydrator->hydrate(Order::class, (array) $item),
            $data,
        ));
    }

    public function placeOrder(Order $body): Order
    {
        $path = '/order';
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
        $request = $request->withHeader('Authorization', 'Bearer ' . $this->bearerToken);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(Order::class, $data);
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

    /**
     * @return list<\Mlavrinenko\Paogen\Tests\Fixtures\Generated\Parameters\Generated\Model\Order>
     */
    public function listStoreItems(int $storeId): array
    {
        $path = '/store/{storeId}/items';
        $path = \str_replace('{storeId}', (string) $storeId, $path);
        $request = $this->requestFactory->createRequest('GET', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('X-API-Key', $this->apiKey);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return \array_values(\array_map(
            fn(mixed $item): Order => $this->hydrator->hydrate(Order::class, (array) $item),
            $data,
        ));
    }

    public function clearStore(int $storeId): void
    {
        $path = '/store/{storeId}/items';
        $path = \str_replace('{storeId}', (string) $storeId, $path);
        $request = $this->requestFactory->createRequest('DELETE', \rtrim($this->baseUri, '/') . $path);
        $request = $request->withHeader('X-API-Key', $this->apiKey);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function issueToken(string $grantType, string $clientId, ?string $scope = null): void
    {
        $path = '/token';
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $__form = [];
        $__form['grantType'] = $grantType;
        $__form['clientId'] = $clientId;
        if ($scope !== null) { $__form['scope'] = $scope; }
        $request = $request
            ->withHeader('Content-Type', 'application/x-www-form-urlencoded')
            ->withBody($this->streamFactory->createStream(\http_build_query($__form, '', '&', \PHP_QUERY_RFC1738)));
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }
}
