<?php

declare(strict_types=1);

namespace Poagen\Generator\Tests\Integration\Kilbil;

use Acme\Kilbil\Generated\Enum\SearchClientRequestContentSearchMode;
use Acme\Kilbil\Generated\Model\GetPrograms200Content;
use Acme\Kilbil\Generated\Model\SearchClient200Content;
use Acme\Kilbil\Generated\Model\SearchClientRequestContent;
use PHPUnit\Framework\TestCase;
use Poagen\Generator\Tests\Generated\RecordingClient;

/**
 * reconcile-the-kilbil-schema-with-what-the-live-api-actually-sends:
 * hydrates three responses recorded against the real test API on 2026-08-05
 * (see `examples/kilbil/README.md`'s "Corrections against the live API"
 * section for the full field-by-field record), each one a shape the
 * vendor's document could not have produced before this task's schema
 * corrections.
 *
 * `fixtures/responses/searchclient-found-live.json` and
 * `searchclient-not-found.json` have every personal field (name, phone,
 * email, birth date, client id) replaced with the vendor's own placeholder
 * examples from `schemas/loyalty_v1.yaml` — see that fixture's sibling
 * `searchclient-found.json` and `KilbilRecordedResponseTest` for the same
 * convention. Every other field, including the exact JSON kind of each
 * numeric value, is the real wire response.
 */
final class KilbilLiveShapeReconciliationTest extends TestCase
{
    public static function setUpBeforeClass(): void
    {
        KilbilGeneratedAutoload::register();
    }

    /**
     * `getprograms` sends `result_code` as a JSON int (`0`) where
     * `searchclient` sends it as a JSON string (`"6"`/`"0"`) — the defect
     * this task fixes by widening `result_code`'s declared type to
     * `[string, integer]` document-wide.
     */
    public function testGetProgramsIntResultCodeHydratesWithoutThrowing(): void
    {
        $http = new RecordingClient(KilbilHttpHarness::jsonResponse(200, KilbilFixture::raw('getprograms')));
        $client = KilbilHttpHarness::client($http);

        $result = $client->loyaltySettings()->getPrograms([]);

        self::assertInstanceOf(GetPrograms200Content::class, $result->body);
        self::assertSame(0, $result->body->result_code);
        self::assertCount(2, $result->body->data ?? []);
    }

    /**
     * The real "not found" `searchclient` response: HTTP 200, `_bill_data`
     * omitted outright, and roughly fifty other declared-required fields
     * sent as JSON `null`. Before this task every one of those was declared
     * required and non-nullable, so hydration threw on the first missing or
     * mistyped argument.
     */
    public function testSearchClientNotFoundHydratesIntoAUsableObjectInsteadOfThrowing(): void
    {
        $http = new RecordingClient(KilbilHttpHarness::jsonResponse(200, KilbilFixture::raw('searchclient-not-found')));
        $client = KilbilHttpHarness::client($http);

        $result = $client->customers()->searchClient(new SearchClientRequestContent(
            search_mode: SearchClientRequestContentSearchMode::_0,
            search_value: '79000000000',
        ));

        self::assertInstanceOf(SearchClient200Content::class, $result->body);
        $response = $result->body;

        self::assertSame('6', $response->result_code);
        self::assertSame('Клиент не найден', $response->result_text);
        self::assertNull($response->client_id);
        self::assertNull($response->_bill_data);
        self::assertNull($response->bonus_percent);
        self::assertNull($response->program_name);
        self::assertNull($response->program_type);
        self::assertNull($response->client_email);
        self::assertNull($response->not_to_send_sms);
        self::assertNull($response->not_to_send_email);
    }

    /**
     * The same "found" shape as `searchclient-found.json`, but recorded from
     * the real API rather than assembled from the vendor's per-property
     * `example:` values — and unlike that fixture, several money/counter
     * fields the vendor declares `type: string` arrive as a bare JSON `0`
     * when the value is zero (`discount`, `discounted_total`,
     * `max_bonus_out`, `max_bill_bonus_out`) while a non-zero one of the
     * same family (`purchases_sum`) still arrives as a string. Both kinds
     * have to hydrate through the same property.
     */
    public function testSearchClientFoundHydratesBothIntAndStringMoneyFields(): void
    {
        $http = new RecordingClient(KilbilHttpHarness::jsonResponse(200, KilbilFixture::raw('searchclient-found-live')));
        $client = KilbilHttpHarness::client($http);

        $result = $client->customers()->searchClient(new SearchClientRequestContent(
            search_mode: SearchClientRequestContentSearchMode::_3,
            search_value: '10000000',
        ));

        self::assertInstanceOf(SearchClient200Content::class, $result->body);
        $response = $result->body;

        self::assertSame('0', $response->result_code);
        self::assertSame('10000000', $response->client_id);
        self::assertSame(0, $response->discount);
        self::assertSame(0, $response->discounted_total);
        self::assertSame(0, $response->max_bonus_out);
        self::assertSame(0, $response->max_bill_bonus_out);
        self::assertSame('44.00', $response->purchases_sum);
        self::assertSame(0, $response->not_to_send_sms);
        self::assertSame(0, $response->not_to_send_email);
    }
}
