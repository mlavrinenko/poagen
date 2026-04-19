# paogen example — GitHub REST API

The full [GitHub REST API](https://docs.github.com/en/rest) OpenAPI
3.0.3 document — ~1000 endpoints, ~918 schema components, 8.8 MB of
YAML. This is the industry's "real client generator" torture test.

> **Status: expected-failure.** Generation aborts early. See
> [the limitation section below](#known-limitation--blocked-on-t-023)
> for the exact error and the tracking task.

## What this is meant to demonstrate

- paogen on a large production schema (8.8 MB, ~918 components,
  ~1000 endpoints).
- End-to-end usage once name-normalisation strategies (T-023) land.

## Files

```
github/
├── .expected-failure          — marker read by `just check-examples`
├── composer.json              — consumer-style project manifest
├── paogen.php                 — the Profile object paogen reads
└── schemas/
    └── api.github.com.yaml    — vendored bundled schema
```

No `generated/` directory is committed because generation aborts.

## Running it

From this directory:

```bash
composer install

# Needs a raised memory limit to parse the 8.8 MB schema:
php -d memory_limit=2G vendor/bin/paogen generate paogen.php
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

## Known limitation — blocked on T-023

818 of 918 schema components have kebab-case names (e.g.
`security-advisory-ecosystems`, `webhook-config-content-type`). Those
names are not valid PHP class identifiers, and every reference to
them from another component resolves to a string like
`\Acme\GitHub\Generated\Model\security-advisory-ecosystems`, which
`nette/php-generator` rejects.

Manually enumerating 818 renames in the Profile is not a credible
user experience, so we are waiting on
`truth/tasks/023-component-name-normalization.typ`. The plan there
is a pluggable strategy mechanism: a bundled `PascalCaseSanitiser`
handles the common case, `Profile::$renames` wins for explicit
overrides, and users can bring their own normaliser class.

Once that lands this example will select `PascalCaseSanitiser`, run
cleanly with an empty `renames` map, and commit `generated/`.
