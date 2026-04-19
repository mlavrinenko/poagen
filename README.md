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

Pre-alpha. Generator emits *models only* (PoC). Specs and decisions live
under [`truth/`](truth/).

Known limitation: OpenAPI **3.1** is not yet supported — see
[docs/design/openapi-3.1-gap.md](docs/design/openapi-3.1-gap.md) and
[ADR-008](truth/decisions/008-openapi-31-strategy.typ).

## Installation

Not on Packagist yet. Clone and install locally:

```bash
git clone https://github.com/mlavrinenko/paogen.git
cd paogen
composer install
```

## Usage (planned)

```bash
paogen generate path/to/paogen.php
```

Where `paogen.php` returns a typed `Profile` describing the schema, output
dir, namespace, and any user value objects to wire in. Example profiles
under [`tests/fixtures/profiles/`](tests/fixtures/profiles/).

## Development

```bash
# Pinned tooling via devbox + direnv (optional)
devbox shell

composer install
just check     # lint + test
just format    # auto-fix code style
```

See [CONTRIBUTING.md](CONTRIBUTING.md).

## License

MIT © [Maxim Lavrinenko](mailto:maxim@lavrinenko.xyz). See [LICENSE](LICENSE).
