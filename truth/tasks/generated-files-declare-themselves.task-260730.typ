#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Make a generated file say it is generated, and refuse hand edits",
  tags: ("generator", "dx", "strictness"),
  priority: 6,
  difficulty: 4,
  status: status("needs-review", 2026, 7, 31),
  links: depends-on(
    "collapse-operations-onto-a-runtime-transport.task-260730.typ",
  ),
)

== Summary

Nothing in an emitted file says it is emitted. A reader opening \`examples/kilbil/generated/Generated/TagsClient.php\` sees ordinary PHP, and the only thing standing between them and a hand edit is a rule written down somewhere else. That rule was broken twice in one session: a delegated run edited ten assertions under \`tests/generated/\` after its tooling failed, and reported it afterwards rather than stopping.

Two mechanisms, and they answer different halves.

A header on every emitted file is the cheap half: a comment saying the file is generated, naming the profile that produced it and the command that regenerates it. It survives clone, it shows in a diff, it is the first thing a reader and an agent both see, and it costs one emitter change.

Refusing the edit is the other half and it is not free. Git tracks no write permission beyond the executable bit, so a \`chmod\` is lost on clone and restored by nobody — it can only be applied by the writer, at generation time, which means the writer also has to make files writable again before overwriting them. That is a real behaviour change with a real failure mode: a half-finished run leaving a read-only tree that the next run cannot replace. Worth doing, worth deciding deliberately rather than as a side effect of this task.

\`tests/generated/\` is not paogen's output and cannot be fixed here — its header has to come from the speconaut adapter that writes it.

== Acceptance criteria

- Every file paogen emits carries a header identifying it as generated, naming the profile it came from and the command that reproduces it.
- The header is stable across runs: two consecutive generations still produce byte-identical output, so it carries no timestamp, no version that moves on its own, and no absolute path.
- The header does not break \`just lint-phpstan-generated\` at max level, and does not count as duplication the jscpd config has to work around.
- Whether emitted files are also made read-only is decided explicitly, and if the answer is yes the regeneration path makes them writable again first, proven by a test that regenerates twice in a row over an existing tree.
- \`just check-examples\` reports no drift and all committed trees are regenerated.
- The equivalent gap in \`tests/generated/\` is filed against speconaut rather than patched here.

== Non-goals

- Protected regions, insertion points, or any other mechanism that invites editing part of a generated file. Generated output stays total; the header says so rather than softening it.
- Enforcing anything in CI beyond what the gate already checks.
- Changing what is emitted apart from the header.

== Files

- \`src/Generator/Emit/\`
- \`src/Generator/PlanApplier.php\`
- \`tests/fixtures/generated/\`
- \`examples/petstore/generated/\`
- \`examples/kilbil/generated/\`
