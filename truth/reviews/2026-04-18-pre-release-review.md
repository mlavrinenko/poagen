# poagen — Pre-Release Review (2026-04-18)

Author: review pass on `main` @ `8a91cca` (PoC, 18/19 Petstore ops covered).

## TL;DR

poagen is an unusually disciplined pre-alpha: the **spec → ADR → code → golden-fixture**
chain is tight, PHPStan max + bleeding-edge is green, and `just check` passes end-to-end
(24 tests, 124 assertions, 0 errors). The PoC covers ~18 of 19 Petstore operations and
produces readable, PHPStan-clean output.

That said, the current scope is explicitly a PoC. Before anything is tagged as a stable
`0.1.0` (let alone `1.0`), several **correctness**, **coverage**, and **packaging** gaps
need closing. Items below are grouped by severity.

---

## P0 — Release blockers (correctness / data integrity)

### 1. `hydrate()` does not recurse into list-typed model properties
`src/Generator/Emit/ClientEmitter.php:142-181` emits a reflection-based hydrator that only
recurses when `!$type->isBuiltin()`. For a Model property like `Pet::$tags`
(`?array $tags` + `@param ?list<Tag> $tags` — see
`tests/fixtures/generated/petstore/Generated/Model/Pet.php:11`), the reflected type is the
builtin `array`, so each item remains a raw `array` instead of a `Tag`. At runtime this
**silently violates the @phpstan-param contract** — consumers will crash later when they
read `$pet->tags[0]->name`.

Fix: emit per-property hydration metadata (e.g., PHPDoc-parsing or a generated
`$hydrationMap`) or switch to a visitor that inspects `@param list<Foo>` annotations. This
is the single biggest correctness gap.

### 2. `hydrate()` uses PHP parameter names, not schema keys
`ModelEmitter::phpName()` (`src/Generator/Emit/ModelEmitter.php:125-142`) camelCases
non-identifier OpenAPI names (e.g., `photo_urls` → `photoUrls`). The hydrator then looks up
the PHP name in the JSON payload — but the wire key is still `photo_urls`, so the value is
dropped and the default is used. Any schema with snake_case or kebab-case keys will produce
half-populated models.

Fix: generate a static `PROPERTY_MAP` per Model, or keep the original key as a
`#[\SerializedName]`-style attribute so the hydrator can map bi-directionally. The same fix
enables correct `json_encode($body)` for request bodies.

### 3. Round-tripping a `BindsFormat` value object breaks on serialization
A user wraps a scalar in `Email { public string $value }` and binds it via
`#[BindsFormat('email')]`. But `json_encode($contact)` emits `{"email": {"value": "..."}}`
instead of `{"email": "..."}`. The generator has no hook for
`__toString()`/`JsonSerializable` or an `unwrap` convention, so request bodies with bound
scalars go out malformed. Response hydration has the mirror bug.

Fix: require bound VOs to implement a tiny interface
(`ScalarBinding { static from(mixed): self; toScalar(): mixed; }`) or emit an explicit
marshal/unmarshal in the hydrator.

