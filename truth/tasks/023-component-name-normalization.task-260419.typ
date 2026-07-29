#import "@local/mindtape:0.2.0": *

#show: task.with(
  id: "288778bd-5249-4cb3-8c99-24e9e4f956a8",
  title: "Pluggable OpenAPI → PHP name-normalisation strategies",
  status: done(2026, 4, 19),
  priority: 7,
  x-paogen: (spec: "truth/specs/model-generator.typ", decision: "truth/decisions/003-profile-and-attribute-dx.typ", legacy-id: "T-023"),
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

Treat name normalisation as a *pipeline of small, pattern-matchable
strategies* the Profile configures. Each strategy decides whether to
act on a given raw name, and if it does, returns the resulting PHP
identifier. Nothing is released, so the default pipeline ships the
useful behaviour — kebab/snake/dot names automatically become PHP
identifiers — and `renames` keeps its role as the explicit-override
slot.

=== Pipeline shape

A single `NameNormaliser` interface:

```php
interface NameNormaliser {
    /**
     * @return string|null PHP identifier when this strategy handles
     *         the name, or null to pass through to the next strategy.
     */
    public function normalise(string $raw, NormalisationContext $ctx): ?string;
}
```

`NormalisationContext` carries the symbol kind (start with just
`SchemaComponent`) and the raw name. Enum cases and operation IDs get
their own kinds only when a fixture needs them — not in this pass.

A `CompositeNormaliser` holds an ordered list and invokes each until
one returns non-null. If *none* match, the composite throws with a
diagnostic pointing at the offending name and the configured strategy
list. No silent identity fallback.

=== Pattern gating

Any strategy can optionally be constructed with a PHP-regex pattern:

- Pattern null → strategy considers every raw name.
- Pattern set → strategy only considers names where `preg_match` is
  truthy.

Gating is independent of the strategy's own "do I handle this input?"
logic. A pattern-gated strategy can still return null from
`normalise()` (e.g., "only apply to kebab-case" — pattern matches, but
the strategy might still decline if the name was already valid).
Composing pattern + decline keeps each strategy single-purpose.

=== Precedence

The default composite built from `Profile` is:

+ `RenamesNormaliser` built from `$profile->renames` (if non-empty).
+ `PascalCaseSanitiser` (catch-all, no pattern).

Users who supply a custom `$profile->nameNormaliser` take over the
whole pipeline; if they want renames, they compose a
`RenamesNormaliser` themselves. The two-field split keeps the 80%
case ergonomic (just set `renames`) without forcing the 20% case to
inherit behaviour they may not want.

=== Collisions

Two raw names that land on the same normalised output
(e.g. `foo-bar` and `foo_bar` → `FooBar`) → generator aborts with a
pointed error naming both raw keys and the shared result. The user
must disambiguate via `renames`. Silent suffixing (`_N`) was rejected
— two classes with near-identical names is a landmine.

=== Bundled strategies

+ `RenamesNormaliser(array<string,string> $map, ?string $pattern = null)`
  — returns `$map[$raw]` or null. Almost always used without a
  pattern.
+ `PascalCaseSanitiser(?string $pattern = null)` — splits the input
  on `/[^A-Za-z0-9]+/`, PascalCases each segment, prefixes `_` when
  the result starts with a digit. Returns null when the input is
  *already* a valid PHP identifier and unchanged by the transform
  (so an upstream strategy can opt not to touch already-clean names
  via pattern gating and still compose).
+ `CompositeNormaliser(list<NameNormaliser> $strategies)` — the
  ordered pipeline described above. First non-null wins; all-null →
  throw.

A snake-case-preserving variant (`Security_Advisory` style) is *not*
shipped here; file a follow-up if any fixture benefits.

=== Profile shape

```php
return new Profile(
    schema: ...,
    output: ...,
    namespace: ...,
    renames: ['version-2' => 'Version2'],              // sugar
    nameNormaliser: null,                              // default pipeline
);
```

The `renames` field stays. If `nameNormaliser` is null, paogen builds
the default pipeline from `renames`. If `nameNormaliser` is non-null,
paogen uses it *verbatim* — `renames` becomes advisory unless the
user composes a `RenamesNormaliser` themselves. Explicit tradeoff:
the user who writes a custom pipeline takes full responsibility.

