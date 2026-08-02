#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Put a coverage floor in the gate instead of a recipe nobody runs",
  tags: ("quality", "tests"),
  priority: 6,
  difficulty: 4,
  status: done(2026, 8, 1),
)

== Summary

\`just test-coverage\` is defined at \`Justfile\` line 188 and called from nowhere — not by \`just check\`, not by the CI workflow, not by any other recipe. It produces an HTML report and a clover file that nothing reads and no one looks at.

That is worse than having no coverage tooling. A recipe that exists implies a number someone is watching, so nobody asks what the number is. Today nobody knows.

`quality-gates-at-maximum-strictness` dropped codecov deliberately, on the reasoning that a percentage threshold means little on a codegen project whose logic is exercised through generated fixtures. That reasoning still holds against a hosted service and a badge. It does not justify having no floor at all: the argument was against outsourcing the judgement, not against measuring.

The owner wants 80% or better.

== Acceptance criteria

- The current figure is measured and written into this task's Result section, per package or per tier, before any threshold is chosen.
- A floor is enforced by the gate, so a change that drops coverage below it fails rather than being noticed later or never.
- The floor starts at or just under the measured figure and ratchets UP, the mirror of the jscpd thresholds' ratchet-down. Never lower it to admit a regression.
- 80% is the target the ratchet climbs toward; if today's figure is already above it, the floor starts above it rather than being set back down to 80.
- The generated tier is handled deliberately rather than by accident: say in writing whether emitted code counts toward the figure, and why. Counting it inflates the number with code no human wrote; excluding it hides whether the emitter's own branches are exercised.
- Whatever `quality-gates-at-maximum-strictness` still gets right about hosted coverage services is left standing, and this task's departure from it is recorded rather than silently overriding it.

== Non-goals

- Reinstating codecov or any hosted coverage service. `quality-gates-at-maximum-strictness` declined those and this task does not reopen it.
- Mutation testing, which measures something different and has its own task.
- Writing tests to hit a number. A floor that is met by asserting nothing is worth less than no floor.

== Files

- \`Justfile\`
- \`phpunit.xml.dist\`
- \`.github/workflows/continuous-integration.yml\`
- \`CONTRIBUTING.md\`
- \`truth/decisions/\`

== Result

The figure had to be measured before a floor could be chosen, and the
measurement was wrong — not merely unread, which is what this task set out to
fix. PCOV auto-detects its instrumentation root from the working directory and
landed on `src/` alone, so `runtime/src/` was never instrumented and reported a
flat 0.00%. Confirmed directly with `php -i | grep pcov.directory` under the
exact invocation the old recipe ran.

#table(
  columns: 3,
  [], [*As configured*], [*`pcov.directory` at the repo root*],
  [`src/`], [87.46%], [87.50%],
  [`runtime/src/`], [0.00% (artifact)], [88.39%],
  [combined], [73.35%], [87.64%],
)

So the unread recipe was not neutral. Had anyone read it, they would have read a
runtime package with no tests, which is false. Instrumentation is now set
explicitly everywhere coverage runs — the `test-coverage` recipe, `composer
test:coverage`, and CI's new coverage job — rather than left to a default that
depends on where the process started.

Floors: `src/` 87.0 and `runtime/src/` 88.0, set just under the measurement with
minimal slack, as arguments beside a RATCHET comment on the recipe, the same
shape `lint-jscpd`'s `--threshold` already had. Both tiers are above the 80% the
task named, so the floor starts above 80 rather than being set back down to it,
and the ratchet climbs from there.

Two floors rather than one, because the runtime ships as its own package: a
blended figure would let a regression in either tier hide behind the other's
tests. `scripts/coverage-floor` stays generic over tier and floor so each number
has exactly one greppable home.

The generated tier is handled by construction rather than by exclusion:
`phpunit.xml.dist`'s `<source>` lists only `src/` and `runtime/src/`, so emitted
trees never reach the clover report. The reasoning — emitted output is tool
product, already gated by the generated-tier PHPStan config, the byte-stability
fixtures and `just check-examples`, and its branches are the emitter's branches,
measured where they are written — is recorded in
#link("../decisions/coverage-floor-in-the-gate.decision-260801.typ").

It runs where it cannot be skipped: `just check` now runs the suite once under
coverage with the floor enforced instead of a bare `test`, which costs about
three seconds and replaces a second uninstrumented run. `just test` stays the
fast local path. `scripts` joined `scripts/gate-fresh.inputs`, since the gate now
reads a file from it.

The floor was proven to bite rather than assumed to: raising the `src` floor to
99.0 fails `just check` with

\`\`\`
coverage-floor: FAILED
- src: measured 87.46%, below the 99.0% floor
\`\`\`

`quality-gates-at-maximum-strictness` is left standing. It declined a hosted service with no threshold behind
it, and it named its own condition for revisiting — "when the code surface
stabilises, a new decision may re-introduce a coverage threshold." This is that
successor, and nothing here reinstates codecov.
