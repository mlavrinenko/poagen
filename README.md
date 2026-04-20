<h1 align="center">paogen</h1>

<p align="center">
    <strong>OpenAPI-driven PHP client generator producing typed, extensible clients.</strong>
</p>

<p align="center">
    <em>⚠️ Pre-alpha. API and CLI are unstable. Not yet on Packagist.</em>
</p>

## About

paogen reads an OpenAPI 3.0.x schema and emits a PHP 8.4 HTTP client:

* **Typed** — exhaustive PHPStan annotations (`@var non-empty-string`, etc.)
* **Extensible** — your customisations live in a typed `Profile` and in
  attributes on your own value objects, never in the generated tree
  (see `truth/decisions/001-profile-driven-generation.typ`)
* **PSR-aligned** — generated runtime depends on
  [PSR-18](https://www.php-fig.org/psr/psr-18/) / PSR-17 / PSR-7,
  so you can plug in Guzzle, Symfony HTTP Client, etc.
* **Lean** — CLI has zero runtime deps on heavy frameworks

## Status

First consumable release (v0.1): OpenAPI 3.0 pipeline is correct,
type-safe, and pleasant on real schemas. The generator emits:

* **Models** — typed `readonly` classes for `components.schemas`, PHP 8.1
  backed enums for `enum`, synthesised classes for inline `type: object`
  properties, PHP union types for `oneOf` / `anyOf` (driven by
  `discriminator.propertyName`), merged models for `allOf`. Top-level
  composition components become marker interfaces their branches
  implement.
* **`ApiClient`** — one method per operation, typed path / query / header
  / cookie parameters, `application/json` and
  `application/x-www-form-urlencoded` request bodies. `multipart/form-data`
  and `application/octet-stream` methods are emitted with a `: never`
  return type that throws until a full story ships.
* **Security** — `apiKey` (header) and `http bearer` become required
  `ApiClient` constructor arguments; `http basic`, `oauth2`, and
  `openIdConnect` remain placeholders per
  [ADR-002](truth/decisions/002-no-inheritance-no-protected-regions.typ).
* **Errors** — non-2xx responses throw a generated
  `Generated\ApiException` with status code, request, response, and a
  best-effort decoded body narrowable via `instanceof` when an error
  schema is declared (see
  [ADR-009](truth/decisions/009-error-response-policy.typ)).
* **Runtime (de)serialisation** — a shared
  [`Marshaller`](src/Runtime/Marshal/Marshaller.php) /
  [`Hydrator`](src/Runtime/Marshal/Hydrator.php) pair drives every
  (de)serialisation via phpdoc types and a small set of runtime
  attributes (`#[WireName]`, `#[Discriminator]`, …). Model classes carry
  no generator boilerplate (see
  [ADR-010](truth/decisions/010-attribute-and-phpdoc-driven-serialization.typ)).

Specs and decisions live under [`truth/`](truth/); the release queue is
in [`ROADMAP.md`](ROADMAP.md) until the `0.1.0` tag.

Known limitation: OpenAPI **3.1** is not yet supported — see
[truth/notes/openapi-3.1-gap.md](truth/notes/openapi-3.1-gap.md) and
[ADR-008](truth/decisions/008-openapi-31-strategy.typ).

## Installation

Not on Packagist yet. Clone and install locally:

```bash
git clone https://github.com/mlavrinenko/paogen.git
cd paogen
composer install
```

## Usage

```bash
paogen generate path/to/paogen.php
paogen generate path/to/paogen.php --dry-run   # preview writes / deletes
paogen generate path/to/paogen.php --diff      # unified diff vs disk
paogen generate path/to/paogen.php --output=/tmp/out
paogen validate path/to/schema.yaml            # parse + validate only
```

Where `paogen.php` returns a typed `Profile` describing the schema, output
dir, namespace, and any user value objects to wire in.

See [`examples/`](examples/) for end-to-end demonstrations on real
schemas (Petstore passes; DigitalOcean and GitHub are scaffolded as
tracked follow-ups — see [ROADMAP.md](ROADMAP.md)). The example
profiles and committed `generated/` trees are the shortest path to
"what does paogen's output look like on *my* kind of schema?".

A minimal sample profile also lives at
[`tests/fixtures/profiles/petstore.php`](tests/fixtures/profiles/petstore.php).

## Development

```bash
# Pinned tooling via devbox + direnv (optional)
devbox shell

composer install
just check            # lint + test (release gate)
just check-examples   # exercise examples/*/ against the current generator
just format           # auto-fix code style
```

See [CONTRIBUTING.md](CONTRIBUTING.md).

## License

MIT © [Maxim Lavrinenko](mailto:maxim@lavrinenko.xyz). See [LICENSE](LICENSE).
