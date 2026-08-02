#import "@local/speconaut:0.1.0": *
#import "../domain/generation.context.typ": *

#show: decision.with(
  title: "A ratcheted, per-package coverage floor replaces the unread coverage recipe",
  status: accepted(2026, 8, 1),
  contexts: (generation-context,),
  goals: (link("../goals/strict-clean-output.goal.typ"),),
  process-only: "governs paogen's own test-gate configuration (what the project's CI enforces about its own coverage), not what the generator produces or what a reimplementation must do",
)

== Context

`quality-gates-at-maximum-strictness` dropped a coverage threshold
deliberately: a hosted service was wired with no bar to clear, which
implied a number nobody enforced, and much of paogen's logic was
exercised through committed golden-output fixtures rather than assertions
a line-coverage figure would credit. It named its own condition for
revisiting that: "when the code surface stabilises, a new decision may
re-introduce a coverage threshold." This is that decision, not a reversal
of it — `quality-gates-at-maximum-strictness`'s rejection of a hosted
service, and its case against outsourcing the judgement to one, both
still hold. Nothing here reinstates a hosted coverage service, and
nothing here touches `quality-gates-at-maximum-strictness`'s phpstan /
cs-fixer / rector / linecop provisions, which stand exactly as written.

What made this the moment to act: a coverage recipe already existed,
called from nowhere — not `just check`, not CI, not any other recipe —
and wrote an HTML report and a clover file nobody read. A recipe that
exists implies a number someone is watching, so its mere presence
answered the question `quality-gates-at-maximum-strictness` left open
without anyone actually deciding anything. That is worse than having no
coverage tooling at all: it manufactures the appearance of a bar with
nothing behind it, the same failure
`quality-gates-at-maximum-strictness` removed the hosted service for.

Before picking any number, the existing figure had to be measured — and
the measurement itself turned out to be wrong, not merely unread. PCOV
auto-detects its instrumentation root (`pcov.directory`) from the working
directory, and on this repository that auto-detection lands on `src/`
alone — verified directly, via `php -i | grep pcov.directory` under the
exact `phpunit --coverage-clover` invocation the old recipe ran.
`runtime/src/` sits outside that auto-detected root and was never
instrumented, so it reported a flat 0.00%: an artifact of the wrong
instrumentation root, not a fact about that package's tests. Measured on
the same commit both ways: as configured, `src/` 87.46%, `runtime/src/`
0.00% (fake), combined 73.35%; with `pcov.directory` set to the repo root
instead, `src/` 87.50%, `runtime/src/` 88.39%, combined 87.64%. Any prior
reading of paogen's coverage that relied on the old recipe's output
inherited that artifact and should be discarded — none is known to have
been recorded anywhere, which is consistent with the recipe having gone
unread.

== Choice

=== Scope: `src/` and `runtime/src/` count; emitted code does not

Coverage is measured over `src/` and `runtime/src/` only. Neither
`tests/fixtures/generated` nor any `examples/*/generated` tree counts
toward the figure. Emitted output is tool product, not something a human
wrote, and it is already gated by other means: the generated-tier PHPStan
config (`quality-gates-at-maximum-strictness`), the byte-stability
fixtures, and the examples drift check. The emitter's own branches — the
code that decides what to emit — are measured on the `src/` side, which is
where they are written. Counting emitted lines would inflate the figure
with code no human wrote, and would move the number whenever a vendor
schema changes rather than when the project's own tests do; excluding it
does not hide whether the emitter's branches are exercised, because those
branches live in `src/`, which is in scope.

Practically, this needs no exclude list of its own: `phpunit.xml.dist`'s
`<source>` element already lists only `src/` and `runtime/src/`, so
nothing under either generated tree ever appears in the coverage report to
begin with.

=== Two floors, not one

`src/` and `runtime/src/` are measured and gated independently, because
`runtime-ships-as-a-separate-package` made the runtime an installable
package of its own. A single blended number would let a regression in
either tier hide behind the other's tests — a drop in the runtime's
coverage could be masked by the generator's larger, better-tested `src/`
tree, or the reverse. Two floors means a regression in either fails on its
own, naming which one.

=== Floor values and ratchet direction

`src/`: 87.0%. `runtime/src/`: 88.0%. Both start just under the
instrumentation-fixed measured figures (87.50% and 88.39%), rounded down
to the nearest half point — enough slack to absorb ordinary test-count
noise, none to admit a real regression. The owner's target is 80%; both
tiers already clear it, so the floor starts above 80 rather than being set
back down to it.

The floors only ever move up — the mirror of the project's duplication
threshold, which only ever moves down. Lowering either number to let a
change land is not a fix, it is disabling the gate: the missing test gets
written, or the floor stays and the change waits. Raising a floor by
writing a test that asserts nothing just to hit the number is exactly as
wrong in the other direction — a floor met that way is worth less than no
floor at all, and is named as its own non-goal. Both values live as
arguments next to a `RATCHET` comment on the `Justfile`'s `test-coverage`
recipe (mirrored in `composer.json`'s `test:coverage`), the same way the
duplication gate's own threshold lives next to its ratchet comment in the
same file — one greppable place per number, not one hardcoded inside
whatever script does the comparing.

=== Where it runs

`scripts/coverage-floor` reads the clover report the instrumented test run
produces, sums statements per tier, and compares each against its floor;
on failure it names the tier, the measured percentage, and the floor it
missed. `just check` now runs `test-coverage` in place of a bare `test` —
the coverage-instrumented run costs a few seconds more than the bare one
(roughly nine against roughly six), so folding the floor into the run the
gate already pays for costs less than running the suite twice for a
recipe nothing else called. `just test` stays the fast, uninstrumented
path for local iteration where coverage isn't the question.
`.github/workflows/continuous-integration.yml` adds one dedicated
`coverage` job that runs `composer test:coverage`; the existing
`unit-tests` matrix (two operating systems times two dependency-version
sets) is left with `coverage: "none"` — the floor is a property of the
code, not of an OS or a dependency version, so measuring it once is
enough, and turning it on across every leg would multiply CI cost for no
additional signal.

== Consequences

- The project's quality gate, and the new dedicated CI job, both fail on a
  coverage regression in either tier, naming which tier and by how much,
  instead of the regression going unnoticed or being caught later by hand.
- `scripts/gate-fresh.inputs` gained a `scripts` entry, since `just check`
  now reads `scripts/coverage-floor` and a recorded gate pass is a claim
  about everything the gate reads.
- Any coverage figure implied by the old, unread recipe — informally or in
  conversation — should be discarded rather than compared against these
  floors: it was measuring the runtime package at a flat, fake 0.00%.
- `quality-gates-at-maximum-strictness` stands unmodified. Its case against
  a hosted coverage service, and against phpstan / cs-fixer / rector /
  linecop baselines, is untouched by this decision — this fills the gap
  `quality-gates-at-maximum-strictness` explicitly left for a future
  decision to fill, once the code surface had stabilised enough for a
  percentage to mean something narrower than "everything, forever."
- Mutation testing remains its own, separate, deferred task, exactly as
  `quality-gates-at-maximum-strictness` named it; nothing here substitutes
  for it or forecloses it.
