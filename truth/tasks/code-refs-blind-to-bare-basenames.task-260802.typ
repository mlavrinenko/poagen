#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Decide whether the code-ref check should catch a bare implementation-file basename",
  tags: ("truth", "speconaut", "process"),
  priority: 6,
  difficulty: 4,
  status: proposed(2026, 8, 2),
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


== Acceptance criteria

- The scope question is answered in writing, one way or the other: the check
  is widened to catch bare implementation-file basenames, or it is confirmed
  scoped to path-shaped references on purpose.
- If it stays scoped, \`narrow-the-code-ref-exemption\`'s acceptance criterion
  is corrected, since it currently reads as an unqualified absolute the
  check does not deliver.
- If it widens, the widening catches a reintroduced bare basename in a
  non-task artifact and is proven to by putting one there and watching the
  check fail.
- Whichever way it goes, a recurrence is caught by something other than a
  person happening to notice.


== Non-goals

- Rewriting artifacts that currently name files legitimately. Tasks are the
  implementation bridge and are meant to name paths.
- Re-opening \`process-only-decisions-may-name-a-file\`.


== Files

- \`.speconaut/config.toml\`
- \`truth/tasks/narrow-the-code-ref-exemption.task-260729.typ\`
- possibly the speconaut repository, if widening the check belongs upstream

