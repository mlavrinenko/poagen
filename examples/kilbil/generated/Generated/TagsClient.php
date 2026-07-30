<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated;

use Acme\Kilbil\Generated\Model\AddClientTagsRequest;
use Acme\Kilbil\Generated\Model\AddClientTagsResponse;
use Acme\Kilbil\Generated\Model\DeleteClientTagsRequest;
use Acme\Kilbil\Generated\Model\DeleteClientTagsResponse;
use Acme\Kilbil\Generated\Model\GetClientTagsRequest;
use Acme\Kilbil\Generated\Model\GetClientTagsResponse;
use Acme\Kilbil\Generated\Model\GetListTagsRequest;
use Acme\Kilbil\Generated\Model\GetListTagsResponse;
use Mlavrinenko\Paogen\Runtime\Marshal\Hydrator;
use Mlavrinenko\Paogen\Runtime\Marshal\Marshaller;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

use function assert;
use function implode;
use function is_array;
use function json_decode;
use function json_encode;
use function rtrim;
use function urlencode;

use const JSON_THROW_ON_ERROR;

final readonly class TagsClient implements TagsClientInterface
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

    public function addClientTags(AddClientTagsRequest $body): AddClientTagsResponse
    {
        $path = '/load/addclienttags';
        $query = [];
        $query[] = 'h=' . urlencode($this->h);
        $path .= '?' . implode('&', $query);
        $request = $this->requestFactory->createRequest('POST', rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(json_encode($this->marshaller->marshal($body), JSON_THROW_ON_ERROR)));
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = json_decode((string) $response->getBody(), true, 512, JSON_THROW_ON_ERROR);
        assert(is_array($data));
        return $this->hydrator->hydrate(AddClientTagsResponse::class, $data);
    }

    public function deleteClientTags(DeleteClientTagsRequest $body): DeleteClientTagsResponse
    {
        $path = '/load/deleteclienttags';
        $query = [];
        $query[] = 'h=' . urlencode($this->h);
        $path .= '?' . implode('&', $query);
        $request = $this->requestFactory->createRequest('POST', rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(json_encode($this->marshaller->marshal($body), JSON_THROW_ON_ERROR)));
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = json_decode((string) $response->getBody(), true, 512, JSON_THROW_ON_ERROR);
        assert(is_array($data));
        return $this->hydrator->hydrate(DeleteClientTagsResponse::class, $data);
    }

    public function getClientTags(GetClientTagsRequest $body): GetClientTagsResponse
    {
        $path = '/load/getclienttags';
        $query = [];
        $query[] = 'h=' . urlencode($this->h);
        $path .= '?' . implode('&', $query);
        $request = $this->requestFactory->createRequest('POST', rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(json_encode($this->marshaller->marshal($body), JSON_THROW_ON_ERROR)));
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = json_decode((string) $response->getBody(), true, 512, JSON_THROW_ON_ERROR);
        assert(is_array($data));
        return $this->hydrator->hydrate(GetClientTagsResponse::class, $data);
    }

    public function getListTags(GetListTagsRequest $body): GetListTagsResponse
    {
        $path = '/load/getlisttags';
        $query = [];
        $query[] = 'h=' . urlencode($this->h);
        $path .= '?' . implode('&', $query);
        $request = $this->requestFactory->createRequest('POST', rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(json_encode($this->marshaller->marshal($body), JSON_THROW_ON_ERROR)));
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = json_decode((string) $response->getBody(), true, 512, JSON_THROW_ON_ERROR);
        assert(is_array($data));
        return $this->hydrator->hydrate(GetListTagsResponse::class, $data);
    }
}
