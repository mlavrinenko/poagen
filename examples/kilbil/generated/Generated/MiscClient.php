<?php

declare(strict_types=1);

namespace Acme\Kilbil\Generated;

use Acme\Kilbil\Generated\Model\CloseSessionRequest;
use Acme\Kilbil\Generated\Model\CloseSessionResponse;
use Acme\Kilbil\Generated\Model\ExchangePosSettingsRequest;
use Acme\Kilbil\Generated\Model\ExchangePosSettingsResponse;
use Acme\Kilbil\Generated\Model\GenerateCardRequest;
use Acme\Kilbil\Generated\Model\GenerateCardResponse;
use Acme\Kilbil\Generated\Model\LegalInfoResponse;
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

final readonly class MiscClient implements MiscClientInterface
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

    public function closeSession(CloseSessionRequest $body): CloseSessionResponse
    {
        $path = '/load/closesession';
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
        return $this->hydrator->hydrate(CloseSessionResponse::class, $data);
    }

    public function exchangePosSettings(ExchangePosSettingsRequest $body): ExchangePosSettingsResponse
    {
        $path = '/load/exchangepossettings';
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
        return $this->hydrator->hydrate(ExchangePosSettingsResponse::class, $data);
    }

    public function generateCard(GenerateCardRequest $body): GenerateCardResponse
    {
        $path = '/load/generatecard';
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
        return $this->hydrator->hydrate(GenerateCardResponse::class, $data);
    }

    public function legalInfo(): LegalInfoResponse
    {
        $path = '/load/legal_info';
        $query = [];
        $query[] = 'h=' . urlencode($this->h);
        $path .= '?' . implode('&', $query);
        $request = $this->requestFactory->createRequest('GET', rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = json_decode((string) $response->getBody(), true, 512, JSON_THROW_ON_ERROR);
        assert(is_array($data));
        return $this->hydrator->hydrate(LegalInfoResponse::class, $data);
    }
}
