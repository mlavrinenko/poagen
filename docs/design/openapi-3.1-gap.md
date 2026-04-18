# OpenAPI 3.1 Support Gap

**Status:** known limitation  
**Date:** 2026-04-17

## Context

paogen uses [`cebe/php-openapi`](https://github.com/cebe/php-openapi) to parse
OpenAPI documents. As of cebe/php-openapi 1.7.x, the parser targets **OpenAPI
3.0.x**. Several OpenAPI 3.1 features are not handled natively:

* JSON Schema 2020-12 keywords (`$defs`, `$anchor`, `prefixItems`, `const`,
  dependent schemas, unevaluatedProperties, etc.)
* `type` as an array (`"type": ["string", "null"]`) — 3.1 replaces `nullable: true`
* Webhooks top-level object
* Full `examples` semantics
* New `null` as a first-class type

## Current Scope

paogen supports **OpenAPI 3.0.x only**. Feeding it a 3.1 document will
(optimistically) work for the subset that overlaps with 3.0 and fail or produce
incorrect output where it diverges.

## Workarounds for Users

1. **Convert 3.1 → 3.0** with an external tool before feeding to paogen.
   [`swagger-cli`](https://www.npmjs.com/package/swagger-cli) does not help
   here; `redocly lint --skip-rule` or `openapi-to-openapi-3` variants exist.
2. **Avoid 3.1-only features** in your schema (prefer `nullable: true`, don't
   rely on `prefixItems`, etc.).

## Path Forward

When 3.1 support becomes a priority, the realistic options are:

1. **Swap parser to** `devizzent/cebe-php-openapi` (a fork with partial 3.1
   support) or `league/openapi-psr7-validator`'s dependency chain.
2. **Supplement** cebe's object model with a 3.1-aware JSON Schema validator
   (e.g. `opis/json-schema` 2.x) for the schema subset.
3. **Write a thin 3.1 → internal-IR translator** that sits between cebe and
   the generator, normalizing 3.1 differences to paogen's IR.

Option 3 is the most forward-compatible — it keeps cebe as a low-level parser
and decouples the generator from whatever replaces it later.

## Tracking

The v0.1 release explicitly **defers** OpenAPI 3.1 support — see
[`truth/decisions/008-openapi-31-strategy.typ`](../../truth/decisions/008-openapi-31-strategy.typ)
(ADR-008, *accepted*). The three paths forward (parser swap, translator
shim, fork) are catalogued there; this document stays as the user-facing
"known limitation" note and the option analysis that feeds the
post-v0.1 ADR that will supersede ADR-008 when 3.1 becomes a priority.

Post-v0.1 workflow:

1. Re-open with a prototype under a new task (`017` or later) that
   picks one of options 1/2/3 below, gathers fixture evidence, and
   proposes a superseding ADR.
2. Supersede ADR-008 with the chosen path.
3. Remove this limitation note from `README.md`.
