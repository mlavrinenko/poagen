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
* **Extensible** — a split-file pattern lets you override behavior without
  editing any generated file (see [docs/design/extensibility.md](docs/design/extensibility.md))
* **PSR-aligned** — generated runtime depends on
  [PSR-18](https://www.php-fig.org/psr/psr-18/) / PSR-17 / PSR-7,
  so you can plug in Guzzle, Symfony HTTP Client, etc.
* **Lean** — CLI has zero runtime deps on heavy frameworks

## Status

Scaffolded. Generator not yet implemented. Design notes live under
[`docs/design/`](docs/design/).

Known limitation: OpenAPI **3.1** is not yet supported — see
[docs/design/openapi-3.1-gap.md](docs/design/openapi-3.1-gap.md).

## Installation

Not on Packagist yet. Clone and install locally:

```bash
git clone https://github.com/mlavrinenko/paogen.git
cd paogen
composer install
```

## Usage (planned)

```bash
paogen generate path/to/openapi.yaml \
    --output=./generated \
    --namespace="App\\Api\\Github"
```

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
