<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator\Emit;

use cebe\openapi\spec\OpenApi;
use cebe\openapi\spec\Operation;
use cebe\openapi\spec\Reference;
use cebe\openapi\spec\SecurityScheme as CebeSecurityScheme;

use function is_string;

use const SORT_STRING;

/**
 * One-shot lookup over `components.securitySchemes` plus the resolution
 * rules that govern which schemes apply to a given operation.
 *
 * We follow the same "`$ref`-resolves-at-the-boundary" pattern as
 * {@see ParameterCollector}: unresolvable references are ignored (the
 * scheme is simply not registered) rather than surfacing an error — which
 * then shows up as an undeclared requirement if anything asked for it,
 * so the fact still reaches the consumer.
 *
 * Classification lives in {@see SecuritySchemeClassifier}, requirement
 * parsing in {@see SecurityRequirements}, and the who-requires-what index
 * in {@see SecurityUsage}. What is left here is the document-wide view the
 * emitters ask questions of.
 *
 * @internal
 */
final readonly class SecuritySchemeCatalog
{
    /** @var array<string, SecurityScheme> */
    private array $byName;

    /** @var array<string, list<string>> */
    private array $globalRequirements;

    /** @var list<SecurityScheme> */
    private array $wiredInEmissionOrder;

    private SecurityUsage $usage;

    public function __construct(OpenApi $openApi)
    {
        $this->byName = $this->disambiguateCtorArgs($this->collectSchemes($openApi));
        $this->globalRequirements = SecurityRequirements::read($openApi->security);
        $this->wiredInEmissionOrder = $this->orderWired($this->byName);
        $this->usage = SecurityUsage::scan($openApi);
    }

    /**
     * The wired schemes present in the schema, in constructor-arg emission
     * order (by scheme name, ascending). Drives the client constructor's
     * promoted-parameter list.
     *
     * @return list<SecurityScheme>
     */
    public function constructorSchemes(): array
    {
        return $this->wiredInEmissionOrder;
    }

    /**
     * The schemes applied to one operation, after resolving operation-level
     * overrides against the global default. Only wired schemes come back,
     * so the emitter can iterate the list blindly: a reported or refused
     * scheme has already been accounted for by {@see SecurityAudit} before
     * a plan is allowed to return.
     *
     * An operation-level `security: []` disables auth entirely and is
     * honoured here — the returned list is empty even if the global
     * requirement named a wired scheme.
     *
     * @return list<SecurityScheme>
     */
    public function activeSchemesFor(Operation $operation): array
    {
        $out = [];

        foreach (array_keys($this->requirementsFor($operation)) as $name) {
            $scheme = $this->byName[$name] ?? null;

            if ($scheme instanceof SecurityScheme && $scheme->isWired()) {
                $out[] = $scheme;
            }
        }

        return $out;
    }

    /**
     * One operation's requirements as the document states them: scheme name
     * → the scopes that requirement asks for.
     *
     * @return array<string, list<string>>
     */
    public function requirementsFor(Operation $operation): array
    {
        return SecurityRequirements::forOperation($operation, $this->globalRequirements);
    }

    public function scheme(string $name): ?SecurityScheme
    {
        return $this->byName[$name] ?? null;
    }

    public function usage(): SecurityUsage
    {
        return $this->usage;
    }

    /**
     * Every declared scheme some requirement actually names, in the same
     * ascending-name order the constructor uses. An unused declaration is
     * left out on purpose — see {@see SecurityUsage}.
     *
     * @return list<SecurityScheme>
     */
    public function requiredSchemes(): array
    {
        $names = array_keys($this->byName);
        sort($names, SORT_STRING);

        $out = [];

        foreach ($names as $name) {
            if ($this->usage->isRequired($name)) {
                $out[] = $this->byName[$name];
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

            $out[$name] = SecuritySchemeClassifier::classify($name, $resolved);
        }

        return $out;
    }

    /**
     * A scheme's default ctorArg is fixed per kind — `bearerToken` for every
     * http bearer scheme, `basicUser`/`basicPassword` for every http basic
     * one — so two schemes of the same kind collide unless something breaks
     * the tie. DigitalOcean's document is the case that forced this:
     * `bearer_auth` and `inference_bearer_auth` are both http bearer, and
     * per the document's own description are two genuinely different
     * credentials (an OAuth token and a separate Inference API key), not one
     * credential declared twice. See
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
            if ($scheme->isWired()) {
                $counts[$scheme->ctorArg] = ($counts[$scheme->ctorArg] ?? 0) + 1;
            }
        }

        $out = [];

        foreach ($byName as $name => $scheme) {
            $collides = $scheme->isWired() && ($counts[$scheme->ctorArg] ?? 0) > 1;
            $out[$name] = $collides ? $scheme->withCtorArgBase(SecurityScheme::camelize($name)) : $scheme;
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
     * @param array<string, SecurityScheme> $byName
     *
     * @return list<SecurityScheme>
     */
    private function orderWired(array $byName): array
    {
        $names = array_keys($byName);
        sort($names, SORT_STRING);

        $out = [];

        foreach ($names as $name) {
            $scheme = $byName[$name];

            if ($scheme->isWired()) {
                $out[] = $scheme;
            }
        }

        return $out;
    }
}
