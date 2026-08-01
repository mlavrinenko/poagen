#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Wire jscpd as a gate with thresholds on both tiers",
  tags: ("quality", "tooling", "jscpd"),
  priority: 7,
  difficulty: 5,
  status: done(2026, 8, 1),
)

== Summary

\`adopt-jscpd-duplication-gate\` landed jscpd as an instrument, not a gate. \`.jscpd.json\` sets \`minTokens: 50\` (jscpd's own default, adopted rather than measured — the task's own acceptance criterion asked for a value "chosen from a measured run rather than left at the default," and the 50-to-150 sweep in that task's body was the justification for \`minTokens: 84\`, which a same-day follow-up reversed back toward the default for a different reason: \`84\` buried real short clones along with header noise once an \`ignorePattern\` started stripping \`declare\`/\`namespace\`/\`use\` lines directly). \`Justfile:114\`'s \`lint-jscpd\` runs over \`src/\` and \`tests/\`; \`Justfile:126\`'s \`lint-jscpd-generated\` runs over \`tests/fixtures/generated\`, \`examples/\*/generated\`, and \`examples/\*/src\`. Neither recipe is in \`lint\`, and neither passes \`--exit-code\` — both report and never fail, no matter how much duplication they find.

Measured fresh against the current tree: \`src/\` and \`tests/\` together (\`just lint-jscpd\`'s scope) show 90 clones, 4.99% duplicated lines overall — \`src/\` alone at 3.05% across 34 clones, \`tests/\` alone at 7.22% across 50 clones. The generated tier (\`just lint-jscpd-generated\`'s scope) shows 37 clones at 15.11% duplicated lines, 27.24% duplicated tokens — still the worst of the two tiers by a wide margin, though well down from the 36.67% recorded when \`adopt-jscpd-duplication-gate\` landed, mostly because \`collapse-operations-onto-a-runtime-transport\` and \`generated-files-declare-themselves\` have since removed real duplication rather than because any threshold changed.

Duplication in generated output is not merely bloat here — it is diagnostic. The same 12-to-15 token-identical lines repeating across every operation in an emitted client is \`RequestAssembler\`/\`ResponseHandler\` (or whatever replaces them) failing to factor a shared shape into the runtime, which is exactly the kind of architecture smell a consumer-facing tier should surface on its own, independent of whether \`src/\` duplication ever gets fixed. Both tiers need a real, measured, failing threshold — not the same number, since the two tiers mean different things and the generated tier already runs meaningfully hotter than the hand-written one.

== Acceptance criteria

- \`.jscpd.json\` (or a per-tier config, if one config cannot express two different thresholds) sets an explicit \`threshold\` for \`src/\`+\`tests/\` and a separate, higher one for the generated tier, each chosen from a fresh measured run recorded in this task's Result section — not left at jscpd's default and not carried over from the stale 2026-07-30 sweep.
- \`lint-jscpd\` and \`lint-jscpd-generated\` both pass \`--exit-code 1\` (given an explicit value — bare \`--exit-code\` swallows the next positional path argument) and fail when duplication exceeds their tier's threshold.
- Both recipes join \`lint\` (or \`check\`, whichever the existing PHPStan-tier pattern uses) so a regression actually blocks the gate rather than sitting in report-only output nobody reads.
- The task records an explicit ratchet: the threshold is set at or slightly above today's measured figure, with a stated intent and, if practical, a mechanism (a comment, a follow-up task, a recorded schedule) to bring it down over time rather than up. A later change that raises either threshold has to argue for it the same way lowering the analysis strictness would.
- \`minTokens\` itself is revisited only if the fresh measurement shows the current value burying real clones or admitting header noise the existing \`ignorePattern\` should already be catching; if it is left unchanged, the task says why explicitly rather than by omission.

== Non-goals

- Does not remove any further duplication itself; \`deduplicate-the-test-suite\` (still proposed) owns shrinking \`tests/\`, and any generated-tier duplication above the chosen threshold is fixed at the emitter as its own follow-up, not inside this task.
- Does not change the \`ignorePattern\` that strips \`declare\`/\`namespace\`/\`use\` preamble lines from detection; that reversal is settled and working as intended.
- Does not introduce a per-project callback or hook for marking duplication regions; \`guidance-is-data-not-code\` forbids consumer-authored control over generation, and any marker-emission design is out of this task's scope regardless.

== Files

- \`.jscpd.json\`
- \`Justfile\`
- \`truth/tasks/adopt-jscpd-duplication-gate.task-260730.typ\`
- \`truth/tasks/deduplicate-the-test-suite.task-260730.typ\`
