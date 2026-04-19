# paogen example — GitHub REST API

The full [GitHub REST API](https://docs.github.com/en/rest) OpenAPI
3.0.3 document — ~1000 endpoints, ~918 schema components, 8.8 MB of
YAML. This is the industry's "real client generator" torture test.

> **Status: generates successfully.** The `generated/` tree is
> committed. Some ops are skipped and the output still has PHPStan
> warnings tracked by [T-025](../../truth/tasks/025-parameter-and-operation-name-normalisation.typ)
> and [T-026](../../truth/tasks/026-scalar-and-composition-components.typ).

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
├── schemas/
│   └── api.github.com.yaml    — vendored bundled schema
└── generated/
    └── Generated/             — committed golden tree (~2250 files)
```

## Running it

From this directory:

```bash
composer install

# Needs a raised memory limit to parse the 8.8 MB schema:
php -d memory_limit=4G vendor/bin/paogen generate paogen.php
```

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

Both tasks block this example from being fully PHPStan-clean under
`phpstan-generated.neon`; neither blocks the schema from generating.
