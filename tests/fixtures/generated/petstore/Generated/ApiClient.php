<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated;

use Mlavrinenko\Paogen\Runtime\Marshal\Hydrator;
use Mlavrinenko\Paogen\Runtime\Marshal\Marshaller;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

final readonly class ApiClient implements ApiClientInterface
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
     * The `pet` endpoints.
     */
    public function pet(): PetClientInterface
    {
        return new PetClient($this->httpClient, $this->requestFactory, $this->streamFactory, $this->baseUri, $this->hydrator, $this->marshaller);
    }

    /**
     * The `store` endpoints.
     */
    public function store(): StoreClientInterface
    {
        return new StoreClient($this->httpClient, $this->requestFactory, $this->streamFactory, $this->baseUri, $this->hydrator, $this->marshaller);
    }

    /**
     * The `user` endpoints.
     */
    public function user(): UserClientInterface
    {
        return new UserClient($this->httpClient, $this->requestFactory, $this->streamFactory, $this->baseUri, $this->hydrator, $this->marshaller);
    }
}
