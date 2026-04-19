<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\OpenApi;
use cebe\openapi\spec\Operation;
use cebe\openapi\spec\Reference;
use cebe\openapi\spec\SecurityRequirement;
use cebe\openapi\spec\SecurityRequirements;
use cebe\openapi\spec\SecurityScheme as CebeSecurityScheme;

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
        $this->byName = $this->collectSchemes($openApi);
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
        // Absent `security` on an Operation means "inherit the global".
        // Cebe presents `$operation->security` as `null` in that case
        // (per attributeDefaults); distinguishing "absent" from "empty
        // list" therefore needs an instance check, not count-by-length.
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
            if (!\is_string($name)) {
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

    private function resolveScheme(Reference|CebeSecurityScheme $scheme): ?CebeSecurityScheme
    {
        if ($scheme instanceof CebeSecurityScheme) {
            return $scheme;
        }

        $resolved = $scheme->resolve();

        return $resolved instanceof CebeSecurityScheme ? $resolved : null;
    }

    /**
     * Cebe declares `$openApi->security` / `$operation->security` in its
     * docblock as `SecurityRequirement[]` even though the runtime value is
     * a `SecurityRequirements` instance (or `null` on an absent Operation
     * override). Accept the docblock type, then narrow via `instanceof`.
     *
     * @param array<SecurityRequirement>|SecurityRequirements|null $security
     *
     * @return list<string>
     */
    private function namesFromMagicProperty(
        array|SecurityRequirements|null $security,
    ): array {
        if (!$security instanceof SecurityRequirements) {
            return [];
        }

        /** @var array<string, SecurityRequirement>|null $raw */
        $raw = $security->getRequirements();

        if ($raw === null) {
            return [];
        }

        $out = [];

        foreach (array_keys($raw) as $name) {
            if (\is_string($name)) {
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
        sort($names, \SORT_STRING);

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
