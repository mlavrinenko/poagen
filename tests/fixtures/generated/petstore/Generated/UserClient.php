<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated;

use Mlavrinenko\Paogen\Runtime\Marshal\Hydrator;
use Mlavrinenko\Paogen\Runtime\Marshal\Marshaller;
use Mlavrinenko\Paogen\Tests\Fixtures\Generated\Petstore\Generated\Model\User;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

use function array_map;
use function assert;
use function implode;
use function is_array;
use function json_decode;
use function json_encode;
use function rtrim;
use function str_replace;
use function urlencode;

use const JSON_THROW_ON_ERROR;

final readonly class UserClient implements UserClientInterface
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

    public function createUser(User $body): User
    {
        $path = '/user';
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
        return $this->hydrator->hydrate(User::class, $data);
    }

    /**
     * @param list<User> $body
     */
    public function createUsersWithListInput(array $body): User
    {
        $path = '/user/createWithList';
        $request = $this->requestFactory->createRequest('POST', rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(json_encode(array_map(fn(object $__m): array => $this->marshaller->marshal($__m), $body), JSON_THROW_ON_ERROR)));
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = json_decode((string) $response->getBody(), true, 512, JSON_THROW_ON_ERROR);
        assert(is_array($data));
        return $this->hydrator->hydrate(User::class, $data);
    }

    public function loginUser(?string $username = null, ?string $password = null): string
    {
        $path = '/user/login';
        $query = [];
        if ($username !== null) {
            $query[] = 'username=' . urlencode($username);
        }
        if ($password !== null) {
            $query[] = 'password=' . urlencode($password);
        }
        if ($query !== []) { $path .= '?' . implode('&', $query); }
        $request = $this->requestFactory->createRequest('GET', rtrim($this->baseUri, '/') . $path);
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
        $request = $this->requestFactory->createRequest('GET', rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function getUserByName(string $username): User
    {
        $path = '/user/{username}';
        $path = str_replace('{username}', $username, $path);
        $request = $this->requestFactory->createRequest('GET', rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
        /** @var mixed $data */
        $data = json_decode((string) $response->getBody(), true, 512, JSON_THROW_ON_ERROR);
        assert(is_array($data));
        return $this->hydrator->hydrate(User::class, $data);
    }

    public function updateUser(string $username, User $body): void
    {
        $path = '/user/{username}';
        $path = str_replace('{username}', $username, $path);
        $request = $this->requestFactory->createRequest('PUT', rtrim($this->baseUri, '/') . $path);
        $request = $request
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(json_encode($this->marshaller->marshal($body), JSON_THROW_ON_ERROR)));
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }

    public function deleteUser(string $username): void
    {
        $path = '/user/{username}';
        $path = str_replace('{username}', $username, $path);
        $request = $this->requestFactory->createRequest('DELETE', rtrim($this->baseUri, '/') . $path);
        $response = $this->httpClient->sendRequest($request);
        $__status = $response->getStatusCode();
        if ($__status < 200 || $__status >= 300) {
            throw new ApiException($__status, $request, $response);
        }
    }
}
