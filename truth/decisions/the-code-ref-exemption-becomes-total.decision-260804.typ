#import "@local/speconaut:0.1.0": *

#show: decision.with(
  title: "The code-ref exemption becomes total",
  status: accepted(2026, 8, 4),
  goals: (link("../goals/typed-injectable-surface.goal.typ"),),
  supersedes: (link("code-references-permitted-in-generator-specs.decision-260729.typ"),),
  process-only: "governs how paogen's own truth-tree artifacts may reference paogen's tree, not what the generator produces",
)

== Context

`narrow-the-code-ref-exemption` rewrote 32 references to paogen's own tree
behaviourally and dropped the `src/`, `bin/`, and `tests/` entries from
`[check.code-refs] allowlist`, so specs, decisions, standards, and domain
artifacts stopped being able to name a path the way task artifacts always
could. Its third acceptance criterion asked the scope question directly: is
the check meant to widen and catch a bare basename too, or is it
deliberately scoped to path-shaped references alone? Neither happened — no
Result section, no commit, no follow-up.

`code-refs-blind-to-bare-basenames` found the answer the open question
predicted. `caller-surface-is-injectable` and `guidance-is-data-not-code`
named five real files by bare basename — `ClientConstructor.php`,
`SubClientEmitter.php`, `Profile.php`, `ProfileLoader.php`,
`AttributeScanner.php` — inside `structural:` slots, three days after the
tree had been reported swept clean of exactly this kind of reference. A bare
basename carries no `src/` prefix, so the path-shaped matcher walks straight
past it. The five known instances were rewritten; the mechanism that missed
them was not.

== Choice

Owner ruling, 2026-08-02: neither branch of the open question. Portability
of `truth/` across a reimplementation is a low-value property this project
does not pay for, and paogen stops paying for it. The check is not widened
to catch a bare basename, and it is not kept in its narrow path-shaped form
either — the exemption becomes total. An artifact may name a file.

This does not license writing an artifact that only makes sense next to the
current tree. A decision still has to explain itself in prose to someone who
cannot open the file it names — naming the file is a pointer, not the
explanation. This decision does exactly that itself: it names
`src/Generator/Naming/NameNormaliser.php`, a real path under `src/`, as an
illustration rather than the whole of its point, and `speconaut check
truth/` passes with it here. Verified directly, not merely argued: the same
sentence in a decision that does not declare `process-only:` failed the
check under the pre-widening allowlist and passed once the three entries
below were restored, so the pass is the allowlist doing the work, not the
whole-file exemption `process-only:` already carried before this decision.

#link("code-references-permitted-in-generator-specs.decision-260729.typ")[Code references are permitted in paogen's own specs] framed the
`src/`, `bin/`, and `tests/` entries as debt: 32 references paid down by
rewriting them behaviourally, with the allowlist narrowed to output
vocabulary once the rewrite landed. That framing — the legitimate half is
output vocabulary, the rest was debt — is what this decision reverses. The
three entries return to `[check.code-refs] allowlist` in
`.speconaut/config.toml`, not as a stopgap awaiting a further rewrite, but
because naming paogen's own tree is now permitted outright, in every
artifact kind, the same freedom task artifacts had by design from the
start.

== Consequences

- `[check.code-refs] allowlist` carries `src/`, `bin/`, and `tests/` again,
  alongside `(` and `::`. Its comment block says why the three path
  prefixes are total this time rather than describing a debt that no
  longer exists.
- No artifact that already named a file is rewritten to remove it, and none
  is rewritten to add one. `caller-surface-is-injectable` and
  `guidance-is-data-not-code` keep the behavioural phrasing
  `standards-stop-naming-implementation-files` gave their five slots;
  nothing about this ruling asks for the bare basenames back.
- `narrow-the-code-ref-exemption`'s acceptance criterion — that no spec,
  decision, standard, or domain artifact names a path under `src/`, `bin/`,
  or `tests/` — no longer states current policy and is corrected in place
  to say so, rather than left to read as an absolute this project still
  wants.
- The bare-basename blind spot `code-refs-blind-to-bare-basenames` found
  stays unpatched in the checker itself. With the allowlist total, a bare
  basename slipping past the path-shaped matcher costs nothing: a
  fully-spelled path would have been permitted anyway.
- #link("process-only-decisions-may-name-a-file.decision-260801.typ")[A process-only decision may name a file] is unaffected and now
  narrower in what it uniquely grants: every decision gets the same path
  allowance this decision widens, process-only or not, so that decision's
  standing claim is about the rest of what `process-only:` exempts a
  decision from, not about file names specifically.
