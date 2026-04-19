#import "@local/speconaut:0.1.0": task, proposed

#show: task.with(
  title: "Pluggable OpenAPI → PHP name-normalisation strategies",
  status: proposed,
  date: datetime(year: 2026, month: 4, day: 19),
  priority: "high",
  spec: "truth/specs/model-generator.typ",
  decision: "truth/decisions/003-profile-and-attribute-dx.typ",
)

== Summary

Every site in the generator that turns an OpenAPI component name into a
PHP class reference uses the raw schema key verbatim. Real-world APIs
routinely use kebab-case (`security-advisory-ecosystems`,
`webhook-config-content-type`) and occasionally digit-prefixed or
otherwise hostile names (`version-2`, `urn-2`). These produce invalid
PHP and abort generation with a `Nette\PhpGenerator` exception.

The `Profile::$renames` field documented in ADR-003 is *meant* to be the
escape hatch, but it is only consulted at one site
(`Generator::emitModels()`, line 157) and is not threaded into
`TypeResolver`, `PropertyShape`, `CompositionResolver`,
`RequestBodyAnalyzer`, or `OperationAnalyzer`. Even when the user lists
a bad name in `renames`, cross-class references resolve to the raw
(broken) name.

== Rationale

Surfaced while building real-world examples for ADR-005's validation
tier (DigitalOcean + GitHub).

- *DigitalOcean* has 722 schema components, 2 invalid
  (`version-2`, `urn-2`). A short `renames` entry could in principle
  handle it — *but does not*, because renames do not propagate to
  refs (see reproducible example below).
- *GitHub REST API* has 918 schema components, 818 of them invalid
  (kebab-case). Manually enumerating 818 renames is not a credible
  user experience; auto-normalisation is required.

Without this fix, the "real-world schemas work" promise is empty: both
v0.1 validation fixtures fail on first invocation.

== Reproducible example

```bash
cd ~/projects/home/paogen

# 1. Minimal DO case — with renames map that *should* suffice.
mkdir -p /tmp/paogen-repro/{schemas,generated}
curl -sSL https://api-engineering.nyc3.cdn.digitaloceanspaces.com/spec-ci/DigitalOcean-public.v2.yaml \
    > /tmp/paogen-repro/schemas/do.yaml

cat > /tmp/paogen-repro/paogen.php <<'PHP'
<?php
declare(strict_types=1);
use Mlavrinenko\Paogen\Generator\Profile;
return new Profile(
    schema: '/tmp/paogen-repro/schemas/do.yaml',
    output: '/tmp/paogen-repro/generated',
    namespace: 'Acme\\DO',
    renames: ['version-2' => 'Version2', 'urn-2' => 'Urn2'],
);
PHP

devbox run php -d memory_limit=1G bin/paogen generate /tmp/paogen-repro/paogen.php
```

Observed:

```
Fatal error: Uncaught Nette\InvalidArgumentException:
  Value '\Acme\DO\Generated\Model\urn-2' is not valid type.
  at vendor/nette/php-generator/src/PhpGenerator/Helpers.php:146
  #1 src/Generator/Emit/ModelEmitter.php:169 (setType)
```

The class `Vpc` has a property of type `urn-2` (a `$ref` to the
component of that name). `TypeResolver::resolve()` at
`src/Generator/Emit/TypeResolver.php:40` builds the FQCN by
concatenating `$modelNamespace` with the *raw* component name — the
renames map is ignored. The same bug exists at every other ref
resolution site listed below.

The first error is on `urn-2` rather than `version-2` because the
latter happens to be emitted as a top-level class (where the rename
*is* applied) before any other class refers to it.

Expected: paogen writes a full `/tmp/paogen-repro/generated/` tree
with `Urn2.php` and `Version2.php` present and every cross-reference
targeting those sanitised names.

== Design intent

Manually enumerating 818 kebab-case names in `renames` is not a
plausible user experience, and a single hard-coded auto-sanitiser is
opinionated in ways different teams disagree about (PascalCase vs
UPPER_SNAKE, prefix handling, acronym preservation). Treat name
normalisation as a *strategy* the Profile selects, bundle the common
cases, and let users bring their own.

Precedence order, top to bottom:

+ Explicit `Profile::$renames` entry for a given raw name.
+ A `#[BindsName(...)]`-style attribute if one lands in a later
  task (left out of scope here; file if needed).
+ The Profile's configured normalisation strategy.
+ A built-in `Raw` strategy that returns the name unchanged — this
  is the *only* default we can ship without breaking existing
  fixtures. Users explicitly opt in to sanitisation.

Bundled strategies shipped in-tree:

+ `Raw` — identity; throws on an invalid identifier *only* when the
  name actually reaches code-emission (today's behaviour,
  clarified).
