<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated;

use Acme\Kilbil\Generated\Model\GeneratePromocodeRequest;
use Acme\Kilbil\Generated\Model\GeneratePromocodeResponse;
use Acme\Kilbil\Generated\Model\ReservedPromocodeRequest;
use Acme\Kilbil\Generated\Model\ReservedPromocodeResponse;
use Acme\Kilbil\Generated\Model\SearchPromocodeRequest;
use Acme\Kilbil\Generated\Model\SearchPromocodeResponse;
use Mlavrinenko\Paogen\Runtime\Marshal\Hydrator;
use Mlavrinenko\Paogen\Runtime\Marshal\Marshaller;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

final readonly class PromocodesClient implements PromocodesClientInterface
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

    public function generatePromocode(GeneratePromocodeRequest $body): GeneratePromocodeResponse
    {
        $path = '/load/generate_promocode';
        $query = [];
        $query[] = 'h=' . \urlencode($this->h);
        $path .= '?' . \implode('&', $query);
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
        return $this->hydrator->hydrate(GeneratePromocodeResponse::class, $data);
    }

    public function reservedPromocode(ReservedPromocodeRequest $body): ReservedPromocodeResponse
    {
        $path = '/load/reservedpromocode';
        $query = [];
        $query[] = 'h=' . \urlencode($this->h);
        $path .= '?' . \implode('&', $query);
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
        return $this->hydrator->hydrate(ReservedPromocodeResponse::class, $data);
    }

    public function searchPromocode(SearchPromocodeRequest $body): SearchPromocodeResponse
    {
        $path = '/load/searchpromocode';
        $query = [];
        $query[] = 'h=' . \urlencode($this->h);
        $path .= '?' . \implode('&', $query);
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
        return $this->hydrator->hydrate(SearchPromocodeResponse::class, $data);
    }
}
