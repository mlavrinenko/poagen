#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Take the five implementation-file names out of the standards",
  tags: ("standards", "speconaut", "portability"),
  priority: 5,
  difficulty: 4,
  status: proposed(2026, 8, 1),
)

== Summary

\`narrow-the-code-ref-exemption\`'s acceptance criteria said "no spec, decision, standard, or domain artifact names a path under \`src/\`, \`bin/\`, or \`tests/\`." Its closing commit reported a grep sweep measuring 32 references across 8 files under \`truth/specs/\` and \`truth/decisions/\`, and zero under \`truth/standards/\`.

That zero was a measurement of the sweep's own search pattern, not of the property the criterion actually states. The same night, \`give-the-uncovered-standards-an-obligation\` had added \`structural:\` prose to two standards, and that prose names five real implementation files by bare basename: \`caller-surface-is-injectable.standard-260729.typ:28\` names \`ClientConstructor.php\`, \`:32\` names \`SubClientEmitter.php\`; \`guidance-is-data-not-code.standard-260729.typ:23\` names \`Profile.php\`, \`:26\` names \`ProfileLoader.php\`, \`:28\` names \`AttributeScanner.php\`. All five resolve to real files under \`src/Generator/\`. A bare basename carries no \`src/\` prefix, so neither a directory-prefix grep nor speconaut's \`\[check.code-refs\]\` — which matches on the allowlist plus source-extension patterns, not on bare identifiers — catches it. The sweep and the narrowing commit landed the same night the basenames were added, so the tree was declared clean of exactly the thing that had just been introduced.

The five names being right or wrong depends on what the code-reference rule is actually for. If it is about portability — a reimplementation should be able to satisfy every standard without those five files existing — then a bare basename binds a standard just as tightly as a full path, and the standards need rewriting so the next rename of \`ClientConstructor\` does not silently falsify two accepted standards while \`speconaut check\` stays green. If the rule is instead about the allowlist's literal shape — path-prefixed references only — then the narrowing's own acceptance criterion overstated what was achieved and should say so.

This is not a push for portability for its own sake — chasing an implementation-agnostic phrasing everywhere would cost real specificity for no reader benefit. It is that a standard is supposed to state a rule a reimplementation could satisfy differently, not point at the one file that happens to satisfy it today, and here that costs nothing: each \`structural:\` slot can name what the enforcement guarantees (a promoted constructor parameter typed against the transport interface; a value object with no closure-typed field) without naming which class currently provides it.

== Acceptance criteria

- \`caller-surface-is-injectable.standard-260729.typ\`'s \`structural:\` slot describes what enforces the rule (the constructor shape, the interface-per-client emission) without naming \`ClientConstructor.php\` or \`SubClientEmitter.php\` by basename, unless doing so is judged to cost real clarity a rule-level description cannot recover — in which case this task's Result section says so explicitly rather than leaving the question implicit.
- \`guidance-is-data-not-code.standard-260729.typ\`'s \`structural:\` slot is rewritten the same way for \`Profile.php\`, \`ProfileLoader.php\`, and \`AttributeScanner.php\`.
- The scope question is answered explicitly in this task's Result section: whether \`\[check.code-refs\]\` is meant to catch bare basenames too (in which case a follow-up to widen the checker is named) or is deliberately scoped to path-shaped references only (in which case \`narrow-the-code-ref-exemption\`'s acceptance criterion is corrected to say what was actually measured).
- A fresh grep sweep for all five basenames across \`truth/standards/\` and \`truth/domain/\` returns zero, and the sweep's exact pattern is recorded in the Result section so it can be rerun.
- No behavioural claim in either standard's rule body changes; only the \`structural:\` enforcement pointer does.

== Non-goals

- Does not widen the code-reference rewrite to \`truth/specs/\` or \`truth/decisions/\`, which \`narrow-the-code-ref-exemption\` already covers for its exempted vocabulary.
- Does not touch \`truth/tasks/\`, which stays exempt from the code-reference rule by design.
- Does not rename or restructure the five source files themselves; only the standards' references to them.
- Does not add a checker rule for bare basenames unless the scope question above is answered in favour of catching them.

== Files

- \`truth/standards/caller-surface-is-injectable.standard-260729.typ\`
- \`truth/standards/guidance-is-data-not-code.standard-260729.typ\`
- \`truth/tasks/narrow-the-code-ref-exemption.task-260729.typ\`
- \`.speconaut/config.toml\`
