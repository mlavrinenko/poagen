<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated;

use Acme\Kilbil\Generated\Model\GoodsListRequestItem;
use Acme\Kilbil\Generated\Model\GoodsListResponse;
use Acme\Kilbil\Generated\Model\GoodsListXmlRequestItem;
use Acme\Kilbil\Generated\Model\GoodsListXmlResponse;
use Acme\Kilbil\Generated\Model\GoodsRequestItem;
use Acme\Kilbil\Generated\Model\GoodsResponse;
use Acme\Kilbil\Generated\Model\GoodsXmlRequestItem;
use Acme\Kilbil\Generated\Model\GoodsXmlResponse;
use Mlavrinenko\Paogen\Runtime\Marshal\Hydrator;
use Mlavrinenko\Paogen\Runtime\Marshal\Marshaller;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

final readonly class CatalogueClient implements CatalogueClientInterface
{
    public function __construct(
        private ClientInterface $httpClient,
        private RequestFactoryInterface $requestFactory,
        private StreamFactoryInterface $streamFactory,
        private string $baseUri,
        private string $h,
        private Hydrator $hydrator = new Hydrator(),
        private Marshaller $marshaller = new Marshaller(),
    ) {
    }

    /**
     * @param list<\Acme\Kilbil\Generated\Model\GoodsRequestItem> $body
     */
    public function goods(array $body, ?int $partial = null, ?int $id = null): GoodsResponse
    {
        $path = '/load/goods';
        $query = [];
        if ($partial !== null) {
            $query[] = 'partial=' . \urlencode((string) $partial);
        }
        if ($id !== null) {
            $query[] = 'id=' . \urlencode((string) $id);
        }
        $query[] = 'h=' . \urlencode($this->h);
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode(\array_map(fn(object $__m): array => $this->marshaller->marshal($__m), $body), \JSON_THROW_ON_ERROR)));
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(GoodsResponse::class, $data);
    }

    /**
     * @param list<\Acme\Kilbil\Generated\Model\GoodsListRequestItem> $body
     */
    public function goodsList(array $body, ?int $id = null): GoodsListResponse
    {
        $path = '/load/goodslist';
        $query = [];
        if ($id !== null) {
            $query[] = 'id=' . \urlencode((string) $id);
        }
        $query[] = 'h=' . \urlencode($this->h);
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(\json_encode(\array_map(fn(object $__m): array => $this->marshaller->marshal($__m), $body), \JSON_THROW_ON_ERROR)));
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(GoodsListResponse::class, $data);
    }

    /**
     * @param list<\Acme\Kilbil\Generated\Model\GoodsListXmlRequestItem> $body
     */
    public function goodsListXml(array $body, ?int $id = null): GoodsListXmlResponse
    {
        $path = '/load/goodslistxml';
        $query = [];
        if ($id !== null) {
            $query[] = 'id=' . \urlencode((string) $id);
        }
        $query[] = 'h=' . \urlencode($this->h);
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/xml')
            ->withBody($this->streamFactory->createStream(\Mlavrinenko\Paogen\Runtime\Marshal\XmlWriter::renderList(\array_map(fn(object $__m): array => $this->marshaller->marshal($__m), $body), 'goodslist', 'good')));
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(GoodsListXmlResponse::class, $data);
    }

    /**
     * @param list<\Acme\Kilbil\Generated\Model\GoodsXmlRequestItem> $body
     */
    public function goodsXml(array $body, ?int $partial = null, ?int $id = null): GoodsXmlResponse
    {
        $path = '/load/goodsxml';
        $query = [];
        if ($partial !== null) {
            $query[] = 'partial=' . \urlencode((string) $partial);
        }
        if ($id !== null) {
            $query[] = 'id=' . \urlencode((string) $id);
        }
        $query[] = 'h=' . \urlencode($this->h);
        $path .= '?' . \implode('&', $query);
        $request = $this->requestFactory->createRequest('POST', \rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/xml')
            ->withBody($this->streamFactory->createStream(\Mlavrinenko\Paogen\Runtime\Marshal\XmlWriter::renderList(\array_map(fn(object $__m): array => $this->marshaller->marshal($__m), $body), 'goods', 'good')));
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = \json_decode((string) $response->getBody(), true, 512, \JSON_THROW_ON_ERROR);
        \assert(\is_array($data));
        return $this->hydrator->hydrate(GoodsXmlResponse::class, $data);
    }
}
