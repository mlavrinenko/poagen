<?php

declare(strict_types=1);

namespace Poagen\Generator\Tests\Support;

use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7\Response;
use Poagen\Generator\Tests\Fixtures\Generated\Petstore\Generated\ApiException;
use Poagen\Generator\Tests\Generated\RecordingClient;
use Poagen\Generator\Tests\Unit\Runtime\EnvelopeTransportTest;
use Poagen\Generator\Tests\Unit\Runtime\TransportResponseKindsTest;
use Poagen\Runtime\Http\HttpTransport;

/**
 * The one {@see HttpTransport} every petstore-fixture transport test builds:
 * a fixed base address, the committed petstore `ApiException`, and either a
 * canned response or a caller-supplied {@see RecordingClient} for a request
 * assertion. Shared by {@see TransportResponseKindsTest}
 * and {@see EnvelopeTransportTest} —
 * the same five response shapes and `KIND_ENVELOPE`, split across two files
 * to keep both under the linecop limit, need the identical transport under
 * them rather than two copies of it.
 */
trait PetstoreHttpTransport
{
    private function transport(?Response $response, ?RecordingClient $http = null): HttpTransport
    {
        $factory = new Psr17Factory();
        $http ??= new RecordingClient($response ?? new Response(204, [], ''));

        return new HttpTransport(
            'https://petstore.example/api/v3',
            ApiException::class,
            $http,
            $factory,
            $factory,
        );
    }
}
