# poagen/client-generator Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/)
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

Nothing yet — `0.1.0` below is the current tip.

## 0.1.0 - 2026-11-03

First consumable release. The OpenAPI 3.0 *and* 3.1 pipeline is correct,
type-safe, and pleasant to use on real schemas (Petstore, DigitalOcean,
GitHub, and kilbil's loyalty API, all under [`examples/`](examples/)).
Mutation testing is wired and measured but deliberately stays outside
`just check`; see "Quality gates" below.

### Added

#### Type coverage

- `ScalarBinding` interface: user value objects annotated with
  `#[BindsFormat]` can round-trip as bare scalars on the wire via
  `toScalar()` / `fromScalar()` on both send and receive paths (T-004).
- Built-in `\DateTimeImmutable` mapping for `format: date-time` and
  `format: date` — no user binding required (T-010).
- `Profile::$formats` binds a value object or a codec to every site carrying
  one `format`, document-wide, without the class needing a `#[BindsFormat]`
  attribute or a namespace under `$discoverIn`. Most specific route wins:
  `$propertyFormats`, then `$formats`, then a discovered `#[BindsFormat]`,
  then a built-in. `poagen/client-runtime` ships `Format\RamseyUuidCodec` and
  `Format\SymfonyUuidCodec` for `format: uuid`, both libraries `suggest`
  rather than `require`, and neither applies until the profile names one —
  PHP has no core UUID type, so poagen picks none. `format: binary` on a
  plain property stays advisory on purpose
  (`binary-on-a-property-stays-advisory.decision-260809`).
- `Poagen\Runtime\Codec` interface: a second binding shape for a `format`
  whose type poagen does not control — a class from a third-party library
  that cannot be made to implement `ScalarBinding`. A `ScalarBinding` types
  the property as the binding itself; a `Codec` types it as its own
  `targetType()` — `public UuidInterface $id`, never a wrapper — and
  `Marshal\Hydrator`/`Marshaller`/`Http\ResponseDecoder` route conversion
  through the codec's `decode()`/`encode()` instead. Covers a nullable,
  list, and map property carrying a codec-bound format, not only a bare
  scalar one. `Format\RamseyUuidCodec` and `Format\SymfonyUuidCodec` are
  this interface's first consumers, re-expressed from the `ScalarBinding`
  wrappers `built-in-uuid-and-binary-format-bindings` shipped
  (`codec-bindings-for-foreign-value-types`,
  `reexpress-the-uuid-bindings-as-codecs.decision-260809`).
- `format: byte` — OpenAPI's spelling for base64-encoded bytes inside a JSON
  string — binds to `Runtime\Format\Base64Codec` with no `Profile::$formats`
  entry required: both directions are `base64_decode()` (strict mode) /
  `base64_encode()`, PHP core, so unlike `uuid` this one costs nobody a
  dependency and poagen picks it by default, the same way `date-time`
  already is. A payload that fails strict decoding is refused naming the
  property. Still overridable through `$propertyFormats`, `$formats` or a
  discovered `#[BindsFormat('byte')]`, like any other built-in
  (`base64-binding-for-format-byte`).
- OpenAPI `enum` components emit as PHP 8.1 backed enums under
  `Generated/Enum/` and replace their references in model properties
  (T-009).
- Inline nested `type: object` properties synthesise a typed class per
  occurrence (e.g. `Pet.shipping` → `Generated/Model/PetShipping`)
  instead of collapsing to `array<string, mixed>`. Inline objects whose
  `additionalProperties` is a scalar become typed maps (T-013).
- `oneOf` / `anyOf` of `$ref` components emit as PHP union types;
  `discriminator.propertyName` selects the branch at hydration time.
  `allOf` merges recursively — a node's own `properties` / `required`
  alongside every member's, recursing into a member whose own `$ref`
  target is itself `allOf` — rather than the one-level flatten T-008
  first shipped. A member that is a `oneOf` / `anyOf` of expressible
  branches becomes one synthesised model per branch and a native PHP
  union across them. A property declared twice with two different
  schemas, a branch set that is not all object shapes, and a `required`
  name nothing declares all refuse the operation by name instead of
  silently overwriting or dropping the constraint (T-008,
  `merge-allof-members-into-one-model`).
- Named scalar, array, and top-level `oneOf` / `anyOf` components
  resolve to real PHP types rather than collapsing to `mixed`: scalars
  emit a generated `ScalarBinding` value object, `type: array`
  components emit a typed wrapper, and top-level composition components
  emit a marker interface that inline-branch synths and `$ref`-branch
  models `implements`. Backed by a `ComponentCatalog` that classifies
  every `components.schemas` entry once and feeds both the emitter and
  the parameter layer (T-026).

#### OpenAPI 3.1

- OpenAPI 3.0 and 3.1 documents both parse through
  [`devizzent/cebe-php-openapi`](https://github.com/DEVizzent/cebe-php-openapi),
  a maintained fork of `cebe/php-openapi` that fixes its PHP 8.4
  deprecations upstream and models 3.1 constructs the original did not,
  including `type` as a list — 87 uses in the document poagen is built
  against. See
  [`openapi-31-through-a-maintained-parser`](truth/decisions/openapi-31-through-a-maintained-parser.decision-260729.typ)
  (supersedes `openapi-31-strategy`).
- The 3.0 `nullable: true` idiom and the 3.1 `type: [T, "null"]` idiom
  emit the same PHP type, proven by a fixture pair that differs in
  nothing else and generates byte-identical output.
- A JSON Schema 2020-12 keyword no emitter implements — `const`,
  `prefixItems`, `unevaluatedProperties`, `contentMediaType` — stops the
  run and names itself, the JSON pointer to the node that used it, and
  the operation or component carrying that node. A 3.1 `webhooks` entry
  does the same, unless named in `Profile::$skip`.

#### Runtime transport & sub-clients

- Every emitted operation delegates to an injected `TransportInterface`
  instead of restating the request/response dance inline: it describes
  its request as an `Endpoint` and names the response shape it expects
  as a `ResponseType` (`collapse-operations-onto-a-runtime-transport`).
- Operations are grouped by their OpenAPI tag into one sub-client per
  tag, each implementing its own generated interface; an untagged
  operation lands on the root client directly and no `DefaultApi` type
  is invented (`emit-tagged-subclients-with-interfaces`).
- Every runtime collaborator a generated file names — hydrator,
  marshaller, XML writer, transport — is declared as an interface under
  `runtime/src/Contract/`, so a consumer can substitute their own
  without editing generated code (`swappable-runtime-contracts`).

#### Runtime (de)serialisation

- New `Marshaller` / `Hydrator` pair under `runtime/src/Marshal/`
  drives every (de)serialisation via phpdoc types plus a small set of
  runtime attributes (`#[WireName]`, `#[Discriminator]`, `#[Format]`).
  Generated `Model\*` classes are plain `readonly` classes with
  promoted constructors and authoritative phpdoc — no `PROPERTY_MAP`
  const, no `JsonSerializable`, no hand-rolled hydration. Powered by
  `phpstan/phpdoc-parser`; see
  [`attribute-and-phpdoc-driven-serialization`](truth/decisions/attribute-and-phpdoc-driven-serialization.decision-260420.typ)
  (T-028, supersedes `hydration-and-serialization-contract`'s
  representation layer).
- Marshaller/Hydrator falls back to a `token_get_all` phpdoc scan when
  `ReflectionClass::getDocComment()` returns `false` — keeps the
  runtime correct under `opcache.save_comments=0` (T-029).
- Kebab-case and other non-identifier wire keys are handled via
  `#[WireName]`; `list<Model>` properties hydrate into real typed lists.
- Opt-in `OmitNullMarshaller` decorator drops `null`-valued properties
  from a marshalled payload, for APIs that reject an explicit `null`
  rather than an absent key.

#### Responses, errors, security, body handling

- Every operation returns an
  [`Envelope`](runtime/src/Contract/Envelope.php) carrying the HTTP
  status the wire sent (`->status`), the body hydrated into the shape
  the document declared for that status (`->body`), and the PSR-7
  response that carried both (`->response`). A status the document
  describes — 2xx or not — is a return value, never a throw; a
  generated `Generated\ApiException extends \RuntimeException` is
  raised only for a status the document declared no exact, range or
  `default` response for, or a declared body that failed to hydrate
  (`typed-error-responses`; see
  [`envelope-supersedes-error-response-policy`](truth/decisions/envelope-supersedes-error-response-policy.decision-260804.typ),
  which supersedes the all-non-2xx-throws behaviour T-012 first shipped
  under `error-response-policy`).
- A 2xx response whose schema declares `format: binary` returns a PSR-7
  `StreamInterface` instead of aborting generation, mirroring the
  request side's binary body.
- `securitySchemes` for `apiKey` (header) and `http bearer` surface as
  required constructor arguments on the generated `ApiClient`; every
  secured operation attaches the scheme's header. `http basic`,
  `oauth2`, and `openIdConnect` remain `draft` placeholders per
  `no-inheritance-no-protected-regions` (T-014).
- `application/x-www-form-urlencoded` request bodies expand to one
  typed method parameter per declared property; the request body is
  assembled via `http_build_query` in RFC1738 form (T-011).
- `multipart/form-data` and `application/octet-stream` request bodies
  no longer silently skip the operation. The method is emitted with a
  `: never` return type and throws a `RuntimeException` carrying the
  operationId and unsupported content type (T-011).
- `Endpoint::xmlList()` takes a validated `Profile::$xmlElements`
  nested-container binding as its own argument, threaded through
  `XmlWriterInterface::renderList()`'s fourth argument, so a consumer
  gets the vendor's wrapped XML shape straight from the profile.
- `oneOf` / `anyOf` of `$ref` branches without a `discriminator` abort
  the generator with a pointed `UndiscriminatedUnionException`, naming
  the component and property and pointing at
  `Profile::$discriminators['Component.property' => '<wireField>']` as
  the per-schema override. Hydration is discriminator-only; structural
  fallback is gone (T-030).
- `ClientEmitter` routes scalar-VO / `ScalarBinding` (and matching
  `oneOf` / `anyOf`) path parameters through `toScalar()` via a
  `ParameterStringExpr` helper, so generated path construction no
  longer `(string)`-casts value objects (T-031).
- Skipping a component whose type another component or operation still
  references now refuses the run, naming every referencer and the
  `Profile::$skip` entry that would resolve it, instead of emitting a
  dangling reference to a class that no longer exists.

#### Name normalisation

- Pluggable OpenAPI → PHP name-normalisation pipeline. Users compose
  strategies in their `Profile` (see
  [`typed-profile-and-colocated-attributes`](truth/decisions/typed-profile-and-colocated-attributes.decision-260418.typ)); the
  default pipeline (`RenamesNormaliser` → `PascalCaseSanitiser`)
  handles every DigitalOcean and GitHub component name without
  per-schema tweaks (T-023).
- `operationId` and parameter names are normalised the same way
  (`CamelCaseSanitiser` for methods / parameters) via the `SymbolKind`
  registry. `ResolvedParameter` keeps the raw wire key alongside the
  sanitised PHP identifier. Residual skips surface on stderr via
  `GenerationPlan::$skippedOperations` rather than silent drops (T-025).

#### Quality gates

- Coverage floor enforced in `just check` (`src/` ≥ 87%, `runtime/src/`
  ≥ 92%), not left to a recipe nobody runs (`coverage-floor-in-the-gate`).
- `jscpd` duplication gate on both the hand-written tier and the
  generated tier, each with its own ceiling that ratchets down as
  duplication is cut (`adopt-jscpd-duplication-gate`,
  `jscpd-as-a-real-gate`).
- Both `jscpd` recipes print the measured percentage against the ceiling
  they gated on (`scripts/jscpd-margin`), so an exit-0 run is legible as
  a pass with a stated margin, not indistinguishable from a gate that
  failed open. The hand-written tier's margin was restored from ~12
  lines to ~196 by factoring nine tests' repeated fixture-plan helpers
  into shared `tests/Support/` traits, not by moving the 3.0% threshold;
  the generated tier's four ceilings stay at their measured floor on
  purpose (`generated-tier-ceilings-cannot-fall-further.decision-260809`,
  `heal-the-duplication-gate-margins`).
- `infection/infection` wired as a real, pinned dev dependency; `just
  mutate` / `just mutate-fast` run it against `src/` and `runtime/src/`
  (measured ~87.7% MSI on a full run). Deliberately not part of `just
  check` — a full run takes seven-plus minutes, well past this
  project's gate budget; see
  [`mutation-testing-stays-out-of-the-gate`](truth/decisions/mutation-testing-stays-out-of-the-gate.decision-260802.typ).

#### DX

- `poagen generate <profile>` grows three DX flags (T-019):
  - `--output=<dir>` redirects the generated tree to an alternative
    directory without editing the profile.
  - `--dry-run` prints a tree-shaped summary of would-be-written and
    would-be-pruned files, writes nothing.
  - `--diff` prints a unified diff (via `sebastian/diff`) for every
    would-be-written file against the copy on disk; exits 1 when any
    diff is non-empty.
- `--diff` then grew the two extensions T-019 had named as explicit
  non-goals. Both are additive — a bare `--diff` still renders the whole
  plan, plain, exactly as before:
  - `--diff=<glob>` scopes the diff to a subtree of the generated output,
    matched relative to the output directory (or the raw path, when it
    falls outside that directory). `**` crosses `/`, `*` does not, `?`
    matches one non-`/` character; a glob with no wildcard matches that
    path or anything beneath it, so `Generated/Model` and
    `Generated/Model/**` scope to the same subtree.
  - `--color=auto|always|never` (default `auto`) colours additions green,
    deletions red, and hunk headers cyan. `auto` colours iff stdout is a
    TTY, `NO_COLOR` is unset, and `TERM` is not `dumb`.
- `poagen validate <schema>` subcommand: parses a YAML or JSON OpenAPI
  document, runs `OpenApi::validate()`, and reports parse / validation
  / usage errors on stderr (T-018, `plain-getopt-for-the-cli`).
  `Profile::$schema` and `poagen validate` share one reader-selection
  rule — `.json` reads as JSON, anything else as YAML — so a document
  generates the same client either way.
- Generator prunes stale `.php` files under `Generated/` at the end of
  every run so the byte-stability promise holds on component
  rename / removal (T-007).
- Every emitted file opens with a comment naming itself as generated,
  naming the `Profile` it came from (`Profile::$source`), and printing
  the `poagen generate <profile>` that reproduces it — no timestamp, no
  version, no absolute path, so a re-run over unchanged inputs is still
  an empty diff. Files are deliberately not made read-only; see
  [the decision](truth/decisions/a-header-not-a-chmod.decision-260731.typ).

#### Examples & tests

- `examples/` tree with `petstore`, `kilbil`, `digitalocean`, and
  `github` end-to-end profiles, each with a committed `generated/`
  golden tree and a `README` walking through the pipeline; `just
  check-examples` runs the generator against every one (T-024).
  `kilbil` is the real vendor schema (kilbil's loyalty API) poagen's
  claim to work is measured against — reconciled against the live
  API's actual responses and proven with recorded-response integration
  tests (`kilbil-loyalty-client-proof`, `kilbil-recorded-response-proof`).
  DigitalOcean and GitHub generate cleanly too: their property-level
  unions without a shared discriminator field resolve without
  per-property tagging — by a discriminator computed from the branches,
  a tag on the enclosing object, a closed-shape predicate, or a pin, as
  each schema needs (`declare-an-undiscriminated-union-as-raw-data`,
  `clear-example-expected-failures`).
- Integration test `tests/Integration/ByteStabilityTest` runs the
  generator twice against the Petstore profile and asserts every file
  is byte-for-byte identical between runs and against the committed
  golden tree (T-022).

### Changed

- `hydration-and-serialization-contract` ("Hydration & Serialization")
  representation section is superseded by
  `attribute-and-phpdoc-driven-serialization`. Truth-tree specs and
  decisions referencing the pre-release `PROPERTY_MAP` +
  `JsonSerializable` shape were refreshed; no code changes landed with
  this audit (T-027).
- `composer.json` `minimum-stability` is `stable`; all deps are already
  stable releases.
- `symfony/yaml` resolves to 8.1.2, closing CVE-2026-45304, CVE-2026-45305
  and CVE-2026-45133 — three ways a hostile YAML document exhausts the
  process. It reaches poagen transitively through
  `devizzent/cebe-php-openapi` and is what parses the OpenAPI document you
  pass `poagen generate`, so this is on the production path rather than a
  dev one. Lock-only: nothing was added to `composer.json`.
- CLI version string resolves from `Composer\InstalledVersions` so
  Packagist installs report the tagged release and in-repo runs report
  `dev-<branch>`; the `dev` fallback is regression-tested (T-017).
- Both packages are named under vendor `poagen`: `poagen/client-generator`
  (namespace `Poagen\Generator\`) and `poagen/client-runtime`
  (namespace `Poagen\Runtime\`, a sibling of the generator's namespace,
  not a child of it, since the two are meant to be separately published
  packages once each is ready — neither is on Packagist yet). The binary
  is `poagen`. See
  [the task](truth/tasks/rename-the-vendor-packages-and-namespaces-before-publishing.task-260803.typ).

### Removed

- Dropped codecov integration entirely. It was wired without a
  threshold and implied a gate that did not exist; the `code-coverage`
  CI job, `codecov.yml`, and `.gitattributes` export-ignore entry were
  removed. `composer test:coverage` and `just test-coverage` stay for
  local use (T-020, `quality-gates-at-maximum-strictness` updated).
- `patches/cebe-php-openapi-php84-nullable.patch` and the
  `cweagans/composer-patches` wiring that applied it, superseded by the
  parser swap above: `devizzent/cebe-php-openapi` ships the same
  deprecation fix upstream, so nothing is patched at install time any
  more. The matching `ignoreIndirectDeprecations` workaround in
  `phpunit.xml.dist` is gone too — the suite runs clean without it.
