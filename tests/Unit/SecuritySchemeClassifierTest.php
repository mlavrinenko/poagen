<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Unit;

use cebe\openapi\spec\SecurityScheme as CebeSecurityScheme;
use Mlavrinenko\Paogen\Generator\Emit\SecurityScheme;
use Mlavrinenko\Paogen\Generator\Emit\SecuritySchemeClassifier;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * report-unsupported-security-schemes: the classification rules, exercised
 * on the declarations a well-formed document does not contain.
 *
 * The fixtures under `tests/fixtures/schemas` cover what a real vendor
 * writes. These are the malformed and the invented — a declaration whose
 * `in` is not a place a credential can go, one with no key to send under,
 * an `http` block with no scheme name at all, and a scheme token that
 * could not survive in an `Authorization` header. Each is refused rather
 * than guessed at, and each says which part of the declaration is the
 * problem.
 */
final class SecuritySchemeClassifierTest extends TestCase
{
    /**
     * @return array<string, array{0:array<string,mixed>, 1:string, 2:string}>
     */
    public static function refusals(): array
    {
        return [
            'apiKey in a place no credential can go' => [
                ['type' => 'apiKey', 'in' => 'body', 'name' => 'k'],
                "apiKey in: 'body'",
                'nothing else is a place paogen can put it',
            ],
            'apiKey with no key to send under' => [
                ['type' => 'apiKey', 'in' => 'header'],
                'apiKey in: header',
                'carries no `name`',
            ],
            'http with no scheme name' => [
                ['type' => 'http'],
                'http (no scheme)',
                'has to be a token that can precede a credential',
            ],
            'http whose scheme name is not a token' => [
                ['type' => 'http', 'scheme' => 'my scheme'],
                "http 'my scheme'",
                'has to be a token that can precede a credential',
            ],
            'a type the specification does not define' => [
                ['type' => 'kerberos'],
                'kerberos',
                'unknown means refused, never ignored',
            ],
            'a declaration with no type at all' => [
                [],
                '(no type)',
                'unknown means refused, never ignored',
            ],
        ];
    }

    /**
     * @param array<string,mixed> $declaration
     */
    #[DataProvider('refusals')]
    public function testAMalformedOrInventedDeclarationIsRefusedAndSaysWhy(
        array $declaration,
        string $typeLabel,
        string $reasonFragment,
    ): void {
        $scheme = SecuritySchemeClassifier::classify('theScheme', new CebeSecurityScheme($declaration));

        self::assertTrue($scheme->isRefused());
        self::assertFalse($scheme->isWired());
        self::assertSame($typeLabel, $scheme->typeLabel);
        self::assertStringContainsString($reasonFragment, $scheme->refusalReason);
        // Nothing to emit: a refused scheme claims no constructor argument.
        self::assertSame([''], $scheme->ctorArgs());
    }

    public function testAnHttpSchemeTokenIsMatchedCaseInsensitivelyAndKeepsItsOwnSpellingOnTheWire(): void
    {
        // RFC 7235 makes the scheme name case-insensitive, so `Bearer` is
        // the bearer kind rather than a vendor word that merely looks like
        // one — and it keeps `bearerToken` as its argument name, which is
        // what `distinct-ctor-args-for-colliding-schemes` assumes.
        $bearer = SecuritySchemeClassifier::classify('auth', new CebeSecurityScheme(['type' => 'http', 'scheme' => 'Bearer']));

        self::assertSame(SecurityScheme::KIND_BEARER, $bearer->kind);
        self::assertSame('bearerToken', $bearer->ctorArg);

        $basic = SecuritySchemeClassifier::classify('auth', new CebeSecurityScheme(['type' => 'http', 'scheme' => 'BASIC']));

        self::assertSame(SecurityScheme::KIND_BASIC, $basic->kind);
        self::assertSame(['basicUser', 'basicPassword'], $basic->ctorArgs());
    }

    public function testATwoValuedSchemeRenamedForACollisionDerivesBothNamesFromTheOneBase(): void
    {
        // Two `http basic` schemes both propose `basicUser`/`basicPassword`,
        // so the catalog rebuilds each from its own key. The pair has to
        // stay recognisably one credential after the rename.
        $renamed = SecuritySchemeClassifier::classify('vendor_auth', new CebeSecurityScheme([
            'type' => 'http',
            'scheme' => 'basic',
        ]))->withCtorArgBase(SecurityScheme::camelize('vendor_auth'));

        self::assertSame(['vendorAuthUser', 'vendorAuthPassword'], $renamed->ctorArgs());
    }

    public function testASchemeWithNoFlowsCarriesNoMetadataToPublish(): void
    {
        // An oauth2 declaration that names no flows has nothing to say
        // beyond the token, so no constant and no docblock block is emitted
        // for it — the client is not padded with an empty section.
        $bare = SecuritySchemeClassifier::classify('bare', new CebeSecurityScheme(['type' => 'oauth2']));

        self::assertSame(SecurityScheme::KIND_OAUTH2, $bare->kind);
        self::assertTrue($bare->isWired());
        self::assertFalse($bare->hasFlowMetadata());
        self::assertNotNull($bare->flows);
        self::assertSame([], $bare->flows->flows);
        self::assertNull($bare->flows->discoveryUrl);
    }
}