+ `PascalCaseSanitiser` — split on `[^A-Za-z0-9]+`, PascalCase each
  segment, prefix an underscore if the result starts with a digit,
  suffix `_N` on collision with an already-claimed name.
+ One more candidate to evaluate when the PoC lands: a `SnakeCase`
  variant for projects that prefer `Security_Advisory` style. Land
  if any of the validation-tier fixtures benefit; skip otherwise.

User-supplied strategy:

+ A `NameNormaliser` interface (exact name TBD during
  implementation) with one method
  `normalise(string $raw, NormalisationContext $ctx): string`.
  Context carries the kind of symbol (schema component, operation
  id, enum case, future kinds), the raw name, and whatever prior
  results the run has seen (for collision handling).
+ Profile grows a typed field (likely `nameNormaliser: ?object`)
  accepting any class that implements the interface. The field
  stays `?` and defaults to `null` → `Raw`, to preserve existing
  behaviour for schemas that don't need it.

== In scope

+ Add the `NameNormaliser` interface and the two (or three) bundled
  strategies above.
+ Add a `Mlavrinenko\Paogen\Generator\Emit\ComponentName` (or
  equivalent) *resolver* that threads the Profile's
  renames + strategy + the collision ledger through a single call
  site, returning a guaranteed-valid PHP class name.
+ Rewire every location that today uses a private
  `componentNameFromRef` to go through the resolver:
  - `src/Generator/Generator.php:157` — the authoritative class
    name.
  - `src/Generator/Emit/TypeResolver.php:31,40`.
  - `src/Generator/Emit/PropertyShape.php:43,52,63,139`.
  - `src/Generator/Emit/CompositionResolver.php:176,189`.
  - `src/Generator/Emit/RequestBodyAnalyzer.php:74,83`.
  - `src/Generator/Emit/OperationAnalyzer.php:167,180`.
+ Profile gains the `nameNormaliser` field with a sensible type hint
  and a short docblock pointing at ADR-003. Default `null` → `Raw`.
+ Promote Model Generator scenarios that lock:
  - Default (`Raw`): `security-advisory-ecosystems` reaches code
    emission and the run aborts with a clear diagnostic pointing at
    the field to set.
  - `PascalCaseSanitiser`: same input → `SecurityAdvisoryEcosystems`,
    cross-refs updated.
  - Renames precedence: `renames: ['version-2' => 'Version2']`
    wins over the strategy.
  - User strategy: a tiny fixture normaliser implementing the
    interface returns a canned mapping, end-to-end.
+ A new dedicated fixture under `tests/fixtures/schemas/` exercising
  kebab-case + digit-suffix names + cross-refs. Commit its golden
  tree twice: once under `Raw` (expected to fail emission → use a
  different approach, or cover via a failure-path scenario) and
  once under `PascalCaseSanitiser`.
+ Regenerate any already-committed fixture trees affected by the
  resolver refactor. `petstore`, `composition`, `contact`,
  `parameters` use valid identifiers already — output must stay
  byte-identical.
+ Update ADR-003 to document the strategy field and the precedence
  ladder. Supersede if the section grows large; most likely fits
  as an amendment.
+ Unblock the `examples/digitalocean` and `examples/github`
  demonstrations (see T-024). Their `.expected-failure` markers
  flip to `pass` and their golden trees land in a follow-up
  commit.

== Out of scope

- Sanitising *property* names beyond the current `phpName()` logic.
  That path is exercised and not reported as broken.
- Sanitising *operationId* collisions across tags (separate concern,
  file if needed).
- Sanitising enum component names (T-009 territory) unless the
  current implementation is proven broken on DigitalOcean or GitHub
  — file a separate task if so.
- A `BindsName` attribute analogous to `BindsFormat`. File if a
  compelling case lands; otherwise strategy + renames is enough.
- Configuration via `paogen.php` of *which* built-in strategy by
  string name. Users pass a concrete strategy object — we are not
  building a mini DSL.

== Acceptance

- `devbox run php bin/paogen generate examples/digitalocean/paogen.php`
  completes under the default strategy with a two-entry `renames`
  map, and under `PascalCaseSanitiser` with no `renames` at all.
- `devbox run php -d memory_limit=2G bin/paogen generate examples/github/paogen.php`
  completes under `PascalCaseSanitiser` with no `renames` entries.
- Both generated trees pass `phpstan analyse -c phpstan-generated.neon`
  once the examples/ golden trees land.
- New Model Generator scenarios cover: default `Raw` failure mode,
  bundled `PascalCaseSanitiser` success path, renames precedence,
  and user-supplied normaliser.
- `just check` green end-to-end.
- `just check-examples` flips the DigitalOcean and GitHub examples
  from `expected-failure` to `pass` (see T-024).
- ROADMAP.md adds this task to the appropriate phase (likely a new
  Phase 5 — "validation-tier unblock" — given both v0.1 exit-criteria
  candidates depend on it).
