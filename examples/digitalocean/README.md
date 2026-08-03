# paogen example — DigitalOcean API

The [DigitalOcean public API](https://docs.digitalocean.com/reference/api/)
OpenAPI 3.0 document — 722 schema components, hundreds of endpoints.

> **Status: expected failure.** Four components (`database_config`,
> `logsink_update`, `autoscale_pool`, `autoscale_pool_create`) carry a
> ref-only `oneOf`/`anyOf` `config` property with no `discriminator`;
> `attribute-and-phpdoc-driven-serialization` makes that a generator-time error
> ([T-030](../../truth/tasks/030-undiscriminated-oneof-generator-time-error.task-260420.typ)).
> `clear-example-expected-failures` checked all four branch-by-branch
> against the vendored schema and confirmed none admits an honest
> `Profile::$discriminators` entry — see `.expected-failure` for the
> full finding, including why skipping the four components instead
> does not clear this example either. No `generated/` tree is committed.

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

This currently exits non-zero — see `.expected-failure`. Once the four
discriminator components are resolved (upstream schema patch, or a
generator change that lets a skipped component's dependents be skipped
too), a successful run writes `./generated/`, byte-stable across
repeats (`profile-driven-generation`), and that run's diff commits the tree alongside
deleting the marker.

## Source of the schema

Downloaded from DigitalOcean's public CDN, which publishes a
pre-bundled copy without any external `$ref`s:

```
https://api-engineering.nyc3.cdn.digitaloceanspaces.com/spec-ci/DigitalOcean-public.v2.yaml
```

Refreshing the vendored file is a straight `curl -o` — no build step.

## Known limitations

T-025 (parameter/operationId normalisation) and T-026 (scalar and
top-level composition components) both closed in April 2026 and no
longer describe an open gap here.

What blocks this example today, found by `clear-example-expected-failures`:

- Four components carry an undiscriminated `oneOf`/`anyOf` `config`
  property (see `.expected-failure`). Each was checked branch-by-branch
  against the vendored schema; none shares a field name across every
  branch, so no `Profile::$discriminators` entry could be honest.
- Skipping those four components instead cascades into 8 dangling
  `class.notFound` PHPStan errors — the operations that still declare
  the skipped component as a parameter type cannot be skip-listed
  themselves without paogen calling the entry stale.
- Independently of the above, this schema declares two named `http
  bearer` security schemes (`bearer_auth`, `inference_bearer_auth`)
  that collapse onto the same fixed constructor argument name; every
  sub-client constructor call forwards it twice against a
  two-parameter signature (50 PHPStan `arguments.count` errors). A
  third, independent gap: `images_get`'s `image_id` path parameter is
  `anyOf: [integer, string]`, which resolves to `mixed` instead of
  tripping the "unsupported parameter shapes" abort, then fails
  PHPStan against `Endpoint::path()`'s stricter signature.
- `Profile::$skip` in `paogen.php` fully catalogues the twenty-one
  unrelated operation-level gaps this document already had (inline
  JSON request bodies with no `allOf` to merge, unsupported
  query/header parameter shapes, and the one `allOf` `required` name
  the vendor document itself never declares — see
  `merge-allof-members-into-one-model`) and is verified clean on its
  own — only the discriminator components above keep the marker in
  place.
