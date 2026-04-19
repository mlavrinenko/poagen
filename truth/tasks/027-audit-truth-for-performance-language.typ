#import "@local/speconaut:0.1.0": task, proposed

#show: task.with(
  title: "Audit truth/ for performance-flavoured constraints superseded by ADR-010",
  status: proposed,
  date: datetime(year: 2026, month: 4, day: 20),
  priority: "normal",
  spec: "truth/specs/model-generator.typ",
)

== Summary

ADR-010 (2026-04-20) explicitly subordinates runtime performance to
clean interface and output. A number of pre-ADR-010 specs and
decisions hardcode performance-flavoured reasoning — e.g. "data-
driven hydration instead of reflecting", "reflection is the
performance failure mode", "adds a phpdoc parser to the consumer's
runtime" — that no longer reflects project direction.

This task audits `truth/specs/**.typ` and `truth/decisions/**.typ`,
catalogues every such passage, and either revises the wording to
match ADR-010 or (for load-bearing ADRs like ADR-007) annotates them
with a "superseded-in-part by ADR-010" banner.

Auditing is strictly about *language and design intent*. No code
changes. The implementation follow-up lives in T-028.

== Rationale

- Future contributors should not be able to cite a pre-ADR-010 line
  about "reflection cost" as a reason to reject a cleaner design.
- `speconaut check` and golden-tree drift should stay green through
  this pass because only prose changes.

== In scope

+ *Grep pass.* Search `truth/specs/` and `truth/decisions/` for
  performance-flavoured phrases:
  - "runtime cost"
  - "without reflection" / "not reflection"
  - "data-driven instead of" / "data-driven rather than"
  - "reflection cost" / "reflection failure mode"
  - "adds a … parser to the consumer's runtime"
  - "avoid parsing at runtime"

+ *Per-hit decision* — one of:
  - *Revise* the surrounding paragraph to state the current policy
    (clean output first, perf is a separate follow-up) while
    preserving the load-bearing factual content.
  - *Supersede-mark* ADR-007 (the headline pre-010 document) — add a
    one-line banner at the top of ADR-007 stating that its
    representation choice is superseded by ADR-010. Keep the
    contract portion intact.
  - *Leave* — if the hit is historical context (e.g. "the prior
    representation was chosen for performance reasons") that makes
    sense to preserve as record.

+ *Report* the catalogue as a markdown table in the task completion
  note so reviewers can see every change at a glance.

== Out of scope

- Any `src/` change. Performance adjustments at the code level are
  T-028's concern.
- Re-opening ADR-007's decision. That ADR's *contract* remains
  authoritative; only its *representation* is superseded.

== Acceptance

- `just check` stays green.
- No pre-ADR-010 performance-flavoured passage remains unmarked in
  `truth/decisions/**` or `truth/specs/**`.
- The completion note lists every revised passage with before/after
  excerpts.
