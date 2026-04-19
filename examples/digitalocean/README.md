# paogen example — DigitalOcean API

The [DigitalOcean public API](https://docs.digitalocean.com/reference/api/)
OpenAPI 3.0 document — 722 schema components, hundreds of endpoints.

> **Status: expected-failure.** The generator aborts part-way through.
> See [the limitation section below](#known-limitation--blocked-on-t-023)
> for the exact error and the tracking task.

## What this is meant to demonstrate

- paogen on a mid-sized production schema (2.7 MB bundled YAML).
- The `renames` escape hatch in Profile — DigitalOcean uses two
  component names that aren't valid PHP identifiers (`version-2`,
  `urn-2`), and a user would reach for `renames` to resolve them.

## Files

```
digitalocean/
├── .expected-failure          — marker read by `just check-examples`
├── composer.json              — consumer-style project manifest
├── paogen.php                 — the Profile object paogen reads
└── schemas/
    └── DigitalOcean-public.v2.yaml   — vendored bundled schema
```

No `generated/` directory is committed because generation aborts.

## Running it

From this directory:

```bash
composer install
composer generate
```

You will currently see:

```
Fatal error: Uncaught Nette\InvalidArgumentException:
  Value '\Acme\DigitalOcean\Generated\Model\urn-2' is not valid type.
  at vendor/nette/php-generator/src/PhpGenerator/Helpers.php:146
```

## Source of the schema

Downloaded from DigitalOcean's public CDN, which publishes a
pre-bundled copy without any external `$ref`s:

```
https://api-engineering.nyc3.cdn.digitaloceanspaces.com/spec-ci/DigitalOcean-public.v2.yaml
```

Refreshing the vendored file is a straight `curl -o` — no build step.

## Known limitation — blocked on T-023

DigitalOcean has 2 of 722 schema components whose raw names are not
legal PHP identifiers: `version-2`, `urn-2`. paogen's documented
workaround, `Profile::$renames`, *partially* applies — the top-level
class for the renamed component is emitted correctly, but every
other component that `$ref`s it still resolves against the raw name
and the run aborts inside `nette/php-generator`.

The fix (tracked in `truth/tasks/023-component-name-normalization.typ`)
introduces pluggable name-normalisation strategies:

- Explicit `renames` entry, if any, wins.
- Otherwise run the Profile-configured strategy (default: `Raw`, with
  a bundled `PascalCaseSanitiser` opt-in and user-supplied strategies
  accepted).

When T-023 lands, the Profile in this example either keeps its
two-entry `renames` (under the default `Raw` strategy) or drops them
entirely (under `PascalCaseSanitiser`). Either path produces a clean
end-to-end run and the `generated/` tree is committed.
