<h1 align="center">poagen</h1>

<p align="center">
    <strong>OpenAPI-driven PHP client generator producing typed, extensible clients.</strong>
</p>

<p align="center">
    <em>⚠️ Pre-alpha. API and CLI are unstable. Not yet on Packagist.</em>
</p>

## About

poagen reads an OpenAPI 3.0 or 3.1 schema and emits a PHP 8.4 HTTP client:

* **Typed** — exhaustive PHPStan annotations (`@var non-empty-string`, etc.)
* **Extensible** — your customisations live in a typed `Profile` and in
  attributes on your own value objects, never in the generated tree
  (see `truth/decisions/profile-driven-generation.decision-260418.typ`)
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
  [`no-inheritance-no-protected-regions`](truth/decisions/no-inheritance-no-protected-regions.decision-260418.typ).
* **Responses** — every operation returns an
  [`Envelope`](runtime/src/Contract/Envelope.php) carrying the HTTP status
  the wire sent (`->status`), the body hydrated into the shape the document
  declared for that status (`->body`), and the PSR-7 response that carried
  both (`->response`). A status the document describes — 2xx or not — is a
  return value, never a throw; a generated `Generated\ApiException` is
  raised only for the two cases an envelope cannot honestly represent: a
  status the document declared no exact, range or `default` response for,
  or a declared body that failed to hydrate (see
  [`envelope-supersedes-error-response-policy`](truth/decisions/envelope-supersedes-error-response-policy.decision-260804.typ),
  which supersedes `error-response-policy`).
* **Runtime transport** — an emitted operation is one call: it describes
  its request as an
  [`Endpoint`](runtime/src/Contract/Endpoint.php), names the shape it
  expects back as a
  [`ResponseType`](runtime/src/Contract/ResponseType.php), and hands both
  to the injected
  [`TransportInterface`](runtime/src/Contract/TransportInterface.php).
  A client takes that transport plus whatever credentials the schema
  declares, and nothing else.
* **Runtime (de)serialisation** — a shared
  [`Marshaller`](runtime/src/Marshal/Marshaller.php) /
  [`Hydrator`](runtime/src/Marshal/Hydrator.php) pair drives every
  (de)serialisation via phpdoc types and a small set of runtime
  attributes (`#[WireName]`, `#[Discriminator]`, …). Model classes carry
  no generator boilerplate (see
  [`attribute-and-phpdoc-driven-serialization`](truth/decisions/attribute-and-phpdoc-driven-serialization.decision-260420.typ)).
* **Replaceable** — every runtime collaborator a generated file names is
  an interface under
  [`runtime/src/Contract/`](runtime/src/Contract/), and the emitted
  type-hints point at those rather than at implementations. Supply your
  own hydrator, marshaller, XML writer, descriptor parser or error policy —
  or your own transport for all of it — without editing a generated file.

Specs and decisions live under [`truth/`](truth/); the release queue is
in [`ROADMAP.md`](ROADMAP.md) until the `0.1.0` tag.

OpenAPI **3.1** is supported, parsed through
[`devizzent/cebe-php-openapi`](https://github.com/DEVizzent/cebe-php-openapi) —
see
[`openapi-31-through-a-maintained-parser`](truth/decisions/openapi-31-through-a-maintained-parser.decision-260729.typ),
which supersedes the earlier `openapi-31-strategy` decision. A handful of
JSON Schema 2020-12 keywords have no emitter yet and stop the run by name
rather than being silently dropped or misread: `const`, `prefixItems`,
`unevaluatedProperties`, `contentMediaType`. A 3.1 `webhooks` entry is
refused the same way — it describes a call the vendor makes to the consumer,
the opposite direction from every client poagen emits — unless named in
`Profile::$skip`, which generates the `paths` half of the document alone.

## Installation

Not on Packagist yet. Clone and install locally:

```bash
git clone https://github.com/mlavrinenko/poagen.git
cd poagen
composer install
```

## Usage

```bash
poagen generate path/to/poagen.php
poagen generate path/to/poagen.php --dry-run   # preview writes / deletes
poagen generate path/to/poagen.php --diff      # unified diff vs disk
poagen generate path/to/poagen.php --output=/tmp/out
poagen validate path/to/schema.yaml            # parse + validate only
```

Where `poagen.php` returns a typed `Profile` describing the schema, output
dir, namespace, and any user value objects to wire in.

See [`examples/`](examples/) for end-to-end demonstrations on real
schemas (Petstore passes; DigitalOcean and GitHub are scaffolded as
tracked follow-ups — see [ROADMAP.md](ROADMAP.md)). The example
profiles and committed `generated/` trees are the shortest path to
"what does poagen's output look like on *my* kind of schema?".

A minimal sample profile also lives at
[`tests/fixtures/profiles/petstore.php`](tests/fixtures/profiles/petstore.php).

## Development

```bash
# Pinned tooling via devbox + direnv (optional)
devbox shell

composer install
just check            # lint + test + check-specs (release gate)
just check-examples   # exercise examples/*/ against the current generator
just format           # auto-fix code style
```

See [CONTRIBUTING.md](CONTRIBUTING.md).

## License

MIT © [Maxim Lavrinenko](mailto:maxim@lavrinenko.xyz). See [LICENSE](LICENSE).
