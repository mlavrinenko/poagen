<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Integration\Kilbil;

use Acme\Kilbil\Generated\Enum\SearchClientRequestSearchMode;
use Acme\Kilbil\Generated\Enum\SearchClientResponseActivateClientType;
use Acme\Kilbil\Generated\Enum\SearchClientResponseInterfacesItemInterfaceType;
use Acme\Kilbil\Generated\Enum\SearchClientResponseProgramType;
use Acme\Kilbil\Generated\Model\SearchClientRequest;
use Acme\Kilbil\Generated\Model\SearchClientResponse;
use Acme\Kilbil\Generated\Model\SearchClientResponseCardsItem;
use Acme\Kilbil\Generated\Model\SearchClientResponseInterfacesItem;
use Acme\Kilbil\ValueObject\PhoneNumber;
use DateTimeImmutable;
use Mlavrinenko\Paogen\Tests\Generated\RecordingClient;
use PHPUnit\Framework\TestCase;

/**
 * kilbil-recorded-response-proof: hydrates the generated `searchClient()`
 * call against a response assembled from the vendor's own per-property
 * `example:` values in `schemas/loyalty_v1.yaml` (lines ~349-995), not
 * invented ones. See `examples/kilbil/fixtures/responses/searchclient-found.json`.
 *
 * Two kinds of deviation from a verbatim copy of the vendor's examples, both
 * called out here rather than silently absorbed into the fixture:
 *
 *  - `sms_code_sum` (`type: number`) and `card_state`/`sex` (`type: string`)
 *    each carry a documented `example:` whose JSON *kind* contradicts the
 *    property's own declared `type:` (a quoted `'0'` under `type: number`,
 *    a bare `0`/`1` under `type: string`). The fixture follows the
 *    declared `type:`, because a wire value of the wrong JSON kind fails
 *    to hydrate for reasons that have nothing to do with this task.
 *  - `cards[0].outer_systems_interface_name` — the vendor's own `cards`
 *    example sets this to `null`, but the property is declared plain
 *    `type: string` (not nullable) and required. Copying that verbatim
 *    would fail hydration on a defect in the vendor's *example*, not in
 *    paogen. The fixture instead reuses the value the vendor documents
 *    for the same field name on the sibling `getclientcards` operation
 *    (schemas/loyalty_v1.yaml:~1332), which is internally consistent.
 *  - `outer_systems_interface_type` (top-level) carries no `example:` at
 *    all. The fixture uses `10`, one of the property's own documented
 *    enum values ("10 - Виртуальная карта"), not an invented number.
 *
 * `program_write_off_type`'s only vendor example is the literal `null`
 * (line 803) and `client_id`'s is `'4004565'` (line 364) — both copied
 * verbatim, which is why one fixture carries both halves of the
 * `type: [T, "null"]` null-and-present criterion without inventing either
 * value.
 */
final class KilbilRecordedResponseTest extends TestCase
{
    public static function setUpBeforeClass(): void
    {
        KilbilGeneratedAutoload::register();
    }

    public function testATypeListNullPropertyAndAPresentOneBothHydrate(): void
    {
        $response = $this->searchClientFound();

        // program_write_off_type: type: [string, "null"], vendor's own
        // example is the literal null (schemas/loyalty_v1.yaml:803).
        self::assertNull($response->program_write_off_type);
        // client_id: type: [string, "null"], vendor's own example is
        // '4004565' (schemas/loyalty_v1.yaml:364).
        self::assertSame('4004565', $response->client_id);
    }

    public function testANestedListOfObjectsHydratesToTypedItems(): void
    {
        $response = $this->searchClientFound();

        self::assertCount(1, $response->cards ?? []);
        $card = ($response->cards ?? [])[0];
        self::assertInstanceOf(SearchClientResponseCardsItem::class, $card);
        self::assertSame(10963328, $card->card_id);
        self::assertSame('0061', $card->code);

        self::assertCount(1, $response->interfaces ?? []);
        $interface = ($response->interfaces ?? [])[0];
        self::assertInstanceOf(SearchClientResponseInterfacesItem::class, $interface);
        self::assertSame('Telegram', $interface->interface_name);
        self::assertSame(SearchClientResponseInterfacesItemInterfaceType::_0, $interface->interface_type);

        // A second nested list, doubly nested under `_bill_data`.
        self::assertCount(2, $response->_bill_data->items);
        self::assertSame('2137', $response->_bill_data->items[0]->code);
        self::assertSame(130.0, $response->_bill_data->items[0]->price);
        self::assertNull($response->_bill_data->items[0]->new_price_action_id);
        self::assertSame(32243, $response->_bill_data->items[1]->new_price_action_id);
    }

    public function testANestedListItemsOwnNullableDateHydratesBothWays(): void
    {
        $response = $this->searchClientFound();

        self::assertCount(2, $response->special_days_types);
        self::assertInstanceOf(DateTimeImmutable::class, $response->special_days_types[0]->value);
        self::assertSame('2017-07-07', $response->special_days_types[0]->value->format('Y-m-d'));
        self::assertNull($response->special_days_types[1]->value);
    }

    public function testAPropertyBoundToAConsumerValueObjectHydrates(): void
    {
        $response = $this->searchClientFound();

        self::assertInstanceOf(PhoneNumber::class, $response->phone);
        self::assertSame('79129999999', $response->phone->digits);
    }

    public function testEnumValuedPropertiesHydrateToBackedEnumCases(): void
    {
        $response = $this->searchClientFound();

        self::assertSame(SearchClientResponseActivateClientType::_1, $response->activate_client_type);
        self::assertSame(SearchClientResponseProgramType::_0, $response->program_type);
    }

    private function searchClientFound(): SearchClientResponse
    {
        $http = new RecordingClient(KilbilHttpHarness::jsonResponse(200, KilbilFixture::raw('searchclient-found')));
        $client = KilbilHttpHarness::client($http);

        return $client->customers()->searchClient(new SearchClientRequest(
            search_mode: SearchClientRequestSearchMode::_1,
            search_value: '79129999999',
        ));
    }
}
