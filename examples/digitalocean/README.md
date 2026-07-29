# paogen example — DigitalOcean API

The [DigitalOcean public API](https://docs.digitalocean.com/reference/api/)
OpenAPI 3.0 document — 722 schema components, hundreds of endpoints.

> **Status: expected failure.** `database_config.config` (and others)
> is a ref-only `oneOf` with no `discriminator`; ADR-010 makes that a
> generator-time error
> ([T-030](../../truth/tasks/030-undiscriminated-oneof-generator-time-error.task-260420.typ)).
> No `generated/` tree is committed — see `.expected-failure`.
> Clearing the marker and committing a tree is one step, done together.

## What this demonstrates

- paogen on a mid-sized production schema (2.7 MB bundled YAML, 722
  schema components).
- The default `nameNormaliser` pipeline (T-023) handling kebab-case
  and snake_case component names out of the box: `app_alert`
  → `AppAlert`, `ssh_key_identifier` → `SshKeyIdentifier`. No
  `renames` entries are needed; the profile is three lines of
  config.

## Files

```
digitalocean/
├── composer.json              — consumer-style project manifest
├── paogen.php                 — the Profile object paogen reads
└── schemas/
    └── DigitalOcean-public.v2.yaml   — vendored bundled schema
```

No `generated/` here — `.expected-failure` examples don't carry one
(see "Known limitations").

## Running it

From this directory:

```bash
composer install
composer generate
```

This currently exits non-zero — see `.expected-failure`. Once T-030 is
addressed here, a successful run writes `./generated/`, byte-stable
across repeats (ADR-001), and that run's diff commits the tree
alongside deleting the marker.

## Source of the schema

Downloaded from DigitalOcean's public CDN, which publishes a
pre-bundled copy without any external `$ref`s:

```
https://api-engineering.nyc3.cdn.digitaloceanspaces.com/spec-ci/DigitalOcean-public.v2.yaml
```

Refreshing the vendored file is a straight `curl -o` — no build step.

## Known limitations

Two follow-up tasks track gaps exposed by this fixture.

- [`truth/tasks/025-parameter-and-operation-name-normalisation.typ`](../../truth/tasks/025-parameter-and-operation-name-normalisation.typ)
  — some ops are skipped because their raw param names
  (`Content-Type`) or operationId (`monitoring_get_…​.yml`) are not
  valid PHP identifiers. Today's output is missing those endpoints;
  T-025 brings them back by normalising the identifiers while keeping
  the raw names on the wire.
- [`truth/tasks/026-scalar-and-composition-components.typ`](../../truth/tasks/026-scalar-and-composition-components.typ)
  — DigitalOcean declares `urn`, `ssh_key_id`,
  `ssh_key_fingerprint`, and `floating_ip_create` as top-level
  scalar or top-level-composition components. The generator
  references them by class name without emitting a file, so
  downstream PHPStan flags dangling class references. T-026 picks a
  strategy per shape (probably `ScalarBinding`-style VOs + a union
  type for `oneOf`).

Both describe gaps in the golden tree this example had before T-030
started refusing undiscriminated `oneOf`; they apply again once T-030
is resolved and a tree is committed.
