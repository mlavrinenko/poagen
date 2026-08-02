#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Make a spec sweep for a retired call shape structural, not a guessed word list",
  tags: ("truth", "process", "specs"),
  priority: 3,
  difficulty: 4,
  status: wip(2026, 8, 2)[milestone: trust the instruments, then use them],
)

== Summary

Surfaced by the 2026-08-01 decisions audit, finding 3. An implementer may
accept this one; it needs no owner ruling.

When the transport collapse retired a set of call shapes the specs
described by name, \`two-more-pre-transport-claims\` swept for them using a
hand-picked vocabulary — PSR-18, PSR-17, hydration, baseUri, factories,
credential, ClientInterface — fixed two stale passages, and closed.
\`pre-transport-claims-survive-the-sweep\`, the same day, found seven more the
first list could not have found, because \`sendRequest\`, \`withHeader\`,
\`\$request\` and \`self::hydrate\` were never on it. One of the misses was a
step body asserting the literal negation of the scenario it implemented.

The drift is fully corrected in the tree today. What is not corrected is the
method: the second pass succeeded because it compared the emitted tree's
actual call-shape vocabulary against every mention in the specs, and that
structural comparison is nowhere written down. The next such refactor gets
whatever vocabulary the next agent happens to guess.


== Acceptance criteria

- The structural method is written down where the next sweep will find it —
  derive the vocabulary from the tree rather than from memory, then diff it
  against every mention in the specs.
- It says plainly why the guessed list fails, using the seven misses as the
  evidence, so the next reader does not re-derive the lesson.
- Running the recorded method against the current tree finds nothing, since
  the drift it was written for is already fixed.


== Non-goals

- Re-opening either pre-transport task. Both are closed and both are honest
  about what they missed.
- Building a gate. This is a method a person or agent follows during a
  refactor, not something \`just check\` runs.


== Files

- \`truth/notes/decisions-audit-procedure.md\`, or a standard, or a note of
  its own — deciding which is part of the task.

