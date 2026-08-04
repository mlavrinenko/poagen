#import "@local/speconaut:0.1.0": *

#show: decision.with(
  title: "A process-only decision may name a file",
  status: accepted(2026, 8, 1),
  goals: (link("../goals/cheap-regeneration.goal.typ"),),
  process-only: "governs how poagen's own truth-tree artifacts may reference poagen's tree, not what the generator produces",
)

== Context

`narrow-the-code-ref-exemption` forbids naming a path under `src/`, `bin/`,
or `tests/` anywhere under `truth/`, so specs, decisions, standards and
domain artifacts stay portable across a reimplementation. That is right for
anything describing observable behaviour.

#link("plain-getopt-for-the-cli.decision-260417.typ")[Use plain PHP `getopt()` for the CLI] is not that kind of artifact.
It declares `process-only:` — it records why poagen hand-rolls argument
parsing instead of taking a dependency, which is a call about poagen's own
tooling, not about what a reimplementation must do. The narrowing pass still
rewrote its `bin/poagen` and `src/Cli.php` pointers behaviourally to satisfy
the rule's letter, and `process-only-decisions-and-file-names.task-260731.typ`
was filed to decide whether the letter and the purpose actually agree there.

That task ruled that they do not, and that a process-only decision may name a
file — but it recorded the ruling as a `=== Decided 2026-07-31: it may`
section inside its own task body, plus two bullets appended to
#link("code-references-permitted-in-generator-specs.decision-260729.typ")[Code references are permitted in poagen's own specs]. Neither
is a decision artifact of its own. A task is a work item: once it reaches a
terminal status its reasoning is still on disk but effectively off the
decisions graph, and the two appended bullets read as consequences of a
decision about the *specs* exemption, not as the standalone ruling about
process-only artifacts that they actually are. A future reader hits the same
question `process-only-decisions-and-file-names` did, with a task file and a
borrowed pair of bullets to reconstruct the reasoning from rather than a
decision to point at.

== Choice

A `process-only` decision may name a file. It is non-portable by
construction — that is precisely what the `process-only:` slot declares — so
the code-reference rule was never aimed at it. Genericising a file name out
of one buys no portability, because no reimplementation reads a process-only
decision to learn what it must do; it costs the reader the one-hop pointer to
what is being discussed.

The exemption is keyed on speconaut's `process-only:` slot upstream, not on a
poagen allowlist entry. A blanket `src/` (or `bin/`, `tests/`) allowlist
entry would re-exempt every artifact that should stay governed — specs,
non-process-only decisions, standards, domain files — which is exactly the
debt `narrow-the-code-ref-exemption` paid down. Keying the exemption on the
slot instead means only artifacts that have actually declared themselves
non-portable get the exception.

This holds only as long as the upstream behaviour exists. It was filed in
speconaut as `code-refs-exempt-process-only-decisions.task-260731.typ` and
landed there as commit `86103ea6` ("feat(check): exempt process-only
decisions from the code-reference sweep"), merged to speconaut's `main`.
Verified directly against the binary this ruling depends on: `speconaut
check truth/` exits 0 today with `plain-getopt-for-the-cli`'s `bin/poagen`
and `src/Cli.php` pointers restored (see its Consequences section) and
poagen's own `[check.code-refs] allowlist` still narrowed to output
vocabulary alone, `("(", "::")` — no blanket `src/` entry was reintroduced to
make that pass.

That verification is a snapshot, not a permanent guarantee. If a future
speconaut release removes or narrows the `process-only:` exemption in
`check_code_refs.rs`, this decision's Choice no longer holds — the sweep
would start flagging `plain-getopt-for-the-cli` and any other process-only
decision naming a file again — and poagen would need to either restore
upstream parity or configure a local equivalent before this ruling can be
relied on again. The dependency is named here precisely so that regression
is legible rather than a silent, unexplained new failure the next time
`speconaut check` runs.

== Consequences

- #link("plain-getopt-for-the-cli.decision-260417.typ")[Use plain PHP `getopt()` for the CLI] keeps naming `bin/poagen`
  and `src/Cli.php`; no further edit is needed there on account of this
  decision.
- Any future `process-only` decision may likewise name a path into poagen's
  own tree without a matching allowlist entry.
- A decision that does not declare `process-only:` is unaffected: it still
  fails the sweep for any such path, exactly as `narrow-the-code-ref-
  exemption` intended.
- `process-only-decisions-and-file-names.task-260731.typ` points here rather
  than carrying the ruling itself, so the reasoning has one home.
- Should the upstream speconaut exemption regress, this decision is the
  artifact to update or supersede — not a reason to quietly re-widen
  poagen's own allowlist.
