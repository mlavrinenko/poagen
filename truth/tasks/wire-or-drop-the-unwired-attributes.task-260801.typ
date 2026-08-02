#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Wire or drop the three unwired runtime attributes",
  tags: ("runtime", "strictness", "debt"),
  priority: 4,
  difficulty: 5,
  status: wip(2026, 8, 2),
)

== Summary

`attribute-and-phpdoc-driven-serialization` commits the runtime's attribute
vocabulary to six members. Three are wired end to end — `WireName`, `Format` and
`Discriminator` are emitted by `ModelAttributeApplier` and read back by
`DescriptorParser` and `Hydrator`. Three are not: `AdditionalProperties`,
`Deprecated` and `Schema` carry constructor properties nothing writes and
nothing reads, so PHPStan reports each as dead and `phpstan.neon.dist` carries
one `ignoreErrors` entry per class to keep the gate green.

Those three entries are the only ones in the file that are not tool blindness.
`analysis-runs-at-maximum-strictness` permits an exemption where the tool is
provably blind; here the tool is right and the finding is real, so the entries
are recorded debt against an accepted decision rather than a blind spot — the
config says so in its own comment. The audit on 2026-08-01
(`audit-phpstan-generator-exemptions`) confirmed each is still load-bearing:
removing any one produces exactly one live finding.

The standard's stated expectation for the debt count is that it goes down, not
that it stays flat. These three have no plan attached beyond the comment.

== Acceptance criteria

- Each of the three is either wired — the generator emits it onto a model and
  the runtime reads it through reflection, with a test proving the round trip —
  or deleted, and `attribute-and-phpdoc-driven-serialization` is amended to name
  the vocabulary that actually exists.
- Every `ignoreErrors` entry those three classes needed is gone from
  `phpstan.neon.dist`, and the `structural:` count on
  `analysis-runs-at-maximum-strictness` drops to match.
- The decision is recorded per attribute, not as one blanket ruling: an
  attribute that describes a schema construct paogen can already emit is a
  different case from one that does not.
- `just check` passes with no new exemption introduced to replace a removed one.

== Non-goals

- The two `tests/generated/*Steps.php` exemptions, which are genuine tool
  blindness in speconaut-emitted output and stay.
- Changing the PHPStan level, rule sets, or `treatPhpDocTypesAsCertain`.
- Adding a seventh attribute. The vocabulary is closed by decision.

== Files

- `runtime/src/Attribute/AdditionalProperties.php`
- `runtime/src/Attribute/Deprecated.php`
- `runtime/src/Attribute/Schema.php`
- `src/Generator/Emit/ModelAttributeApplier.php`
- `runtime/src/Marshal/DescriptorParser.php`
- `phpstan.neon.dist`
- #link("../standards/analysis-runs-at-maximum-strictness.standard-260729.typ")
