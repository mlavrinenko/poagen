<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Support;

use Mlavrinenko\Paogen\Runtime\Contract\ErrorFactoryInterface;
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
final class StubErrorFactory implements ErrorFactoryInterface
{
    public function errorFor(int $status, RequestInterface $request, ResponseInterface $response): Throwable
    {
        return new RuntimeException(sprintf(
            'HTTP %d for %s (%d bytes)',
            $status,
            (string) $request->getUri(),
            $response->getBody()->getSize() ?? 0,
        ));
    }
}
