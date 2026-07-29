<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated;

use Mlavrinenko\Paogen\Runtime\Marshal\Hydrator;
use Mlavrinenko\Paogen\Runtime\Marshal\Marshaller;
use Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated\Model\Order;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

final readonly class StoreClient implements StoreClientInterface
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
            ->withBody($this->streamFactory->createStream(\json_encode($this->marshaller->marshal($body), \JSON_THROW_ON_ERROR)));
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
        \assert(\is_array($data));
        return $this->hydrator->hydrate(Order::class, $data);
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
}
