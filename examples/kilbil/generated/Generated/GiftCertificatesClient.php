<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated;

use Acme\Kilbil\Generated\Model\GenerateGiftCardRequest;
use Acme\Kilbil\Generated\Model\GenerateGiftCardResponse;
use Acme\Kilbil\Generated\Model\GetProgramGiftCardResponse;
use Acme\Kilbil\Generated\Model\SearchGiftCardRequest;
use Acme\Kilbil\Generated\Model\SearchGiftCardResponse;
use Mlavrinenko\Paogen\Runtime\Marshal\Hydrator;
use Mlavrinenko\Paogen\Runtime\Marshal\Marshaller;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

final readonly class GiftCertificatesClient implements GiftCertificatesClientInterface
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

    public function generateGiftCard(GenerateGiftCardRequest $body): GenerateGiftCardResponse
    {
        $path = '/load/generategiftcard';
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
        return $this->hydrator->hydrate(GenerateGiftCardResponse::class, $data);
    }

    public function getProgramGiftCard(): GetProgramGiftCardResponse
    {
        $path = '/load/getprogramgiftcard';
        $query = [];
        $query[] = 'h=' . \urlencode($this->h);
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
        return $this->hydrator->hydrate(GetProgramGiftCardResponse::class, $data);
    }

    public function searchGiftCard(SearchGiftCardRequest $body): SearchGiftCardResponse
    {
        $path = '/load/searchgiftcard';
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
        return $this->hydrator->hydrate(SearchGiftCardResponse::class, $data);
    }
}
