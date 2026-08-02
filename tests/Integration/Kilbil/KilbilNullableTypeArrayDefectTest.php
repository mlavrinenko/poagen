<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Integration\Kilbil;

use Acme\Kilbil\Generated\Enum\SearchClientRequestSearchMode;
use Acme\Kilbil\Generated\Model\SearchClientRequest;
use Mlavrinenko\Paogen\Tests\Generated\RecordingClient;
use PHPUnit\Framework\TestCase;
use TypeError;

use function json_encode;
use function str_contains;

use const JSON_THROW_ON_ERROR;
use const JSON_UNESCAPED_UNICODE;

/**
 * kilbil-recorded-response-proof — defect probes, not required coverage.
 *
 * `state` and `special_days_types` are both declared `type: [T, "null"]` in
 * the vendor's document (schemas/loyalty_v1.yaml:365-379, 721-726), so a
 * spec-compliant server may send JSON `null` for either. Sending that null
 * through the real `Hydrator` throws `TypeError`, because
 * `src/Generator/Emit/PropertySynthesiser.php:59` computes a property's
 * nullability from `(bool) $propSchema->nullable` alone — the OpenAPI 3.0
 * `nullable: true` flag — and never consults `SchemaType::of($propSchema)
 * ->nullable`, the 3.1 `type: [T, "null"]` array form that
 * `TypeResolver::resolve()` (src/Generator/Emit/TypeResolver.php:55)
 * already reads correctly. The gap hits every property `PropertySynthesiser`
 * resolves itself rather than delegating to `TypeResolver`: a synthesised
 * inline enum (`state`, backed by `SearchClientResponseState`, case `Null`
 * for the vendor's *quoted* `'null'` enum member — a different thing from
 * JSON `null`) and a synthesised array-of-object (`special_days_types`,
 * items are a synthesised model). Both emit a non-nullable PHP type despite
 * their schema's own declared nullability.
 *
 * This is a generator defect, not a runtime one, and not something this
 * task may fix (`src/` is out of bounds here). Each probe reproduces the
 * `TypeError` and then explicitly skips, per the task's instruction to mark
 * a broken shape rather than delete or paper over the assertion.
 */
final class KilbilNullableTypeArrayDefectTest extends TestCase
{
    public static function setUpBeforeClass(): void
    {
        KilbilGeneratedAutoload::register();
    }

    public function testStateNullThrowsInsteadOfHydratingDespiteSchemaDeclaringItNullable(): void
    {
        $data = KilbilFixture::decode('searchclient-found');
        $data['state'] = null;

        try {
            $this->searchClientWith($data);
            self::fail(
                'expected TypeError on state: null — if this no longer throws, the '
                . 'PropertySynthesiser nullable-type-array defect this test documents '
                . 'has been fixed; update this test and truth/tasks accordingly.',
            );
        } catch (TypeError $e) {
            self::assertTrue(str_contains($e->getMessage(), '$state'));
            self::assertTrue(str_contains($e->getMessage(), 'SearchClientResponseState'));
            self::markTestSkipped(
                'defect: searchClient response property `state` is declared '
                . 'type: [string, "null"] (schemas/loyalty_v1.yaml:365-379) but the '
                . 'generated SearchClientResponse::$state has no `?` — PropertySynthesiser.php:59 '
                . 'reads only the 3.0 `nullable` flag. Wire null throws: ' . $e->getMessage(),
            );
        }
    }

    public function testSpecialDaysTypesNullThrowsInsteadOfHydratingDespiteSchemaDeclaringItNullable(): void
    {
        $data = KilbilFixture::decode('searchclient-found');
        $data['special_days_types'] = null;

        try {
            $this->searchClientWith($data);
            self::fail(
                'expected TypeError on special_days_types: null — if this no longer '
                . 'throws, the PropertySynthesiser nullable-type-array defect this test '
                . 'documents has been fixed; update this test and truth/tasks accordingly.',
            );
        } catch (TypeError $e) {
            self::assertTrue(str_contains($e->getMessage(), '$special_days_types'));
            self::assertTrue(str_contains($e->getMessage(), 'must be of type array'));
            self::markTestSkipped(
                'defect: searchClient response property `special_days_types` is declared '
                . 'type: [array, "null"] (schemas/loyalty_v1.yaml:721-726, "null если нет") '
                . 'but the generated SearchClientResponse::$special_days_types has no `?` — '
                . 'same PropertySynthesiser.php:59 gap, array-of-synthesised-object branch. '
                . 'Wire null throws: ' . $e->getMessage(),
            );
        }
    }

    /**
     * @param array<string, mixed> $data
     */
    private function searchClientWith(array $data): void
    {
        $body = json_encode($data, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
        $http = new RecordingClient(KilbilHttpHarness::jsonResponse(200, $body));
        $client = KilbilHttpHarness::client($http);

        $client->customers()->searchClient(new SearchClientRequest(
            search_mode: SearchClientRequestSearchMode::_1,
            search_value: '79129999999',
        ));
    }
}
