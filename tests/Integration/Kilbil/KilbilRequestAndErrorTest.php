<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Integration\Kilbil;

use Acme\Kilbil\Generated\ApiException;
use Acme\Kilbil\Generated\Enum\SearchClientRequestContentSearchMode;
use Acme\Kilbil\Generated\Model\SearchClientRequestContent;
use Mlavrinenko\Paogen\Tests\Generated\RecordingClient;
use PHPUnit\Framework\TestCase;

use function urlencode;

/**
 * kilbil-recorded-response-proof: the request side (the `h` query-string
 * credential reaching an actually-built request) and the 403 failure path
 * (`ApiException` carrying the original request and response), both against
 * the real `HttpTransport` — see `KilbilHttpHarness`.
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

    public function testA403ResponseProducesApiExceptionCarryingTheOriginalRequestAndResponse(): void
    {
        // Body from the vendor's own 403 example (schemas/loyalty_v1.yaml
        // ~985-992): result_code example 1, result_text example
        // 'Доступ запрещен'.
        $http = new RecordingClient(KilbilHttpHarness::jsonResponse(403, KilbilFixture::raw('error-403')));
        $client = KilbilHttpHarness::client($http, 'super-secret-h-value');

        try {
            $client->customers()->searchClient(new SearchClientRequestContent(
                search_mode: SearchClientRequestContentSearchMode::_1,
                search_value: '79129999999',
            ));
            self::fail('expected an ApiException on a 403 response');
        } catch (ApiException $e) {
            self::assertSame(403, $e->getStatusCode());
            self::assertNotNull($http->lastRequest);
            self::assertSame($http->lastRequest, $e->getRequest());
            self::assertSame(403, $e->getResponse()->getStatusCode());
            self::assertSame(
                ['result_code' => 1, 'result_text' => 'Доступ запрещен'],
                $e->getDecodedBody(),
            );
        }
    }
}
