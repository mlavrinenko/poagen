<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Integration\Kilbil;

use Acme\Kilbil\Generated\ApiClient;
use Acme\Kilbil\Generated\ApiException;
use Mlavrinenko\Paogen\Runtime\Http\HttpTransport;
use Mlavrinenko\Paogen\Runtime\Marshal\XmlWriter;
use Mlavrinenko\Paogen\Tests\Generated\RecordingClient;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7\Response;

/**
 * Wires the real, committed kilbil `ApiClient` over the real `HttpTransport`
 * — the same runtime a consumer gets by default — against a PSR-18 stub that
 * never leaves the process. Nothing here is a substitute transport: the
 * point is proving `PsrRequestBuilder`, `Marshaller`, `Hydrator` and
 * `ResponseDecoder` all actually run end to end.
 */
final class KilbilHttpHarness
{
    public const string BASE_URI = 'https://kilbil.example/api';

    /**
     * `$xmlWriter` lets a caller exercise the nested-container wiring
     * `Mlavrinenko\Paogen\Runtime\Marshal\XmlWriter`'s own constructor takes
     * — the real `HttpTransport` still, over the real committed `ApiClient`,
     * just with a consumer-supplied writer in place of the bare default
     * (kilbil-xml-nesting-is-unrepresentable).
     */
    public static function client(RecordingClient $http, string $h = 'kilbil-test-key', ?XmlWriter $xmlWriter = null): ApiClient
    {
        $factory = new Psr17Factory();

        $transport = new HttpTransport(
            self::BASE_URI,
            ApiException::class,
            $http,
            $factory,
            $factory,
            xmlWriter: $xmlWriter,
        );

        return new ApiClient($transport, $h);
    }

    public static function jsonResponse(int $status, string $body): Response
    {
        return new Response($status, ['Content-Type' => 'application/json'], $body);
    }
}