== In scope

+ Add a new namespace `Mlavrinenko\Paogen\Generator\Naming` with:
  - `NameNormaliser` interface.
  - `NormalisationContext` value object (just `kind` for now; one
    enum case, `SchemaComponent`).
  - `RenamesNormaliser`, `PascalCaseSanitiser`,
    `CompositeNormaliser` classes.
  - `NameRegistry` — collects `$raw → $php` decisions as they happen
    and raises on collision.
+ Add `Mlavrinenko\Paogen\Generator\Emit\ComponentName` — the single
  resolver every ref site calls. Takes the `NameRegistry` + the raw
  ref target, returns `(rawName, phpName, modelNamespace)`.
+ Rewire every call site that today uses a private
  `componentNameFromRef`:
  - `src/Generator/Generator.php:157`.
  - `src/Generator/Emit/TypeResolver.php:31,40`.
  - `src/Generator/Emit/PropertyShape.php:43,52,63,139`.
  - `src/Generator/Emit/CompositionResolver.php:176,189`.
  - `src/Generator/Emit/RequestBodyAnalyzer.php:74,83`.
  - `src/Generator/Emit/OperationAnalyzer.php:167,180`.
+ `Profile` gains a `nameNormaliser: ?NameNormaliser` field. When
  null, `Generator` builds the default pipeline
  (`RenamesNormaliser($profile->renames)` + `PascalCaseSanitiser`).
+ Promote Model Generator scenarios that lock:
  - Default pipeline turns `security-advisory-ecosystems` into
    `SecurityAdvisoryEcosystems` and updates every cross-ref.
  - `renames: ['version-2' => 'Version2']` takes precedence over
    the auto-sanitiser.
  - A user-supplied pipeline that is an *empty*
    `CompositeNormaliser` (no strategies) fails the run with a
    useful error naming the first unhandled component.
  - A pattern-gated strategy only applies to names it matches
    (demonstrate via a tiny fixture strategy that upper-cases
    names starting with `legacy_`, composed before
    `PascalCaseSanitiser`).
  - Two raw names normalising to the same PHP class abort the run
    with both raw names listed.
+ A new fixture under `tests/fixtures/schemas/` named e.g.
  `naming-3.0.yaml` that exercises kebab-case, snake_case,
  digit-suffix, and cross-refs between them. Commit the golden
  tree under `tests/fixtures/generated/naming/`.
+ Regenerate existing golden trees (`petstore`, `composition`,
  `contact`, `parameters`). All their component names are already
  valid PascalCase identifiers and the default pipeline is
  idempotent on those, so the diffs should be empty. If anything
  shifts, investigate before committing.
+ ADR-003 amendment section documenting the `nameNormaliser` field
  and precedence. If the amendment grows past a few paragraphs,
  supersede with a dedicated ADR.
+ Unblock `examples/digitalocean` and `examples/github`: delete
  their `.expected-failure` markers, commit their
  `generated/` trees under the default pipeline.

== Non-goals

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

== Acceptance criteria

- `devbox run php bin/paogen generate examples/digitalocean/paogen.php`
  and `… examples/github/paogen.php` both complete with the default
  pipeline (GitHub needs `-d memory_limit=2G`).
- Both `examples/*/generated/` trees pass `phpstan analyse -c
  phpstan-generated.neon`.
- The existing petstore / composition / contact / parameters golden
  trees are byte-identical after regeneration under the new
  pipeline.
- New Model Generator scenarios cover the five behaviours in the
  "In scope" list above, each with its own `@scenario` and traces
  scoped to the relevant Naming + Emit files.
- `just check` green; `just check-examples` reports all three
  examples as passing.
- ROADMAP Phase 5's T-023 checkbox flips. If T-023 ships before
  tagging, the phase folds into "done" and the `.expected-failure`
  markers are gone. If the release cut decides to defer, move T-023
  and the two marker deletions into the post-v0.1 section
  instead — this task file still reflects the final design either
  way.
