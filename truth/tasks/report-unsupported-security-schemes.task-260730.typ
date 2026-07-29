#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Report a security scheme the generator cannot wire instead of dropping it",
  tags: ("generator", "security", "strictness"),
  priority: 6,
  difficulty: 3,
  status: proposed(2026, 7, 30),
)

== Summary

`SecurityScheme::fromCebe()` classifies anything it does not wire as
`KIND_UNSUPPORTED`, and `SecuritySchemeCatalog::filterSupportedByName()` then
drops it. After `query-apikey-security-scheme` lands, the set still dropped is
`apiKey` `in: cookie`, `http basic`, `http` with any other scheme name,
`oauth2`, and `openIdConnect`.

A dropped scheme is invisible. The emitted client takes no credential, sends no
credential, and the run reports success — so the consumer learns about it from
the vendor's 401, not from the tool. `silence-means-success` says a run that
completes emitted everything it was asked for, and `fail-loud-never-silent` says
a construct the generator cannot represent stops the run and names itself.
Neither is true here today.

What the reaction should be is a real decision rather than an obvious one, and
that is most of this task. `oauth2` genuinely is not the generator's business —
ADR-002 puts token acquisition and refresh in the transport, and a generated
client that took a bearer token it could not refresh would be worse than one
that took nothing. `http basic` and `apiKey` `in: cookie`, by contrast, are
one header each and are dropped only because nobody wrote them.

So the reaction may differ per kind, but it may not be silence for any of them,
and whatever is chosen has to be one of the reactions the project already
recognises — refuse, or a named omission in `Profile` carrying a reason — not a
fourth undocumented one.

== Acceptance criteria

- A declared security scheme the generator does not wire is reported, naming the
  scheme key, its type, and where it is applied — globally or by which
  operations.
- Whether it is a hard failure follows the profile policy
  `abort-on-unrepresentable-constructs` established, rather than inventing a
  second policy.
- A scheme that is declared but required by no operation and no global
  requirement is not reported. An unused declaration costs the consumer nothing.
- The choice per scheme kind is recorded in a decision citing the goals and
  standards it serves, including the reasoning for treating `oauth2`
  differently from `http basic` if that is where it lands.
- A schema whose only scheme is unwireable does not emit a client that reports
  success and sends nothing.

== Non-goals

- Implementing `oauth2` or `openIdConnect` flows. Token acquisition is
  transport, per ADR-002.
- Credential storage or refresh.
- Re-opening `query-apikey-security-scheme`, which wires the query variant.

== Files

- `src/Generator/Emit/SecurityScheme.php`
- `src/Generator/Emit/SecuritySchemeCatalog.php`
- `src/Generator/GenerationPlan.php`
- `truth/decisions/`
