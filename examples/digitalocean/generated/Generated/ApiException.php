<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;

/**
 * Thrown by every emitted operation when the response status is non-2xx.
 *
 * Carries the original PSR-7 request and response together with a
 * best-effort JSON decode of the body. Decode failures are swallowed:
 * `getDecodedBody()` returns `null` when the body is empty or not JSON.
 */
final class ApiException extends RuntimeException
{
    private mixed $decodedBody = null;
    private bool $decoded = false;

    public function __construct(
        private readonly int $statusCode,
        private readonly RequestInterface $request,
        private readonly ResponseInterface $response,
        string $message = '',
    ) {
        parent::__construct($message);
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getRequest(): RequestInterface
    {
        return $this->request;
    }

    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }

    /**
     * Best-effort JSON decode of the response body.
     *
     * Returns `null` for an empty body or any decode failure (per ADR-009).
     * Cached on first call.
     */
    public function getDecodedBody(): mixed
    {
        if ($this->decoded) {
            return $this->decodedBody;
        }

        $this->decoded = true;

        $body = (string) $this->response->getBody();

        if ($body === '') {
            return $this->decodedBody;
        }

        /** @var mixed $decoded */
        $decoded = \json_decode($body, true);

        if (\json_last_error() !== \JSON_ERROR_NONE) {
            return $this->decodedBody;
        }

        $this->decodedBody = $decoded;

        return $this->decodedBody;
    }
}
