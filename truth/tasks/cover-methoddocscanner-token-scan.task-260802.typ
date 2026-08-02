#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "MethodDocScanner's attribute-skip and name-scan logic run under no real assertion",
  tags: ("quality", "tests", "runtime"),
  priority: 4,
  difficulty: 3,
  status: wip(2026, 8, 2)[milestone: trust the instruments, then use them],
)

== Summary

Filed from triage in `wire-mutation-testing`: infection's mutation run
against `runtime/src/` found 24 escaped mutants in
`runtime/src/Marshal/MethodDocScanner.php` — the highest count of any
single file in the runtime tier — concentrated in `skipAttributeGroup()`
(lines 122-145, the bracket-depth counter that walks past a `#[...]`
attribute group sitting between a doc comment and its `function`
keyword) and the loop boundary in `readFunctionName()` (line 152).
Escaped mutants there include flipping `++$depth` / `--$depth` to their
opposite and loosening the `while` loop's bound check — none of which
fail any existing test.

This file's only test,
`tests/Unit/Runtime/DescriptorParserFallbackTest.php::testTokenScanRecoversConstructorPhpdocFromFile`,
calls `MethodDocScanner::docFor()` for exactly one method
(`Pet::__construct`) against one fixture file, and asserts that a single
substring appears in the recovered doc comment. `scan()` re-tokenises
the *whole* file and builds a doc-comment map for every method it
contains, but nothing checks that map is built correctly when a file has
more than one method, or has an attribute between a docblock and its
function.

Unlike `cover-map-kind-round-trip`, these lines genuinely execute during
the suite — this is not a coverage gap, it is an assertion gap: the
scanner runs, but nothing checks the index arithmetic it depends on is
right. A bug here would surface as a phpdoc silently attributed to the
wrong method, or lost entirely, and only under `opcache.save_comments=0`
— a production-only condition this project's own CI does not exercise on
every run, per the existing test's `markTestSkipped` guard when OPcache
is absent from the CLI SAPI.

== Acceptance criteria

- A new test (or an extension of `DescriptorParserFallbackTest`) scans a
  fixture file containing at least: two methods with distinct docblocks,
  one method preceded by a `#[...]` attribute sitting between its
  docblock and the `function` keyword, and one method with no preceding
  docblock at all — and asserts each method's recovered doc (or the
  absence of one) individually, not a single substring on a single
  method.
- The `skipAttributeGroup` and `readFunctionName` mutants that currently
  escape (see `build/logs/infection-per-mutator.md` from the 2026-08-02
  run recorded in `wire-mutation-testing`, or re-run
  `infection run --filter=runtime/src/Marshal/MethodDocScanner.php`) are
  killed by the new test.

== Non-goals

- Rewriting `MethodDocScanner`'s algorithm or improving its performance.
- Chasing every escaped mutant in this file — some may be genuinely
  equivalent (e.g. a mutant that only changes behaviour on malformed PHP
  `token_get_all` would never see in practice); judge case by case rather
  than forcing every one to a kill.
- The map-kind round trip in `Hydrator` / `Marshaller`, which is its own
  task (`cover-map-kind-round-trip`) filed from the same triage pass.

== Files

- `tests/Unit/Runtime/DescriptorParserFallbackTest.php` (or a new sibling
  test file)
- `tests/Unit/Runtime/Fixtures/` — likely a new fixture class carrying
  the multi-method, attributed shape the new assertions need

== Result

A new fixture, `DocScanTargets`, carries the three shapes in one file: a plain
docblock, a docblock separated from its `function` keyword by a
`#[Tagged(['a', 'b'])]` attribute with a nested-bracket argument, and a method
with no docblock at all.
`DescriptorParserFallbackTest::testScanRecoversDistinctDocsAcrossMethodsAttributesAndMissingDocs()`
scans it through `MethodDocScanner::docFor()` and asserts each method's
recovered doc individually, so a doc lost or mis-attributed on one method fails
on its own rather than riding on another's assertion. No OPcache guard was
needed: `docFor()` bypasses `DescriptorParser`'s opcache-conditional fallback and
always runs its token scan, confirmed by the file running four of four tests
with none skipped.

Escaped mutants on `MethodDocScanner.php` fall from a baseline of 18 to a range
of 7 to 10. The range is not sloppiness — the run was repeated four times against
identical committed source to separate the stable core from the fringe, and the
worst figure is the one reported. That variance is the same run-to-run noise
`mutation-testing-stays-out-of-the-gate` already measured and is another reason
it stays out of the gate.

The survivors were judged case by case rather than forced to a kill, and each
was argued equivalent: the line 92 `&&` mutants differ only by writing an
explicit null where the key would be absent, which `docFor()`'s null-coalescing
return cannot distinguish; the line 125, 144 and 152 index nudges land on
whitespace or visibility tokens the scanner already treats as no-ops; and the
line 127 and 152 `<` to `<=` mutants only diverge when the scan runs past the
physical end of the token array, unreachable for any syntactically complete
reflectable method. Two `++$i` flips time out under mutation testing regardless
of this change and predate it.
