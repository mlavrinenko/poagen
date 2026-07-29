#import "@local/mindtape:0.2.0": *

#show: task.with(
  id: "ffbe682c-524b-4e56-8fd5-86a017a8549a",
  title: "Parameter-name and operationId normalisation",
  status: done(2026, 4, 19),
  priority: 7,
  x-paogen: (spec: "truth/specs/operation-generator.typ", decision: "truth/decisions/003-profile-and-attribute-dx.typ", legacy-id: "T-025"),
)

== Summary

T-023 normalises OpenAPI *schema component* names. Two neighbouring
identifier spaces still need the same treatment and currently cause
whole operations to be silently dropped:

- *Parameter names* — header params like `Content-Type`, query params
  like `X-Trace-ID`, path params with kebabs. The emitter calls
  `Nette\PhpGenerator\Method::addParameter($param->name)` verbatim
  and would abort on invalid identifiers, so
  `OperationAnalyzer::pathParameters()` now rejects the whole op
  when any parameter's raw name fails the
  `/^[A-Za-z_]\w*$/` check.
- *OperationId* — DigitalOcean uses
  `monitoring_get_appRestartCountMetrics.yml` in a handful of
  operations; the dot is illegal in a PHP method name. The emitter's
  early-skip guard (T-023 session) prevents the crash at the cost of
  the whole operation.

Both paths need the real fix: normalise through a pipeline, keep the
raw value for the wire (header name, path template `{raw}`), and use
the normalised form as the PHP identifier.

== Rationale

Surfaced while unblocking T-024's validation-tier examples. After
T-023, `examples/digitalocean` and `examples/github` both generate —
but many ops are silently skipped because of this gap. Users building
an SDK can tell they are missing endpoints; the generator does not
yet say *which* ones or *why*, and does not offer a profile-side
override.

== In scope

+ Reuse the `NameNormaliser` interface from T-023. Add two new
  `SymbolKind` cases: `OperationId` and `ParameterName`.
+ Thread the registry (or a second registry instance) into
  `OperationAnalyzer` + `OperationEmitter` + `RequestAssembler` so
  PHP-side identifiers use the normalised form and wire-side values
  (path template, header name, query key) keep the raw name.
+ Remove the early-skip guards added in T-023 from
  `OperationEmitter::emit` (operationId check) and
  `OperationAnalyzer::pathParameters` (param-name check).
+ Add scenarios on the Operation Generator that lock:
  - A header parameter named `Content-Type` surfaces as a PHP
    method argument `$contentType`; the emitted request attaches
    the header with the original wire key `Content-Type`.
  - An operationId like `monitoring_get_foo.yml` becomes
    `monitoringGetFooYml` (or whatever the configured strategy
    picks).
  - Using `Profile::$renames` to override a specific operationId or
    parameter name works the same way as it does for schema
    components (via the shared `renames` map or a per-kind map —
    decide during implementation).
+ Report, during generation, the list of ops that *were* skipped
  for any remaining reason (unsupported body type, unresolvable
  `$ref`) so the user knows what did not make it into the client.
  This is a tiny diagnostic add-on, not a new pipeline stage.

== Non-goals

- A brand-new `SymbolKind::EnumCase` — T-009's `EnumCatalog::pascalize`
  is its own thing. Revisit only if a real schema forces it.
- Resolving `oneOf` branches whose target is a scalar schema. That
  is T-026 territory.
- Dropping the path-item `$ref` parameter skip (ADR-005 fixtures
  already exercise this; a `$ref` that doesn't resolve is a real
  skip reason).

== Acceptance criteria

- `examples/digitalocean` and `examples/github` gain back the ops
  that were skipped only because of T-023's guards. Diff the
  golden trees before / after the task: any new `public function`
  on `ApiClient` that came from a previously-skipped op is the
  acceptance evidence.
- New Operation Generator scenarios cover the two cases above.
- `just check-examples` still passes.
- `just check` green end-to-end.
