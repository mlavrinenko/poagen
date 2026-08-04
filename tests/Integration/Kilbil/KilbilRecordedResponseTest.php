<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Integration\Kilbil;

use Acme\Kilbil\Generated\Enum\SearchClient200ContentActivateClientType;
use Acme\Kilbil\Generated\Enum\SearchClient200ContentInterfacesItemInterfaceType;
use Acme\Kilbil\Generated\Enum\SearchClient200ContentProgramType;
use Acme\Kilbil\Generated\Enum\SearchClientRequestContentSearchMode;
use Acme\Kilbil\Generated\Model\SearchClient200Content;
use Acme\Kilbil\Generated\Model\SearchClient200ContentCardsItem;
use Acme\Kilbil\Generated\Model\SearchClient200ContentInterfacesItem;
use Acme\Kilbil\Generated\Model\SearchClientRequestContent;
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
        self::assertInstanceOf(SearchClient200ContentCardsItem::class, $card);
        self::assertSame(10963328, $card->card_id);
        self::assertSame('0061', $card->code);

        self::assertCount(1, $response->interfaces ?? []);
        $interface = ($response->interfaces ?? [])[0];
        self::assertInstanceOf(SearchClient200ContentInterfacesItem::class, $interface);
        self::assertSame('Telegram', $interface->interface_name);
        self::assertSame(SearchClient200ContentInterfacesItemInterfaceType::_0, $interface->interface_type);

        // A second nested list, doubly nested under `_bill_data`.
        $billItems = $response->_bill_data->items ?? [];
        self::assertCount(2, $billItems);
        self::assertSame('2137', $billItems[0]->code);
        self::assertSame(130.0, $billItems[0]->price);
        self::assertNull($billItems[0]->new_price_action_id);
        self::assertSame(32243, $billItems[1]->new_price_action_id);
    }

    public function testANestedListItemsOwnNullableDateHydratesBothWays(): void
    {
        $response = $this->searchClientFound();

        $specialDays = $response->special_days_types ?? [];
        self::assertCount(2, $specialDays);
        self::assertInstanceOf(DateTimeImmutable::class, $specialDays[0]->value);
        self::assertSame('2017-07-07', $specialDays[0]->value->format('Y-m-d'));
        self::assertNull($specialDays[1]->value);
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

        self::assertSame(SearchClient200ContentActivateClientType::_1, $response->activate_client_type);
        self::assertSame(SearchClient200ContentProgramType::_0, $response->program_type);
    }

    private function searchClientFound(): SearchClient200Content
    {
        $http = new RecordingClient(KilbilHttpHarness::jsonResponse(200, KilbilFixture::raw('searchclient-found')));
        $client = KilbilHttpHarness::client($http);

        $result = $client->customers()->searchClient(new SearchClientRequestContent(
            search_mode: SearchClientRequestContentSearchMode::_1,
            search_value: '79129999999',
        ));

        self::assertInstanceOf(SearchClient200Content::class, $result->body);

        return $result->body;
    }
}
