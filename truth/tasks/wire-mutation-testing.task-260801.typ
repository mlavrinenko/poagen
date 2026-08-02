#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Wire mutation testing, or record why it stays unwired",
  tags: ("quality", "tests"),
  priority: 4,
  difficulty: 6,
  status: done(2026, 8, 2),
)

== Summary

Task 021 was retired as \`done\` without wiring infection, and the roadmap carries mutation testing as a post-v0.1 follow-up on the grounds that the code surface had not stabilised. It has stabilised considerably since: the transport collapse landed, the runtime contracts are declared, and the generator now refuses rather than degrades.

Mutation testing is the instrument that answers the question a coverage floor cannot. Coverage says a line ran. A surviving mutant says the line ran and nothing would have noticed if it were wrong. On a code generator that is the sharper question, because the suite asserts against emitted strings and a weakened assertion still passes while covering every branch — a failure mode this project has already hit once, in the spec whose step body asserted the opposite of its scenario.

This task either wires it or closes the question in writing. What it must not do is leave a third silent deferral.

== Acceptance criteria

- infection is installed, pinned, and runs against \`src/\` with a recorded configuration.
- A first mutation score index is measured and written into this task's Result section, alongside how long a full run takes.
- The runtime is prioritised over the emitters if the full run proves too slow to gate on: name which parts are covered and which are deferred, rather than sampling silently.
- Whether it joins the gate is decided explicitly. If it is too slow, say so with the measured duration and wire it somewhere it will actually run.
- Surviving mutants are triaged at least once, and any that reveal a genuinely weak assertion are filed as their own task rather than fixed inline here.
- If the conclusion is that mutation testing is not worth its cost on this project, that is an acceptable outcome — recorded as a decision artifact with the measurement behind it, not as another deferral.

== Non-goals

- Reaching any particular mutation score. The first run establishes a baseline; improving it is separate work.
- Fixing every surviving mutant found.
- The coverage floor, which is its own task and measures a different thing.

== Files

- \`composer.json\`
- \`infection.json5\`
- \`Justfile\`
- \`truth/decisions/\`
- \`ROADMAP.md\`

== Result

Wired, and deliberately not gated. \`infection/infection\` \`^0.34.1\` is a pinned
dev dependency with the lock committed; \`infection.json5\` covers \`src/\` and
\`runtime/src/\` in one pass. \`just mutate\` runs the full suite,
\`just mutate-fast\` filters to lines changed against \`main\`.

Two full runs on 2026-08-02 at \`--threads=max\`:

#table(
  columns: 6,
  [*Run*],
  [*Wall clock*],
  [*Mutants*],
  [*MSI*],
  [*Killed / escaped*],
  [*Timed out / errored*],

  [1], [7m 14s], [3049], [87.77%], [2517 / 373], [148 / 11],
  [2], [7m 22s], [3049], [87.47%], [2503 / 382], [155 / 9],
)

Per tier, recomputed from \`infection.json\` since infection does not report it:
\`src/\` sits at about 87.9% and is stable; \`runtime/src/\` moved 86.86% to 84.28%
between the two runs. That 2.6-point swing is why no \`--min-msi\` floor is set
yet — a floor under a figure that noisy would fail on its own variance.

Seven minutes against this project's roughly two-minute gate budget settles the
gate question: it stays out of \`just check\` and runs on its own. Nothing was
sampled or deferred to get there; both runs covered everything.

The measurement also caught infection misreporting its own coverage. It claims
"Mutation Code Coverage: 100%, Not Covered: 0", but two mutants it classified as
escaped sit on lines raw \`phpunit --coverage-clover\` records as never executed
(\`Hydrator\` and \`Marshaller\`, both inside \`match\` expressions). Escaped implies
covered, so the two disagree. Recorded in the decision so the next reader does
not take infection's coverage figure at face value on \`match\`-heavy code.

Triage filed two tasks — \`cover-map-kind-round-trip\`, where the \`KIND_MAP\` round
trip never executes at all because no fixture produces a map-shaped property, and
\`cover-methoddocscanner-token-scan\`, the highest-escape file in the run at 24,
pinned by a single substring assertion. A third pattern, 115 of the 382 escapes
being concatenation-order mutants inside generator diagnostic strings, was
reviewed and deliberately not filed, with the reasoning recorded rather than
silently skipped.

Wiring the instrument then exposed a defect in the tests it runs against. The
fixture profiles write their \`output:\` into the committed golden trees, so a
mutant that changes emitted output rewrites the golden with the mutant's version
and leaves it tracked. A single-file run against \`SecurityScheme.php\` left
\`\$ApiKey\` for \`\$apiKey\` in the parameters fixture's \`ApiClient\`; a
\`git commit -a\` afterwards would have shipped mutated output as golden truth
with every byte-stability assertion agreeing, because the golden is what they
compare against. \`scripts/mutation-run\` now refuses to start when a generated
tree is already dirty and restores those trees afterwards whatever the exit
status — both behaviours fired on purpose before being believed. Only the
generated trees are checked rather than the whole worktree, so \`mutate-fast\`
still works on uncommitted changes. That guards one caller; the durable fix is
\`fixtures-generate-to-a-scratch-tree\`.
