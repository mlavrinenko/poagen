# paogen example — GitHub REST API

The full [GitHub REST API](https://docs.github.com/en/rest) OpenAPI
3.0.3 document — ~1000 endpoints, ~918 schema components, 8.8 MB of
YAML. This is the industry's "real client generator" torture test.

> **Status: expected failure.** Eleven properties across ten components
> are `oneOf`/`anyOf` ref unions with no `discriminator`; ADR-010 makes
> that a generator-time error
> ([T-030](../../truth/tasks/030-undiscriminated-oneof-generator-time-error.task-260420.typ)).
> `clear-example-expected-failures` checked every one branch-by-branch
> against the vendored schema and confirmed none admits an honest
> `Profile::$discriminators` entry — see `.expected-failure` for the
> full finding, including why skipping the ten components instead does
> not clear this example either. No `generated/` tree is committed.

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

This currently exits non-zero — see `.expected-failure`. Once the ten
discriminator components are resolved (upstream schema patch, or a
generator change that lets a skipped component's dependents be skipped
too), a successful run writes `./generated/`, and that run's diff
commits the tree alongside deleting the marker.

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

T-025 (parameter/operationId normalisation) and T-026 (scalar and
top-level composition components) both closed in April 2026 and no
longer describe an open gap here.

What blocks this example today, found by `clear-example-expected-failures`:

- Ten components carry eleven undiscriminated `oneOf`/`anyOf`
  properties (see `.expected-failure`). Each was checked
  branch-by-branch against the vendored schema; none shares a field
  name across every branch, so no `Profile::$discriminators` entry
  could be honest.
- Skipping those ten components instead cascades into 231 dangling
  `class.notFound` PHPStan errors across unrelated models — this
  document is deeply cross-referential, and a skipped component's
  dependents are not skipped along with it.
- Independently of the above, a scalar-typed `anyOf`/`oneOf` path
  parameter resolves to `mixed` instead of tripping the
  "unsupported parameter shapes" abort, then fails PHPStan against
  `Endpoint::path()`'s stricter signature.
- `Profile::$skip` in `paogen.php` fully catalogues the forty-nine
  unrelated operation-level gaps this document already had (inline
  JSON request bodies, unsupported query-parameter shapes, non-JSON
  response content types) and is verified clean on its own — only the
  discriminator components above keep the marker in place.
