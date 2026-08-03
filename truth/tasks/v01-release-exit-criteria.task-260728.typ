#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Close the outstanding v0.1 release criteria",
  tags: ("release",),
  priority: 3,
  difficulty: 2,
  status: proposed(2026, 7, 28),
)

== Summary

`ROADMAP.md` ticks every phase and leaves six unticked exit criteria under
"v0.1 exit criteria". Read against the current tree on 2026-08-03, three of the
six are already true, two are stale in their own right, and one is real work.
The list has to be reconciled before it can be closed, and this task is that
reconciliation — not a licence to tick boxes.

Criterion by criterion, as the file writes them:

+ *`just check` green on PHP 8.4 with zero deprecation notices.* Green as of
  2026-08-03. "Zero deprecation notices" was never verified as a distinct
  claim; verify it rather than infer it from the exit status.
+ *Petstore golden fixture regenerated and committed after every scope change.*
  True and mechanised — `tests/Integration/ByteStabilityTest.php` fails the
  gate if it drifts, so this criterion is enforced rather than remembered. Tick
  it and say what enforces it.
+ *`speconaut status` shows no pending tasks listed in this document.* Stale.
  This project's task status lives in MindTape, not in speconaut, and the
  `T-NNN` mapping the roadmap describes no longer holds — `adr-purge` removed
  the numbering the criterion depends on. Rewrite against `mt ls` or drop it,
  and record which.
+ *README "known limitation: OpenAPI 3.1 not yet supported" note kept.* False,
  and keeping it would be the defect. `swap-openapi-parser-for-31-support`
  landed 3.1 through `devizzent/cebe-php-openapi`, with five 2020-12
  constructs aborting by name. The criterion, the README note it protects, and
  `truth/notes/openapi-3.1-gap.md` all need reconciling against what the parser
  actually supports now. Check `openapi-31-strategy` has been superseded rather
  than assuming it.
+ *`CHANGELOG.md` gains a `0.1.0` section.* Real work, and the only one of the
  six that is.
+ *`composer.json` stability flipped to `stable`.* Ambiguous and probably
  already satisfied by accident: `"minimum-stability": "stable"` is set in both
  `composer.json` and `runtime/composer.json`, but that key controls dependency
  resolution, not the package's own maturity. What the criterion means — if it
  means anything — is a `0.1.0` tag, and `publish-the-runtime-package-to-packagist`
  owns that for the runtime. Decide what it means for paogen itself, which is
  deliberately not published yet, and rewrite or drop it.

The load-bearing point: this list should not gate on anything the goals do not
require. A criterion nobody can satisfy or falsify is worse than no criterion,
because it makes the release look blocked by process.

== Acceptance criteria

- Each of the six criteria is ticked, rewritten, or dropped, and every rewrite
  or drop carries its reason in the file itself — not only in the commit
  message, which the next reader will not have.
- `just check` is confirmed to emit zero deprecation notices, by reading the
  output rather than the exit status.
- `CHANGELOG.md` gains a `0.1.0` section accurate against what shipped, built
  from `git log` and the closed tasks rather than from memory.
- The README's OpenAPI 3.1 limitation note says what is true after the parser
  swap: 3.1 is supported, and which 2020-12 constructs abort by name.
  `truth/notes/openapi-3.1-gap.md` either says the same or is retired, and
  `openapi-31-strategy` is confirmed superseded or superseded here.
- `ROADMAP.md` is retired per its own closing rule, with every remaining item
  filed as a task first. A roadmap item that becomes a task is linked from the
  commit that files it.
- No criterion is ticked whose evidence is this task's own assertion. Each tick
  names the thing that proves it — a test, a recipe, a command with its output.

== Non-goals

- Publishing paogen to Packagist. The owner deferred it until the generator's
  capability is proven; `publish-the-runtime-package-to-packagist` covers the
  runtime only.
- Shipping any feature currently sitting in the backlog. If a roadmap item
  turns out to be unshipped work, it becomes a task and the release criterion
  drops the dependency on it or does not — but this task does not implement it.
- Creating `ROADMAP-v0.2.md`. The retiring rule mentions it; whether v0.2 gets
  a roadmap at all is a separate question now that the backlog is in MindTape.

== Files

- `composer.json`, `runtime/composer.json`
- `CHANGELOG.md`
- `ROADMAP.md`
- `README.md`
- `truth/notes/openapi-3.1-gap.md`
