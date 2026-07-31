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
reimplementation. paogen exempted them, and the exemption had two halves
that must be told apart.

== Choice

Legitimate half: paogen's product is emitted PHP. A signature or an
attribute form is the observable behaviour a scenario asserts, not an
implementation leak. Rephrasing it behaviourally would describe
#the(Generator) by describing nothing.

Debt half: 32 references, counted directly rather than estimated, pointed
at paogen's own tree rather than at anything a consumer observes. Those
were exactly what the rule exists to prevent, and were suppressed to
unblock the migration rather than because they were right. `narrow-the-code-ref-exemption` rewrote all 32 behaviourally rather than leaving them
suppressed. A separate, much larger population — 258 references inside
task artifacts — stays exempt by design, since a task names the
implementation bridge on purpose; an earlier headcount that conflated the
two populations is where this decision used to claim 140, which was
never a measurement of either population and has been corrected.

The exemption is configured explicitly in `.speconaut/config.toml` rather
than the check being switched off, so its reasoning stays legible even
after the debt half is paid down.

== Consequences

- Scenarios, decisions and standards may name a PHP signature, an
  attribute form, or a call shape when that shape is what a consumer of
  #the(GeneratedFile) observes.
- No artifact that describes observable behaviour names a path into
  paogen's own tree any longer; the debt above was rewritten, not merely
  suppressed, and the allowlist in `.speconaut/config.toml` now carries
  only the output vocabulary the Choice section above describes as
  legitimate.
- A decision declaring `process-only:` is the one exception, and it is a
  whole-file exemption the checker derives from that slot rather than
  anything paogen configures. Such a decision is non-portable by
  construction — that is what the slot declares — so genericising a file
  name out of one buys no portability and costs the reader the pointer to
  what is being discussed.
- Task artifacts are unaffected: they are meant to name files, and stay
  exempt from this rule by design rather than by allowlist entry.
