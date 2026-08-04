<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Integration\Kilbil;

use Acme\Kilbil\Generated\Enum\SearchClientRequestContentSearchMode;
use Acme\Kilbil\Generated\Model\SearchClient200Content;
use Acme\Kilbil\Generated\Model\SearchClientRequestContent;
use Mlavrinenko\Paogen\Tests\Generated\RecordingClient;
use PHPUnit\Framework\TestCase;

use function json_encode;

use const JSON_THROW_ON_ERROR;
use const JSON_UNESCAPED_UNICODE;

/**
 * kilbil-recorded-response-proof — regression probes for
 * nullable-type-array-lost-in-property-synthesis.
 *
 * `state` and `special_days_types` are both declared `type: [T, "null"]` in
 * the vendor's document (schemas/loyalty_v1.yaml:365-379, 721-726), so a
 * spec-compliant server may send JSON `null` for either. That used to throw
 * `TypeError` out of the real `Hydrator`, because `PropertySynthesiser`
 * computed a property's nullability from `(bool) $propSchema->nullable`
 * alone — the OpenAPI 3.0 `nullable: true` flag — and never consulted
 * `SchemaType::of($propSchema)->nullable`, the 3.1 `type: [T, "null"]` array
 * form that `TypeResolver::resolve()` already read correctly. The gap hit
 * every property `PropertySynthesiser` resolves itself rather than
 * delegating to `TypeResolver`: a synthesised inline enum (`state`, backed
 * by `SearchClient200ContentState`, case `Null` for the vendor's *quoted*
 * `'null'` enum member — a different thing from JSON `null`) and a
 * synthesised array-of-object (`special_days_types`, items are a
 * synthesised model). Both emitted a non-nullable PHP type despite their
 * schema's own declared nullability. `PropertySynthesiser` and
 * `TypeResolver` now share one derivation (`SchemaType::nullableOf()`), and
 * these two probes prove the wire shape hydrates instead of throwing.
 */
final class KilbilNullableTypeArrayDefectTest extends TestCase
{
    public static function setUpBeforeClass(): void
    {
        KilbilGeneratedAutoload::register();
    }

    public function testStateNullHydratesToNullInsteadOfThrowing(): void
    {
        $data = KilbilFixture::decode('searchclient-found');
        $data['state'] = null;

        $response = $this->searchClientWith($data);

        self::assertNull($response->state);
    }

    public function testSpecialDaysTypesNullHydratesToNullInsteadOfThrowing(): void
    {
        $data = KilbilFixture::decode('searchclient-found');
        $data['special_days_types'] = null;

        $response = $this->searchClientWith($data);

        self::assertNull($response->special_days_types);
    }

    /**
     * @param array<string, mixed> $data
     */
    private function searchClientWith(array $data): SearchClient200Content
    {
        $body = json_encode($data, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
        $http = new RecordingClient(KilbilHttpHarness::jsonResponse(200, $body));
        $client = KilbilHttpHarness::client($http);

        $result = $client->customers()->searchClient(new SearchClientRequestContent(
            search_mode: SearchClientRequestContentSearchMode::_1,
            search_value: '79129999999',
        ));

        self::assertInstanceOf(SearchClient200Content::class, $result->body);

        return $result->body;
    }
}
