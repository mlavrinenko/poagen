#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Purge stale ADR numbers: a reference must name a file",
  tags: ("truth", "process"),
  priority: 5,
  difficulty: 2,
  status: accepted(2026, 8, 2),
)

== Summary

`migrate-adrs-to-decision-artifacts` renamed all ten decision files out of the
`NNN-slug.typ` shape and into `<slug>.decision-<yymmdd>.typ`. It did not rewrite
the prose that cites them by number, so the tree still says "ADR-009" and
"ADR-002" in decisions, standards, live specs, tasks, notes, and in source
docblocks under `src/`.

Nothing resolves those. The number is not in any filename, not in any slot, and
not in any index. Recovering what ADR-009 means takes
`git log --diff-filter=R` against `truth/decisions/`, which is not a reading
anyone should have to do — and the reader who does not do it simply does not
know what the sentence refers to. The owner said so directly on 2026-08-02: "I
don't operate with ADR numbers."

The archaeology, done once so it is not repeated:

#table(
  columns: (auto, 1fr),
  [ADR-001], [`profile-driven-generation.decision-260418.typ`],
  [ADR-002], [`no-inheritance-no-protected-regions.decision-260418.typ`],
  [ADR-003], [`typed-profile-and-colocated-attributes.decision-260418.typ`],
  [ADR-004], [`quality-gates-at-maximum-strictness.decision-260418.typ`],
  [ADR-005], [`schema-fixture-policy.decision-260418.typ`],
  [ADR-006], [`plain-getopt-for-the-cli.decision-260417.typ`],
  [ADR-007], [`hydration-and-serialization-contract.decision-260418.typ`],
  [ADR-008], [`openapi-31-strategy.decision-260419.typ`],
  [ADR-009], [`error-response-policy.decision-260418.typ`],
  [ADR-010], [`attribute-and-phpdoc-driven-serialization.decision-260420.typ`],
)

One citation is worse than unresolvable: `SecurityScheme`'s docblock and
`report-unsupported-security-schemes` both said "ADR-002 puts token acquisition
in the transport". ADR-002 is the no-inheritance decision. It does say auth
belongs behind an injected strategy and that consumers wrap the client with a
decorator, so the claim is a loose paraphrase rather than an invention — but a
reader checking it finds a decision about inheritance and cannot tell whether
the citation is wrong or they are.

== Acceptance criteria

- No artifact under `truth/` and no file under `src/` or `runtime/src/` cites a
  decision by number. Each citation names the decision's slug instead, which is
  greppable and resolves to a file.
- The one substantively wrong citation is corrected, not just renamed: the claim
  about token acquisition now points at
  `operations-delegate-to-an-injected-transport`, which is the decision that
  actually says it.
- `truth/notes/` is included. A note is still something a reader reaches.
- Terminal tasks are rewritten too, since they are the history a later reader
  greps. The rewrite touches citations only — no acceptance criterion, result
  or status changes meaning.
- A grep for `ADR-` across the repository returns only this task.

== Non-goals

- Reopening any decision. This changes how they are referred to, not what any
  of them says.
- Introducing a new numbering or an index file. The slug is the identity.

== Files

- `truth/decisions/`, `truth/standards/`, `truth/specs/`, `truth/notes/`,
  `truth/tasks/`
- `src/Generator/Emit/SecurityScheme.php` and any other docblock that cites a
  number
