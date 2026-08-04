#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Stop enforcing truth-tree portability: let artifacts name code",
  tags: ("truth", "speconaut", "process"),
  priority: 6,
  difficulty: 2,
  status: done(2026, 8, 4),
)

== Summary

Surfaced by the 2026-08-01 decisions audit, finding 2.

\`standards-stop-naming-implementation-files\` found five real files named by
bare basename in \`structural:\` slots — three days after
\`narrow-the-code-ref-exemption\` had reported the tree swept clean of exactly
this. The sweep's check matches path-shaped references, and a bare basename
carries no \`src/\` prefix, so it walked straight past them. The five known
instances were rewritten; the mechanism that missed them was not.

That task's third acceptance criterion required the scope question answered
explicitly: is the code-ref check meant to catch bare basenames too, or is it
deliberately scoped to path-shaped references only? Neither happened — no
Result section, no commit, no follow-up. Verified directly: the
\`\[check.code-refs\]\` allowlist is unchanged and still matches only
path-prefixed patterns.

What binds: every future \`structural:\` slot, decision and spec. The mechanism
meant to keep \`truth/\` portable across a reimplementation has a known blind
spot for exactly the reference an agent reaches for by habit — a bare class
name — and nothing currently catches a recurrence.

=== Owner ruling, 2026-08-02

Neither branch. Portability of the truth tree across a reimplementation is a
low-value property for this project, and paogen stops paying for it: an
artifact may name a file. The check is not widened to catch bare basenames,
and it is not kept in its narrow path-shaped form either — the exemption
becomes total, and the reasoning is recorded so a later reader does not read
the wide allowlist as neglect.

This does not license writing artifacts that only make sense next to the
current tree. A decision still has to explain itself in prose to someone who
cannot open the file it names. Naming the file is a pointer, not the
explanation.

== Acceptance criteria

- The code-ref exemption in \`.speconaut/config.toml\` is widened so a path
  into paogen's own tree is permitted in every artifact kind, not only in
  tasks. Its comment block is rewritten to say why — portability is not a
  goal paogen pays for — instead of describing a debt that no longer exists.
- A decision artifact records the reversal and supersedes
  \`code-references-permitted-in-generator-specs\`, which currently reads as
  "the legitimate half is output vocabulary, the rest was debt". That framing
  is what the ruling reverses.
- \`narrow-the-code-ref-exemption\`'s acceptance criterion is corrected: it
  reads as an unqualified absolute the check never delivered, and the
  absolute is no longer wanted either.
- \`speconaut check truth/\` is green, and a deliberately reintroduced path
  reference in a decision does not fail it — proven by putting one there.
- No artifact is rewritten to remove a file name it already carries, and none
  is rewritten to add one.

== Non-goals

- Rewriting artifacts that currently name files legitimately. Tasks are the
  implementation bridge and are meant to name paths.
- Re-opening \`process-only-decisions-may-name-a-file\`. The \`process-only:\`
  slot keeps its meaning; the ruling makes it less load-bearing, not wrong.
- Any change to the speconaut repository. The exemption is configuration and
  paogen owns it.

== Files

- \`.speconaut/config.toml\`
- \`truth/decisions/\` (a new decision artifact)
- \`truth/tasks/narrow-the-code-ref-exemption.task-260729.typ\`