### 4. Operation-level `$ref` parameters abort the whole operation
`OperationAnalyzer::pathParameters()` returns `null` as soon as it hits `Parameter|Reference`
that is a Reference (`src/Generator/Emit/OperationAnalyzer.php:43-47`), causing
`OperationEmitter::emit()` to silently skip the operation. Real-world schemas (GitHub,
Kubernetes — both on `schema-fixture-policy`'s validation list) ref common parameters extensively. Without
inline-resolution, most of those operations will silently disappear.

Fix: call `Reader::readFromYamlFile(..., resolveReferences: true)` for the operation/parameter
tree, or resolve Reference-typed Parameter/Header/RequestBody nodes at the analyzer boundary.

### 5. Path-item-level parameters are ignored
Only `operation->parameters` are scanned. OpenAPI also allows parameters at the `PathItem`
level; ignoring them produces methods missing required path or query args. This is another
silent-skip class.

### 6. Stale output is never pruned
`Generator::generate()` writes every file but never deletes files from prior runs that no
longer correspond to a schema component. A schema rename (`Pet` → `Animal`) leaves `Pet.php`
behind, and PHPStan on the consumer's side flags the orphan. The byte-stability
`profile-driven-generation` promise holds only in the add-only direction.

Fix: diff the emitted set against what's on disk under `Generated/` and unlink leftovers.
Guard the prune to the `Generated/` subtree so user code never gets touched.

---

## P1 — Coverage gaps that block real APIs

### 7. No `oneOf` / `anyOf` / `allOf`
Not tested, not spec'd. Every non-trivial real API uses composition. Today these fall through
`TypeResolver::resolve()` `default` and become `mixed` — both the PHP type and the PHPStan
annotation.

### 8. No enums
Petstore's `findPetsByStatus` has `enum: [available, pending, sold]`; poagen emits
`string $status`. With PHP 8.1+ backed enums, this is low-hanging fruit and a big DX win.

### 9. No datetime / format handling beyond `BindsFormat`
`format: date-time`, `format: date`, `format: uuid`, `format: binary` all degrade to `string`.
The only escape hatch is for users to define their own VO and bind it. A minimal built-in
`DateTimeImmutable` mapping for `date-time` is table-stakes.

### 10. No non-JSON content types
`uploadFile` in Petstore (multipart) is silently skipped. `x-www-form-urlencoded`,
`application/octet-stream`, `multipart/form-data` are all out of scope per the task file but
are common — at least `form-urlencoded` should land before "stable" status.

### 11. No error / non-2xx handling
The only 2xx is picked; 4xx/5xx currently land in `hydrate()` and throw
`RuntimeException('Cannot hydrate … from non-array data.')`. There is no typed error body,
no exception class per schema, no status-code mapping. The task file acknowledges this —
must be formalised before v0.1.

### 12. Nested inline object schemas emit `array<string,mixed>`
`TypeResolver::resolve()`'s `'object'` branch returns
`new self('array', 'array<string,mixed>', ...)`. Any inline nested object (without a `$ref`)
loses its structure.

### 13. No security/auth scheme support
OpenAPI `securitySchemes` / `security` are completely ignored. Users must decorate the client
for auth — fine as a philosophy (`no-inheritance-no-protected-regions`) but the generator should at least read auth
headers/parameters out of the schema so they appear as method/constructor arguments.

### 14. OpenAPI 3.1 gap documented but open
`truth/notes/openapi-3.1-gap.md` is thorough. This is explicitly a known limitation, but it
needs a decision (translator shim vs. parser swap) before most modern schemas are usable.

---

## P2 — Packaging, CI, and DX polish

### 15. Unmaintained upstream parser (`cebe/php-openapi`)
The whole test suite prints 8 PHP 8.4 deprecations from `vendor/cebe/php-openapi`:
```
cebe\openapi\SpecBaseObject::resolveReferences(): Implicitly marking parameter $context as nullable is deprecated
```
(`tests/generated/OperationGeneratorSteps.php:230` suppresses them via `error_reporting`, so
they're hidden during library test runs but will hit every consumer.) Upstream 1.8.0 is from
May 2025 and still hasn't fixed this. Pick: fork, parser swap (the 3.1 ADR already lists
candidates), or upstream PR before tagging.

### 16. `composer.json` stability
`"minimum-stability": "dev"` with `"prefer-stable": true`. Safe to flip to `"stable"` once
3.1 parser is chosen and no dev-only deps remain. Leaving it at `dev` on Packagist release
would surprise users.

### 17. Version source of truth
`src/Cli.php:25` hardcodes `VERSION = '0.1.0-dev'`. No sync with git tags, no `composer.json`
version field. Needs either a build step that stamps a constant from the tag or a runtime
read from `Composer\InstalledVersions`.

### 18. Generator CLI is missing promised commands
`plain-getopt-for-the-cli` lists `poagen validate <schema>` as part of the tiny CLI surface; only `generate`,
`help`, `version` exist. Either ship `validate` or retire the promise in the ADR.

### 19. CLI lacks `--output`, `--dry-run`, `--diff`
All customisation has to go via `poagen.php`. A one-shot
`poagen generate ./profile.php --output=./tmp` for CI introspection is sorely missing, as is
a `--dry-run` that prints what would change. `--diff` (show textual diff vs existing output)
would be a cheap review aid.

### 20. Coverage not enforced in CI
`continuous-integration.yml` uploads coverage to codecov but sets no minimum threshold.
`codecov.yml` is 400 bytes — either enforce (e.g., 80%+ for `src/`) or delete to stop
pretending.

### 21. Mutation testing declared but not wired
`infection/infection` is in `require-dev` but there's no `infection.json5` and no Justfile
recipe. Either configure it or drop the dep.

### 22. `CHANGELOG.md` is an empty "TBD"
Every release blocker above should land as a CHANGELOG entry. Currently it's literally
"Nothing." in every section.

### 23. `tests/fixtures/generated/` is the only regression harness
Golden-file testing is great but currently the *only* safety net outside the per-feature
tests. No byte-stability test is actually asserted as a spec against a real schema beyond
the scenario, and no explicit "run the generator twice and diff" invariant is tested against
the Petstore fixture specifically.

### 24. PHPUnit stderr prints `D` deprecation notice
`devbox run just check` is green but the `D` in the PHPUnit dots column (deprecation notice)
will confuse contributors. Either upstream a patch or pin an `error_reporting(~E_DEPRECATED)`
boot in `phpunit.xml.dist` with a comment explaining why.

---

## P3 — Nice-to-have / after 0.1

- **Per-operation tags → sub-clients** (e.g., `ApiClient::pet()->getPetById(...)`). Petstore
  has 3 tags; for large APIs a single flat `ApiClient` with 1000 methods is unergonomic.
- **Idempotent mkdir + dry-run prune** (see P0 #6) → also supports `--check` mode for CI.
- **PSR-3 logging hook** (constructor-injected). Optional.
- **`poagen.php` schema validator** (verify the `Profile` values point at real paths,
  `discoverIn` namespaces exist in Composer autoload, `renames` target real components) —
  currently only `schema` path is verified.
- **Docs** — `README.md` usage section is "planned"; migrate to "current" once CLI is
  stable. No "how decorator composition looks in practice" doc matching `no-inheritance-no-protected-regions`'s claim.
- **Benchmark on a large schema** (GitHub bundled ~5MB) before tagging: memory, wall-time,
  output size.

---

## Release-readiness matrix

| Gate | Status |
|---|---|
| Specs + ADRs | Rigorous |
| Lint / PHPStan max / Rector | Clean |
| Linecop (250 LOC) | All files within budget |
| Tests passing | 24/24, 124 assertions |
| Deprecation-noise-free | 8 deprecations from `cebe/php-openapi` |
| Drift check (`just check-specs`, `check-drift`, `check-generated-tests`) | Green |
| Byte-stable output | Tested but stale files never pruned |
| Hydrator correctness | Nested model lists + non-ident keys broken |
| OpenAPI 3.0 coverage | ~90% for trivial schemas; falls off for refs/composition/enums |
| OpenAPI 3.1 | Out of scope, blocks modern schemas |
| Packagist | Not published |
| CHANGELOG | Empty template |
| CLI complete | 3/4 advertised commands |

---

## Suggested ordering toward a credible `0.1.0` tag

1. **Fix the two hydrator correctness bugs** (P0 #1, #2) + BindsFormat round-trip (P0 #3).
   Without this, the generated client produces wrong data on realistic schemas.
2. **Reference/inline resolution + path-item-level params** (P0 #4, #5). Without this, most
   real APIs lose operations silently.
3. **Prune step** (P0 #6) — tiny but locks `profile-driven-generation`'s byte-stability contract.
4. **Pick a path on `cebe/php-openapi`** (P2 #15) — fork or swap. This unblocks 3.1 work
   *and* removes the deprecation noise.
5. **Ship enums + datetime built-ins** (P1 #8, #9) — low effort, huge DX.
6. **Error-response story** (P1 #11) — promote the task-file TODO to a spec and decision.
7. **Packaging pass**: CHANGELOG, stability, version source, Packagist (P2 #16, #17, #22).
8. Tag `0.1.0`.

`oneOf`/`anyOf`/`allOf`, sub-clients, security schemes, and multipart can wait for `0.2.0`.
