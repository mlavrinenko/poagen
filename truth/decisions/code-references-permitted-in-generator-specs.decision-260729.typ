#import "@local/speconaut:0.1.0": *
#import "../domain/generation.context.typ": *

#show: decision.with(
  title: "Code references are permitted in paogen's own specs",
  status: accepted(2026, 7, 29),
  contexts: (generation-context,),
  goals: (link("../goals/typed-injectable-surface.goal.typ"),),
  process-only: "governs how paogen's specs are written, not what the generator produces",
)

== Context

speconaut forbids file paths, member chains, and call shapes in specs,
decisions, standards and domain artifacts, so those layers survive a
reimplementation. paogen exempts them, and the exemption has two halves
that must be told apart.

== Choice

Legitimate half: paogen's product is emitted PHP. A signature or an
attribute form is the observable behaviour a scenario asserts, not an
implementation leak. Rephrasing it behaviourally would describe
#the(Generator) by describing nothing.

Debt half: 140 references point at paogen's own tree rather than at
anything a consumer observes. Those are exactly what the rule exists to
prevent, and they are suppressed to unblock the migration rather than
because they are right. A task tracks narrowing the exemption to the
output vocabulary alone.

The exemption is configured explicitly in `.speconaut/config.toml` with
both halves commented, rather than the check being switched off, so the
debt stays visible.

== Consequences

- Scenarios, decisions and standards may name a PHP signature, an
  attribute form, or a call shape when that shape is what a consumer of
  #the(GeneratedFile) observes.
- References into `src/`, `bin/`, and `tests/` remain allowlisted only
  as recorded debt, not as an endorsed pattern; the allowlist comment in
  `.speconaut/config.toml` says so explicitly.
- Narrowing the exemption to the output vocabulary alone is tracked as
  its own task rather than attempted inline with this decision, so the
  migration this decision unblocks is not itself gated on that cleanup.
