#import "@local/mindtape:0.2.0": *

#show: task.with(
  id: "350bca08-9dc2-4c71-bdb6-a5f1c6c18b1b",
  title: "Named scalar + top-level composition components resolve to real PHP types",
  status: done(2026, 4, 19),
  priority: 7,
  x-paogen: (spec: "truth/specs/model-generator.typ", legacy-id: "T-026"),
)

== Summary

Today `Generator::emitModels()` only emits a PHP class for a component
whose effective schema is `type: object`. Real APIs use two other
shapes at the top level of `components.schemas`:

- *Scalar components* — `type: string` with `format: uuid`, `type:
  integer` etc. DigitalOcean ships `urn`, `ssh_key_id`,
  `ssh_key_fingerprint`, `image_name` as top-level scalars that are
  then `$ref`-d from other models as if they were classes.
- *Top-level composition* — `oneOf` / `anyOf` /
  `allOf` at the root (no `type: object`), like DigitalOcean's
  `floating_ip_create` which is `oneOf: [<inline object>, <inline
  object>]`.

Both are referenced by other components as class types; today those
references resolve to `\Acme\...\Model\Urn` or
`\Acme\...\Model\FloatingIpCreate` — class names for which no file
exists, so PHPStan on the consumer's side flags every reference as
`class.notFound`.

== Rationale

Surfaced while closing T-023 for the `examples/digitalocean` and
`examples/github` validation-tier fixtures. Both schemas compile
cleanly now, but the generated trees are not PHPStan-clean under
`phpstan-generated.neon` because of the missing classes. ~234 errors
on DigitalOcean trace back here.

== In scope

+ Decide a strategy per shape and spec it. Candidates:
  - *Scalar component* → emit a tiny `ScalarBinding`-style VO
    (`public readonly string $value` + `toScalar()` + `from()`).
    Downstream refs type as `\Model\Urn`; hydrator rehydrates via
    `from()`. Already aligns with ADR-007.
  - *Top-level `oneOf` / `anyOf`* → emit a PHP union type or a
    discriminator-backed synthetic class. The existing
    `CompositionResolver` already handles composition inside
    model properties; extend it to emit/name a top-level component.
  - *Top-level `allOf`* → already handled via
    `CompositionResolver::flattenAllOf`; make sure an `allOf` whose
    branches are scalars (rare) maps sensibly too.
+ Add scenarios that lock each shape, end-to-end, against a new
  small fixture (or extend the T-023 `naming` fixture).
+ Regenerate the DigitalOcean and GitHub example golden trees;
  re-run `phpstan analyse -c phpstan-generated.neon
  examples/digitalocean/generated examples/github/generated` and
  confirm zero errors tracing back to this task.

== Non-goals

- `not`, recursive composition, and discriminator-mapping inversion
  — already called out as out of scope in T-008 and carried forward.
- Scalar components with `enum: [...]` — those are already emitted
  as backed enums by T-009 and EnumCatalog.

== Acceptance criteria

- New Model Generator scenario(s) for scalar components and
  top-level composition components. Each has a locked trace to the
  code that emits it.
- A fixture under `tests/fixtures/schemas/` exercising both shapes.
- `examples/digitalocean/generated` and `examples/github/generated`
  pass `phpstan analyse -c phpstan-generated.neon` with zero errors
  traceable to this task (other T-025-style skips are fine).
- `just check-examples` still passes.
- `just check` green end-to-end.
