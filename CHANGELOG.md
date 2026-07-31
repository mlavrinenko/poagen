# mlavrinenko/paogen Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/)
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added

- Every emitted file opens with a comment naming itself as generated, naming
  the profile it came from, and printing the `paogen generate <profile>` that
  reproduces it. The header carries no timestamp, no version and no absolute
  path, so a re-run over unchanged inputs is still an empty diff. Emitted files
  are deliberately *not* made read-only — see
  [the decision](truth/decisions/a-header-not-a-chmod.decision-260731.typ) for
  why a permission bit that no clone preserves is not the mechanism to reach
  for.
- `Profile::$source` names the profile in that header. `ProfileLoader` fills it
  with the path the run was given, relative to the working directory; a profile
  built in code keeps the conventional `paogen.php` unless it says otherwise.

## 0.1.0 - TBD

First consumable release. The OpenAPI 3.0 pipeline is correct, type-safe,
and pleasant on real schemas. OpenAPI 3.1 and mutation testing are
explicit post-v0.1 follow-ups (see
[`ROADMAP.md`](ROADMAP.md#post-v01-follow-ups-not-release-gating) and
[ADR-008](truth/decisions/008-openapi-31-strategy.typ)).

### Added

#### Type coverage

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
- `oneOf` / `anyOf` of `$ref` components emit as PHP union types;
  `discriminator.propertyName` selects the branch at hydration time.
  `allOf` of object schemas merges into a single model with the union
  of properties (T-008).
- Named scalar, array, and top-level `oneOf` / `anyOf` components now
  resolve to real PHP types rather than collapsing to `mixed`: scalars
  emit a generated `ScalarBinding` value object, `type: array`
  components emit a typed wrapper, and top-level composition components
  emit a marker interface that inline-branch synths and `$ref`-branch
  models `implements`. Backed by a new `ComponentCatalog` that
  classifies every `components.schemas` entry once and feeds both the
  emitter and the parameter layer (T-026).

#### Runtime (de)serialisation

- New `Marshaller` / `Hydrator` pair under `src/Runtime/Marshal/`
  drives every (de)serialisation via phpdoc types plus a small set of
  runtime attributes (`#[WireName]`, `#[Discriminator]`,
  `#[AdditionalProperties]`, `#[Deprecated]`, `#[Format]`, `#[Schema]`).
  Generated `Model\*` classes are now plain `readonly` classes with
  promoted constructors and authoritative phpdoc — no `PROPERTY_MAP`
  const, no `JsonSerializable`, no hand-rolled hydration. `ApiClient`
  delegates to the shared runtime. Powered by `phpstan/phpdoc-parser`
  (added as a runtime dependency); see
  [ADR-010](truth/decisions/010-attribute-and-phpdoc-driven-serialization.typ)
  (T-028, supersedes the ADR-007 representation layer).
- Marshaller/Hydrator falls back to a `token_get_all` phpdoc scan when
  `ReflectionClass::getDocComment()` returns `false` — keeps the
  runtime correct under `opcache.save_comments=0` (T-029).
- Kebab-case and other non-identifier wire keys are handled via
  `#[WireName]`; `list<Model>` properties hydrate into real typed
  lists (both previously worked via `PROPERTY_MAP` in the pre-release
  scaffolding, now driven by the new runtime).

#### Error / security / body handling

- Non-2xx responses throw a generated-per-profile
  `Generated\ApiException extends \RuntimeException`, exposing
  `getStatusCode()`, `getRequest()`, `getResponse()`, and a cached
  best-effort `getDecodedBody(): mixed`. Consumer code can narrow the
  decoded body via `instanceof` when an error schema is declared
  (T-012, [ADR-009](truth/decisions/009-error-response-policy.typ)
  accepted).
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
- `oneOf` / `anyOf` of `$ref` branches without a `discriminator` now
  abort the generator with a pointed
  `UndiscriminatedUnionException`, naming the component and property
  and pointing at `Profile::$discriminators['Component.property' =>
  '<wireField>']` as the per-schema override. Hydration is
  discriminator-only; structural fallback is gone (T-030).
- `ClientEmitter` routes scalar-VO / `ScalarBinding` (and matching
  `oneOf` / `anyOf`) path parameters through `toScalar()` via a new
  `ParameterStringExpr` helper that consults `ComponentCatalog`, so
  generated path construction no longer `(string)`-casts value objects
  (T-031).

#### Name normalisation

- Pluggable OpenAPI → PHP name-normalisation pipeline. Users compose
  strategies in their `Profile` (see
  [ADR-003](truth/decisions/003-profile-and-attribute-dx.typ)); the
  default pipeline (`RenamesNormaliser` → `PascalCaseSanitiser`)
  handles every DigitalOcean and GitHub component name without
  per-schema tweaks (T-023).
- `operationId` and parameter names are normalised the same way
  (`CamelCaseSanitiser` for methods / parameters) via the
  `SymbolKind` registry. `ResolvedParameter` keeps the raw wire key
  alongside the sanitised PHP identifier. Residual skips surface on
  stderr via `GenerationPlan::$skippedOperations` rather than silent
  drops (T-025).

#### DX

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
  / usage errors on stderr (T-018, ADR-006).
- Generator prunes stale `.php` files under `Generated/` at the end of
  every run so the byte-stability promise holds on component
  rename / removal (T-007).

#### Examples & tests

- `examples/` tree with `petstore`, `digitalocean`, and `github`
  end-to-end profiles, each with a committed `generated/` golden tree
  and a `README` walking through the pipeline. A new `just
  check-examples` recipe runs the generator against every example.
  DigitalOcean and GitHub currently carry an `.expected-failure`
  marker pointing at per-schema discriminator overrides
  (post-v0.1 follow-up); Petstore is green end-to-end (T-024).
- Integration test `tests/Integration/ByteStabilityTest` runs the
  generator twice against the Petstore profile and asserts every file
  is byte-for-byte identical between runs and against the committed
  golden tree (T-022).

### Changed

- ADR-007 ("Hydration & Serialization") representation section is
  superseded by ADR-010. Truth-tree specs and decisions referencing
  the pre-release `PROPERTY_MAP` + `JsonSerializable` shape were
  refreshed; no code changes landed with this audit (T-027).
- `composer.json` `minimum-stability` is `stable`; all deps are already
  stable releases so this only tightens the invariant for downstream
  users.
- CLI version string resolves from `Composer\InstalledVersions` so
  Packagist installs report the tagged release and in-repo runs report
  `dev-<branch>`; the `dev` fallback is regression-tested (T-017).
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
