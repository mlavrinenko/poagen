<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Support;

/**
 * The guidance the petstore fixture document needs before it will generate
 * at all, said once for every test that builds a `Profile` against it in
 * code rather than loading `tests/fixtures/profiles/petstore.php`.
 *
 * The document requires `api_key` on `getPetById` and `getInventory` and
 * declares only `petstore_auth`, so the requirement names a credential
 * nothing describes. paogen refuses to guess a header name and aborts
 * naming `Profile::$securitySchemes` — see
 * `report-unsupported-security-schemes`. The fixture is an unmodified
 * vendor document (`fixtures-are-unmodified-vendor-documents`), so the gap
 * is filled from the profile side, here and in the fixture profile alike.
 */
final readonly class PetstoreFixture
{
    /**
     * Swagger's own petstore sends the key as the `api_key` request header.
     *
     * @var array<string, array<string, mixed>>
     */
    public const array SECURITY_SCHEMES = [
        'api_key' => ['type' => 'apiKey', 'in' => 'header', 'name' => 'api_key'],
    ];
}
