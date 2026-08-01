#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Give each example its own Justfile and analysis config",
  tags: ("examples", "tooling", "phpstan"),
  priority: 6,
  difficulty: 5,
  status: done(2026, 8, 1),
)

== Summary

\`phpstan-generated.neon\` deliberately carries no \`paths:\` key. PHPStan hard-errors when a listed path does not exist, and the \`.expected-failure\` examples (\`digitalocean\`, \`github\`) have no \`generated/\` directory to analyse, so \`analyse-example-generated-trees\` moved the real path set into \`Justfile\`'s \`lint-phpstan-generated\` recipe, which nullglob-expands \`tests/fixtures/generated examples/\*/generated\` on the command line. That closed the real gap the task set out to close: every example tree that exists now passes max-level PHPStan with no baseline, no \`excludePaths\`, no \`ignoreErrors\`.

The trade is that the analysed path set is now discoverable only by reading a shell glob inside a Justfile recipe. Running \`phpstan -c phpstan-generated.neon\` directly analyses nothing and fails loudly (which is the documented mitigation), but a reader auditing what the strictest gate actually covers has to read two files to answer a question a single config file used to answer on its own. A residual gap sits alongside it: \`examples/\*/src\` — the hand-written consumer-side code inside \`examples/petstore/src/\` and \`examples/kilbil/src/\` — is covered by \`lint-jscpd-generated\` but by neither PHPStan tier; \`phpstan.neon.dist\` lists only \`bin\`, \`src\`, and \`tests\`.

Today every \`examples/\*/\` directory already carries its own \`composer.json\`; none carries its own \`Justfile\` or PHPStan config. The preferred shape inverts the current one: each example folder owns a \`Justfile\` and a PHPStan config scoped to itself — its \`generated/\` tree at the consumer-view absolute, and its own \`src/\` at whatever level a hand-written consumer file should meet — and checks itself, existing or not, with no special-casing for \`.expected-failure\` examples beyond what already exists. The root \`Justfile\` becomes a thin fan-out that calls into each example's own recipes rather than assembling one global glob-derived path list.

== Acceptance criteria

- Every directory under \`examples/\` carries its own \`Justfile\` (or an included \`just\` module) exposing at minimum a \`check\` (or equivalently named) recipe that analyses that example's own \`generated/\` tree, if it exists, at the same absolute strictness \`phpstan-generated.neon\` enforces today, and its own \`src/\` tree at an explicitly chosen level.
- The root \`Justfile\`'s example-tier recipes (\`lint-phpstan-generated\` and whatever replaces it) call into each example's nested recipe rather than assembling the path list itself; an \`.expected-failure\` example with no \`generated/\` directory is skipped by the example's own recipe noticing its absence, not by the root glob.
- ~~\`examples/\*/src\` gains PHPStan coverage it does not have today, closing the gap \`analyse-example-generated-trees\` explicitly left open.~~ False premise, found while doing the work. That coverage already existed: \`emit-tagged-subclients-with-interfaces\` added \`examples/\*/src\` to the generated tier's path list, with a comment justifying why hand-written consumer code belongs at the consumer's strictness rather than the generator's. And \`analyse-example-generated-trees\` never left this open — its criteria only ever covered \`generated/\`. Nothing to close; the restructuring preserves the coverage instead.
- \`just check\` (or the top-level recipe that currently runs \`lint-phpstan-generated\`) still runs every example's checks and fails the same way a regression in any example tree fails today — no example silently drops out of the gate as a side effect of the restructuring.
- Reading a single example's own \`Justfile\` and PHPStan config is enough to know what strictness that example is held to, with no need to cross-reference the root \`Justfile\`'s glob logic.

== Non-goals

- Does not lower the consumer-view absolute (no baseline, no \`excludePaths\`, no \`ignoreErrors\`) for any example's \`generated/\` tree.
- Does not add new examples or clear the DigitalOcean or GitHub \`.expected-failure\` markers; \`clear-example-expected-failures\` owns that.
- Does not restructure \`phpstan.neon.dist\` or \`phpstan-generated.neon\`'s coverage of \`src/\`, \`bin/\`, \`tests/\`, or \`tests/fixtures/generated\` — those stay exactly as they are; this task's scope is the \`examples/\` tree only.
- Does not change the jscpd generated-tier recipe's path resolution, which already covers \`examples/\*/src\`.

== Files

- \`Justfile\`
- \`phpstan-generated.neon\`
- \`examples/petstore/\`
- \`examples/kilbil/\`
- \`examples/digitalocean/\`
- \`examples/github/\`
- \`truth/tasks/analyse-example-generated-trees.task-260729.typ\`
