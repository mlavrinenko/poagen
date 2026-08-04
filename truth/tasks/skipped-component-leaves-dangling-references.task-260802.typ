#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "a skipped component leaves dangling references behind it",
  tags: ("generator", "strictness", "skip"),
  priority: 7,
  difficulty: 5,
  status: done(
    2026,
    8,
    4,
  )[Refuse, do not cascade, per the 2026-08-02 ruling. A skip whose type another component or operation still references stops the run, names every referencer, and prints the Profile::\$skip entries that would resolve it ready to paste. Measured rather than assumed: the defect is latent, not live - neither large example names a component in \$skip today, because declare-an-undiscriminated-union-as-raw-data resolved DigitalOcean's four and GitHub's ten through \$unionPins instead. Proved on a constructed fixture covering single and cascaded referencers in both operation and component position, plus staleness in both directions. Gated on the merged HEAD: 555 tests, both floors held.],
)

== Summary

Found while attempting clear-example-expected-failures. Profile::skip is the only granularity DiscriminatorEnforcer offers for a component the generator cannot represent, and skipping one does not cascade. The component is never emitted, but nothing stops another operation or component from still declaring it as a parameter or property type, so the emitted tree references a class that does not exist. Measured on both large examples: 8 dangling class.notFound PHPStan errors on DigitalOcean, where four skipped config components are still named by databasesPatchConfig, databasesUpdateLogsink, autoscalepoolsCreate and autoscalepoolsUpdate; and 231 on GitHub, where ten skipped components cascade into Issue, Deployment, CheckRun and dozens of Webhook payload models. The referencing operations cannot be skip-listed either, because paogen considers them representable and calls the extra skip entry stale. So skip is unusable on any document where a skipped type is referenced, which is every cross-referential document. This also breaks silence-means-success from the other side: the run completes, reports success, and emits a tree that does not analyse.

=== Owner ruling, 2026-08-02

Refuse, do not cascade. A cascade removes operations and models the consumer
never named, which is the silent shrink silence-means-success forbids — that
standard permits exactly one omission, "an omission the consumer asked for by
name". Forty models vanishing behind one skip entry is not that.

So the run stops, and the message does the consumer's work for them: it names
every operation and component still referencing the skipped one, and prints the
skip entries that would resolve it, ready to paste. Erroring and requiring the
consumer to configure generation better is only honest when the generator says
exactly what to configure.

This is orthogonal to `declare-an-undiscriminated-union-as-raw-data`, which
removes the reason the two large examples reach for skip in the first place.
Both are needed: that one makes the common case not need a skip, this one makes
a skip behave when someone does want one.

== Acceptance criteria

- Skipping a component whose type is still referenced refuses the run, naming
  every operation and component that references it, and printing the skip
  entries that would resolve the refusal.
- Skipping the four DigitalOcean config components refuses, naming all four
  referencing operations. Adding the printed entries then produces a tree with
  zero class.notFound errors under the generated tier's PHPStan config.
- The same holds for GitHub's ten, where the blast radius is 231 errors across
  unrelated models.
- An operation that is skip-listed only because a type it names was skipped is
  no longer reported stale. paogen currently calls such an entry stale because
  it judges the operation representable on its own — it has to take the skip
  set into account when deciding that.
- A skip that reaches nothing is still reported stale, as today.
- A decision artifact records refuse-over-cascade with the reasoning above,
  citing silence-means-success.

== Non-goals

- Discriminator inference, or weakening the undiscriminated-union abort. Both examples are blocked on that separately and this task does not touch it.
- The two other emitter defects the same investigation found, which are filed separately.
- Changing what Profile::skip means for an operation, as opposed to a component.

== Files

- src/Generator/Emit/DiscriminatorEnforcer.php
- src/Generator/GenerationPlan.php
- src/Generator/Emit/
- truth/decisions/
- examples/digitalocean/, examples/github/ as the proof surface
