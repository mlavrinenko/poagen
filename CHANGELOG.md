# mlavrinenko/paogen Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/)
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

Nothing yet.

## 0.1.0 - TBD

First consumable release. The OpenAPI 3.0 pipeline is correct, type-safe,
and pleasant on real schemas. OpenAPI 3.1 and mutation testing are
explicit post-v0.1 follow-ups (see
[`ROADMAP.md`](ROADMAP.md#post-v01-follow-ups-not-release-gating) and
[ADR-008](truth/decisions/008-openapi-31-strategy.typ)).

### Added

- `ScalarBinding` interface: user value objects annotated with
  `#[BindsFormat]` can round-trip as bare scalars on the wire via
  `toScalar()` / `fromScalar()` on both send and receive paths (T-004).
- Built-in `\DateTimeImmutable` mapping for `format: date-time` and
  `format: date` — no user binding required (T-010).
- OpenAPI `enum` components emit as PHP 8.1 backed enums under
  `Generated/Enum/` and replace their references in model properties
  (T-009).
- Inline nested `type: object` properties synthesise a typed class per
  occurrence (e.g. `Pet.shipping` → `Generated/Model/PetShipping`)
  instead of collapsing to `array<string, mixed>`. Inline objects whose
  `additionalProperties` is a scalar become typed maps (T-013).
- `oneOf` / `anyOf` of `$ref` components emit as PHP 8.0 union types;
  hydrator picks the right class by `discriminator.propertyName` when
  declared, falling back to structural match. `allOf` of object schemas
  merges into a single model with the union of properties (T-008).
- Non-2xx responses throw a generated-per-profile
  `Generated\ApiException extends \RuntimeException`, exposing
  `getStatusCode()`, `getRequest()`, `getResponse()`, and a cached
  best-effort `getDecodedBody(): mixed`. Consumer code can narrow the
  decoded body via `instanceof` when an error schema is declared
  (T-012, ADR-009 accepted).
- `securitySchemes` for `apiKey` (header) and `http bearer` surface as
  required constructor arguments on the generated `ApiClient`; every
  secured operation attaches the scheme's header. `http basic`,
  `oauth2`, and `openIdConnect` remain `draft` placeholders per
  ADR-002 (T-014).
- `application/x-www-form-urlencoded` request bodies expand to one
  typed method parameter per declared property; the request body is
  assembled via `http_build_query` in RFC1738 form (T-011).
- `multipart/form-data` and `application/octet-stream` request bodies
  no longer silently skip the operation. The method is emitted with a
  `: never` return type and throws a `RuntimeException` carrying the
  operationId and unsupported content type (T-011).
- `paogen generate <profile>` grows three DX flags (T-019):
  - `--output=<dir>` redirects the generated tree to an alternative
    directory without editing the profile.
  - `--dry-run` prints a tree-shaped summary of would-be-written and
    would-be-pruned files, writes nothing.
  - `--diff` prints a unified diff (via `sebastian/diff`) for every
    would-be-written file against the copy on disk; exits 1 when any
    diff is non-empty.
- `paogen validate <schema>` subcommand: parses a YAML or JSON OpenAPI
  document, runs `OpenApi::validate()`, and reports parse / validation
  / usage errors on stderr (ADR-006).
- Generator prunes stale `.php` files under `Generated/` at the end of
  every run so the byte-stability promise holds on component
  rename / removal (T-007).
- Generated models publish `public const array PROPERTY_MAP` and
  implement `\JsonSerializable` per ADR-007. The map pairs each PHP
  property name with `[wireKey, shape]` where `shape` distinguishes
  scalar, `\FQCN::class`, `['list', null|\FQCN]`, `['scalar', \FQCN]`,
  `['datetime', null]`, `['date', null]`, `['enum', \FQCN]`, and
  `['union', [\FQCN, …], ?discriminator]`.
- Integration test `tests/Integration/ByteStabilityTest` runs the
  generator twice against the Petstore profile and asserts every file
  is byte-for-byte identical between runs and against the committed
  golden tree (T-022).

### Changed

- `composer.json` `minimum-stability` is `stable`; all deps are already
  stable releases so this only tightens the invariant for downstream
  users.
- CLI version string resolves from `Composer\InstalledVersions` so
  Packagist installs report the tagged release and in-repo runs report
  `dev-<branch>`; the `dev` fallback is regression-tested.
- PHP 8.4 deprecation noise from `cebe/php-openapi` is silenced via a
  `cweagans/composer-patches` patch (`patches/cebe-php-openapi-php84-nullable.patch`)
  that adds explicit nullable types to the affected signatures. The
  ad-hoc `error_reporting` masks in the test harness and CLI entry
  point were dropped (T-016).

### Removed

- Dropped the unused `infection/infection` dev dependency. Mutation
  testing moved to the post-v0.1 follow-up list (T-021 retired).
- Dropped codecov integration entirely. It was wired without a
  threshold and implied a gate that did not exist; the `code-coverage`
  CI job, `codecov.yml`, and `.gitattributes` export-ignore entry were
  removed. `composer test:coverage` and `just test-coverage` stay for
  local use (T-020, ADR-004 updated).

### Fixed

- Hydrator no longer silently half-populates Models whose schema keys
  aren't valid PHP identifiers (e.g. kebab-case `display-name`). The
  generated `ApiClient::hydrate()` consults `PROPERTY_MAP` to translate
  wire keys → PHP property names (part of ADR-007).
- Hydrator recurses into `list<Model>` properties via the shape
  directive in `PROPERTY_MAP`, producing real lists of typed objects
  instead of raw associative arrays (part of ADR-007).
