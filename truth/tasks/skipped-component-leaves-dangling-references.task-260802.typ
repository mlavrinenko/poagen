#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "a skipped component leaves dangling references behind it",
  tags: ("generator", "strictness", "skip"),
  priority: 7,
  difficulty: 5,
  status: proposed(2026, 8, 2),
)

== Summary

Found while attempting clear-example-expected-failures. Profile::skip is the only granularity DiscriminatorEnforcer offers for a component the generator cannot represent, and skipping one does not cascade. The component is never emitted, but nothing stops another operation or component from still declaring it as a parameter or property type, so the emitted tree references a class that does not exist. Measured on both large examples: 8 dangling class.notFound PHPStan errors on DigitalOcean, where four skipped config components are still named by databasesPatchConfig, databasesUpdateLogsink, autoscalepoolsCreate and autoscalepoolsUpdate; and 231 on GitHub, where ten skipped components cascade into Issue, Deployment, CheckRun and dozens of Webhook payload models. The referencing operations cannot be skip-listed either, because paogen considers them representable and calls the extra skip entry stale. So skip is unusable on any document where a skipped type is referenced, which is every cross-referential document. This also breaks silence-means-success from the other side: the run completes, reports success, and emits a tree that does not analyse.

== Acceptance criteria

- Skipping a component either refuses the run naming every operation and component that still references it, or cascades so the emitted tree has no dangling reference. Which of the two is the decision this task must make and record, weighed against abort-on-unrepresentable-constructs.
- Skipping the four DigitalOcean config components produces zero class.notFound errors under the generated tier's PHPStan config, or a refusal naming all four referencing operations.
- The same holds for GitHub's ten, where the blast radius is 231 errors across unrelated models.
- An operation that only becomes unrepresentable because a type it names was skipped does not have to be skip-listed by hand, or if it does, paogen stops calling that entry stale.
- A skip that reaches nothing is still reported stale, as today.

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
