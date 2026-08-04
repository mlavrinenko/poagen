# poagen engineering hazards

Traps measured the expensive way while writing or debugging poagen's own code
and its gates. `AGENT.md` is the entry point and covers process; this file is
the reactive reference — read it before touching `src/`, `runtime/src/` or
`tests/`, or when a gate goes red in a way `AGENT.md` doesn't explain.

## Two traps that cost real time

A third one used to live here — rector dying on a DI container compiled by some
other checkout, because it pins that cache to `sys_get_temp_dir()` and every
worktree on the box shares it. The `Justfile` now exports a per-checkout
`TMPDIR` and creates it, so the gate runs clean from a cold tree with nothing
set in your environment. It is recorded here only so the symptom is
recognisable if you meet it outside `just`: an opaque `ProcessPool.php line 30:
Process "<random>" not found`, which means a stale cache, not a broken change.

**Build any `$PWD`-based PATH *after* you `cd`, never before.** There are
usually several poagen worktrees live at once, each with its own `vendor/`. A
PATH fragment expanded in the wrong directory silently runs another worktree's
phpstan against this one's source and reports a clean result. Check `pwd` first
and pin absolute paths.

**Never pipe a gate into `head`, `tail`, or anything else when you care whether
it passed.** The pipeline reports the last command's status, so a red gate reads
as exit 0 — verified on `linecop`, which exits 1 directly and 0 through `| head`.
Redirect to a file and echo `$?`.

## The parser's accessors lie in four measured ways

`devizzent/cebe-php-openapi` reaches most of the document through magic
getters, and four of them do not mean what their declaration says. Each was
found the expensive way; check the accessor before you trust it.

**`$openApi->servers` invents a server nobody declared.** The spec defaults an
absent or empty `servers:` to a synthetic `url: /`, and the getter substitutes
it, so a document that declares nothing is indistinguishable from one that
declares `/`. `getSerializableData()` reflects only what the document itself
set — that is how `ServerCatalog::declared()` tells them apart, and without it
every fixture without a `servers:` block grows a useless `SERVER_1 = '/'`.

**`allOf` / `oneOf` / `anyOf` are declared `Schema[]|Reference[]` and return
`null` when the keyword is absent.** PHPStan believes the declaration, so it
reads an `is_array` guard as redundant and a rector rewrite will happily drop
it — straight into a fatal on most schemas. `SchemaWalk::compositionBranches()`
holds the guard; go through it. Same shape as the widening in
`SchemaType::rawType()`.

**`$openApi->security` is a plain list, not a container.** The fork deleted the
`SecurityRequirements` class cebe had; the scheme names are the requirement's
own keys, read through `getSerializableData()`.

**`$schema->additionalProperties` grants a permission nobody asked for.** JSON
Schema defaults the keyword to `true` and the parser substitutes that default
(`spec/Schema.php`'s `attributeDefaults()`), so a document that wrote nothing
reads back identically to one that wrote `true`. Believing the accessor puts an
extras bag on every object poagen emits — 107 models in kilbil alone.
`getSerializableData()` again reflects only what the document set;
`ObjectShape::declaresOpenExtras()` holds that reading. `false` is a third
state, and still the signal that closes a shape.

## Quality-gate traps

- PHPStan runs at `level: max` with `phpstan-strict-rules`,
  `phpstan-deprecation-rules`, `shipmonk/dead-code-detector` and bleeding-edge,
  in two tiers held to different absolutes — see the
  `analysis-runs-at-maximum-strictness` standard. `phpstan-generated.neon`
  analyses the emitted tree with no baseline, no `excludePaths` and no
  `ignoreErrors` at all: a finding there is fixed in the emitter, never
  annotated away in the output. `phpstan.neon.dist` analyses the generator and
  permits an exemption only where the tool is provably blind, each one carrying
  an inline comment naming the blind spot. Adding an exemption for a real
  finding is forbidden.
- A reflection-only fixture under `tests/Unit/Runtime/Fixtures` — read via
  Reflection or `token_get_all`, never invoked — reads as dead code to three
  separate tools, each acting on it before you see the real complaint. None
  surfaces before the gate rejects the file, so budget for all three the
  first time you write one, not one round at a time. Rector's
  `RemoveEmptyClassMethodRector` deletes an empty method body, exactly the
  body such a fixture wants: throw instead
  (`tests/Unit/Runtime/Fixtures/DocScanTargets.php`'s three methods each
  throw). php-cs-fixer's `modifier_keywords` rule force-adds `public` to a
  bare method, rewriting the token stream a token-scan fixture is pinning
  down: write `public` yourself rather than let the fixer rewrite it under
  you (same file). PHPStan's shipmonk `deadProperty.neverRead` flags a
  constructor-promoted property that exists only to carry a phpdoc type and
  is never read: use a plain, non-promoted constructor parameter instead
  (`tests/Unit/Runtime/Fixtures/Tagged.php`'s `$values`). Measured while
  writing both files, filed as
  `reflection-only-fixtures-fight-the-lint-gate`. `deadProperty.neverRead`
  is not confined to that family: it fires on any ordinary fixture whose
  property a test constructs and never reads.
- Rector and PHPStan can put you in a loop. `ForeachToArrayAllRector`
  rewrites a `foreach` over one of the parser's mis-declared array properties
  into an `array_all` with an `array`-typed closure parameter, and PHPStan
  then reports `function.alreadyNarrowedType` on the guard that rewrite just
  made look redundant — remove the guard and it fatals at runtime. Neither
  tool is wrong on its own terms. Break the loop by moving the guard behind a
  named method; do not fight either tool head-on.
