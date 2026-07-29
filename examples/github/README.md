# paogen example — GitHub REST API

The full [GitHub REST API](https://docs.github.com/en/rest) OpenAPI
3.0.3 document — ~1000 endpoints, ~918 schema components, 8.8 MB of
YAML. This is the industry's "real client generator" torture test.

> **Status: expected failure.** `integration.owner` (and others) is
> `oneOf: [$ref simple-user, $ref enterprise]` with no
> `discriminator`; ADR-010 makes that a generator-time error
> ([T-030](../../truth/tasks/030-undiscriminated-oneof-generator-time-error.task-260420.typ)).
> No `generated/` tree is committed — see `.expected-failure`.
> Clearing the marker and committing a tree is one step, done together.

## What this demonstrates

- paogen on a large production schema (8.8 MB, ~918 components,
  ~1000 endpoints).
- The default `nameNormaliser` pipeline (T-023) handling 818
  kebab-case component names automatically — no `renames` entries
  required. `security-advisory-ecosystems` becomes
  `SecurityAdvisoryEcosystems`, cross-refs updated, golden tree
  byte-stable across runs.

## Files

```
github/
├── composer.json              — consumer-style project manifest
├── paogen.php                 — the Profile object paogen reads
└── schemas/
    └── api.github.com.yaml    — vendored bundled schema
```

No `generated/` here — `.expected-failure` examples don't carry one
(see "Known limitations").

## Running it

From this directory:

```bash
composer install

# Needs a raised memory limit to parse the 8.8 MB schema:
php -d memory_limit=4G vendor/bin/paogen generate paogen.php
```

This currently exits non-zero — see `.expected-failure`. Once T-030 is
addressed here, a successful run writes `./generated/`, and that run's
diff commits the tree alongside deleting the marker.

## Source of the schema

Downloaded from the canonical
[`github/rest-api-description`](https://github.com/github/rest-api-description)
repository — the OpenAPI 3.0 variant, which is the one paogen
currently supports:

```
https://raw.githubusercontent.com/github/rest-api-description/main/descriptions/api.github.com/api.github.com.yaml
```

If you need to refresh the vendored file, a single `curl -o` is
enough — no bundling step required.

## Known limitations

Two follow-up tasks track gaps exposed by this fixture.

- [`truth/tasks/025-parameter-and-operation-name-normalisation.typ`](../../truth/tasks/025-parameter-and-operation-name-normalisation.typ)
  — some ops are skipped because their raw param names or
  operationId aren't valid PHP identifiers. T-025 normalises them
  while keeping the raw value on the wire.
- [`truth/tasks/026-scalar-and-composition-components.typ`](../../truth/tasks/026-scalar-and-composition-components.typ)
  — GitHub declares named scalar components and top-level
  composition components that the generator references but does
  not emit a file for. T-026 picks a strategy per shape.

Both describe gaps in the golden tree this example had before T-030
started refusing undiscriminated `oneOf`; they apply again once T-030
is resolved and a tree is committed.
