<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Integration\Kilbil;

use Acme\Kilbil\Generated\Enum\SearchClientRequestContentSearchMode;
use Acme\Kilbil\Generated\Model\SearchClient403Content;
use Acme\Kilbil\Generated\Model\SearchClientRequestContent;
use Mlavrinenko\Paogen\Tests\Generated\RecordingClient;
use PHPUnit\Framework\TestCase;

use function urlencode;

/**
 * kilbil-recorded-response-proof: the request side (the `h` query-string
 * credential reaching an actually-built request) and the 403 path, both
 * against the real `HttpTransport` — see `KilbilHttpHarness`.
 *
 * The 403 half changed shape under `typed-error-responses`: kilbil declares
 * a body for 403 on every operation, so it is a return value now — a
 * `SearchClient403Content` hydrated onto the envelope — not an `ApiException`.
 * `error-response-policy` threw on any non-2xx; the owner ruling that
 * superseded it says the status does not change the shape of the return.
 */
final class KilbilRequestAndErrorTest extends TestCase
{
    public static function setUpBeforeClass(): void
    {
        KilbilGeneratedAutoload::register();
    }

    public function testTheHCredentialReachesTheQueryStringOfAnActuallyBuiltRequest(): void
    {
        $http = new RecordingClient(KilbilHttpHarness::jsonResponse(200, KilbilFixture::raw('searchclient-found')));
        $client = KilbilHttpHarness::client($http, 'super-secret-h-value');

        $client->customers()->searchClient(new SearchClientRequestContent(
            search_mode: SearchClientRequestContentSearchMode::_1,
            search_value: '79129999999',
        ));

        self::assertNotNull($http->lastRequest);
        $uri = $http->lastRequest->getUri();
        self::assertSame('/api/load/searchclient', $uri->getPath());
        // Query, not a header or the body — the scheme this document
        // declares (`h`, apiKey, in: query, global security).
        self::assertStringContainsString('h=' . urlencode('super-secret-h-value'), $uri->getQuery());
        self::assertStringNotContainsString('h', $http->lastRequest->getHeaderLine('Authorization'));
    }

    public function testA403ResponseHydratesIntoTheDeclaredErrorBodyRatherThanThrowing(): void
    {
        // Body from the vendor's own 403 example (schemas/loyalty_v1.yaml
        // ~985-992): result_code example 1, result_text example
        // 'Доступ запрещен'.
        $http = new RecordingClient(KilbilHttpHarness::jsonResponse(403, KilbilFixture::raw('error-403')));
        $client = KilbilHttpHarness::client($http, 'super-secret-h-value');

        $result = $client->customers()->searchClient(new SearchClientRequestContent(
            search_mode: SearchClientRequestContentSearchMode::_1,
            search_value: '79129999999',
        ));

        self::assertSame(403, $result->status);
        self::assertInstanceOf(SearchClient403Content::class, $result->body);
        self::assertSame(1, $result->body->result_code);
        self::assertSame('Доступ запрещен', $result->body->result_text);
        self::assertNotNull($http->lastRequest);
        self::assertSame(403, $result->response->getStatusCode());
    }
}
