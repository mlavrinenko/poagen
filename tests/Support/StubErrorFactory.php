<?php

declare(strict_types=1);

namespace Poagen\Generator\Tests\Support;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;
use Throwable;

use function sprintf;

/**
 * The failure policy a test uses when it generates a client into a throwaway
 * namespace at run time.
 *
 * The default factory needs the profile's own `ApiException`, which for a
 * sandbox tree is a class static analysis has never seen. A test whose
 * subject is the request rather than the failure hands this over instead,
 * and keeps the emitted exception's own coverage where the class is a real
 * one — the committed petstore fixture.
 */
final class StubErrorFactory implements \Poagen\Runtime\Contract\ErrorFactoryInterface
{
    public function errorFor(int $status, RequestInterface $request, ResponseInterface $response, string $reason): Throwable
    {
        return new RuntimeException(sprintf(
            'HTTP %d for %s (%d bytes): %s',
            $status,
            (string) $request->getUri(),
            $response->getBody()->getSize() ?? 0,
            $reason,
        ));
    }
}
