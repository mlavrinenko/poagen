<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\OpenApi;
use cebe\openapi\spec\Operation;
use cebe\openapi\spec\Reference;
use cebe\openapi\spec\SecurityRequirement;
use cebe\openapi\spec\SecurityScheme as CebeSecurityScheme;
use stdClass;

use function is_string;

use const SORT_STRING;

/**
 * One-shot lookup over `components.securitySchemes` plus the resolution
 * rules that govern which schemes apply to a given operation.
 *
 * OpenAPI 3.0.3 §4.8.20:
 *   - an operation-level `security: []` (empty array) overrides and
 *     disables the global requirement;
 *   - an absent operation-level `security` inherits the global;
 *   - a non-empty operation-level `security` replaces the global.
 *
 * We follow the same "`$ref`-resolves-at-the-boundary" pattern as
 * {@see ParameterCollector}: unresolvable references are ignored (the
 * scheme is simply not registered) rather than surfacing an error.
 * ADR-002 governs the decorator-layer; this class stops at classifying
 * schemes into the subset we wire up.
 *
 * @internal
 */
final readonly class SecuritySchemeCatalog
{
    /** @var array<string, SecurityScheme> */
    private array $byName;

    /** @var list<string> */
    private array $globalRequirementNames;

    /** @var list<SecurityScheme> */
    private array $supportedInEmissionOrder;

    public function __construct(OpenApi $openApi)
    {
        $this->byName = $this->disambiguateCtorArgs($this->collectSchemes($openApi));
        $this->globalRequirementNames = $this->namesFromMagicProperty($openApi->security);
        $this->supportedInEmissionOrder = $this->orderSupported($this->byName);
    }

    /**
     * The supported schemes present in the schema, in constructor-arg
     * emission order (by scheme name, ascending). Drives the ApiClient
     * constructor's promoted-parameter list.
     *
     * @return list<SecurityScheme>
     */
    public function constructorSchemes(): array
    {
        return $this->supportedInEmissionOrder;
    }

    /**
     * The schemes applied to one operation, after resolving operation-
     * level overrides against the global default. Unsupported schemes are
     * filtered out so the emitter can iterate the list blindly.
     *
     * An operation-level `security: []` disables auth entirely and is
     * honoured here — the returned list will be empty even if the global
     * requirement named a supported scheme.
     *
     * @return list<SecurityScheme>
     */
    public function activeSchemesFor(Operation $operation): array
    {
        $names = $this->operationRequirementNames($operation);

        return $this->filterSupportedByName($names);
    }

    /**
     * @return list<string> may be empty (auth disabled) or equal to the
     *                      global default when the op does not override
     */
    private function operationRequirementNames(Operation $operation): array
    {
        // Absent `security` on an Operation means "inherit the global",
        // and `security: []` means "no auth here" — two different facts
        // that both read as an empty name list. The parser presents the
        // absent one as `null` (per attributeDefaults) and the empty one
        // as `[]`, so telling them apart needs `isset`, not a count.
        if (!isset($operation->security)) {
            return $this->globalRequirementNames;
        }

        return $this->namesFromMagicProperty($operation->security);
    }

    /**
     * @param list<string> $names
     *
     * @return list<SecurityScheme>
     */
    private function filterSupportedByName(array $names): array
    {
        $out = [];

        foreach ($names as $name) {
            $scheme = $this->byName[$name] ?? null;

            if ($scheme instanceof SecurityScheme && $scheme->isSupported()) {
                $out[] = $scheme;
            }
        }

        return $out;
    }

    /**
     * @return array<string, SecurityScheme>
     */
    private function collectSchemes(OpenApi $openApi): array
    {
        $components = $openApi->components;

        if ($components === null) {
            return [];
        }

        /** @var array<string, CebeSecurityScheme|Reference> $schemes */
        $schemes = $components->securitySchemes ?? [];

        $out = [];

        foreach ($schemes as $name => $scheme) {
            if (!is_string($name)) {
                continue;
            }

            $resolved = $this->resolveScheme($scheme);

            if (!$resolved instanceof CebeSecurityScheme) {
                continue;
            }

            $out[$name] = SecurityScheme::fromCebe($name, $resolved);
        }

        return $out;
    }

    /**
     * A scheme's default ctorArg is fixed per kind — `bearerToken` for every
     * http bearer scheme — so two schemes of the same kind collide unless
     * something breaks the tie. DigitalOcean's document is the case that
     * forced this: `bearer_auth` and `inference_bearer_auth` are both http
     * bearer, and per the document's own description are two genuinely
     * different credentials (an OAuth token and a separate Inference API
     * key), not one credential declared twice. See
     * `truth/decisions/distinct-ctor-args-for-colliding-schemes.decision-260802.typ`.
     *
     * A document where a kind appears once never collides, so its ctorArg
     * is untouched and output is unchanged from before this method existed.
     *
     * @param array<string, SecurityScheme> $byName
     *
     * @return array<string, SecurityScheme>
     */
    private function disambiguateCtorArgs(array $byName): array
    {
        $counts = [];

        foreach ($byName as $scheme) {
            if ($scheme->isSupported()) {
                $counts[$scheme->ctorArg] = ($counts[$scheme->ctorArg] ?? 0) + 1;
            }
        }

        $out = [];

        foreach ($byName as $name => $scheme) {
            $collides = $scheme->isSupported() && ($counts[$scheme->ctorArg] ?? 0) > 1;

            $out[$name] = $collides
                ? new SecurityScheme(
                    kind: $scheme->kind,
                    wireName: $scheme->wireName,
                    ctorArg: SecurityScheme::camelize($name),
                )
                : $scheme;
        }

        return $out;
    }

    private function resolveScheme(Reference|CebeSecurityScheme $scheme): ?CebeSecurityScheme
    {
        if ($scheme instanceof CebeSecurityScheme) {
            return $scheme;
        }

        $resolved = $scheme->resolve();

        return $resolved instanceof CebeSecurityScheme ? $resolved : null;
    }

    /**
     * A security requirement names its schemes as its own keys — a
     * `SecurityRequirement` has no fixed attribute list, so
     * `{"apiKey": []}` is one object whose single key is the scheme name.
     *
     * `devizzent/cebe-php-openapi` hands `$openApi->security` and
     * `$operation->security` over as a plain list of those objects, which
     * is what its docblock says. The parser this replaced wrapped the list
     * in a `SecurityRequirements` container with a `getRequirements()`
     * accessor and declared the same docblock type anyway; that class does
     * not exist in the fork
     * (`vendor/devizzent/cebe-php-openapi/src/spec/` has
     * `SecurityRequirement` only). `getSerializableData()` is the public
     * way to read the keys of an object with no fixed attributes.
     *
     * `null` is the absent-override case on an Operation, kept separate
     * from an empty list by {@see operationRequirementNames}.
     *
     * @param array<SecurityRequirement>|null $security
     *
     * @return list<string>
     */
    private function namesFromMagicProperty(?array $security): array
    {
        $out = [];

        foreach ($security ?? [] as $requirement) {
            if (!$requirement instanceof SecurityRequirement) {
                continue;
            }

            $data = $requirement->getSerializableData();

            if (!$data instanceof stdClass) {
                continue;
            }

            foreach (array_keys(get_object_vars($data)) as $name) {
                $out[] = $name;
            }
        }

        return $out;
    }

    /**
     * @param array<string, SecurityScheme> $byName
     *
     * @return list<SecurityScheme>
     */
    private function orderSupported(array $byName): array
    {
        $names = array_keys($byName);
        sort($names, SORT_STRING);

        $out = [];

        foreach ($names as $name) {
            $scheme = $byName[$name];

            if ($scheme->isSupported()) {
                $out[] = $scheme;
            }
        }

        return $out;
    }
}
