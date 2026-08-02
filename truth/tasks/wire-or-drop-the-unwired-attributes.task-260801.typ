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

== Result

All three are deleted, none wired — three separate rulings that happened to
agree, not one blanket sweep. The test each had to pass was whether wiring it
would terminate in a consumer that already exists. None did.

#table(
  columns: 3,
  [*Attribute*], [*What tracing it found*], [*Ruling*],

  [`Deprecated`],
  [No producer and no consumer. Nothing in `src/` reads OpenAPI's `deprecated`
   keyword at all, so wiring it means inventing both ends.],
  [Deleted. Marking a property deprecated is a real feature with a producer, a
   carrier and a reader to design — not a constructor property left switched
   off.],

  [`AdditionalProperties`],
  [Genuinely read generator-side (`InlineObjectResolver`, `PropertySynthesiser`,
   `ResponseAnalyzer`, `TypeListScanner`, `FormatAdvisor`), but only as
   generation-time bookkeeping about types. `Hydrator::hydrate()` builds its
   argument list strictly from declared descriptors and drops every other wire
   key.],
  [Deleted. Giving it runtime meaning needs somewhere on the generated class to
   hold undeclared data, which is an open-object hydration feature and its own
   design decision.],

  [`Schema`],
  [Trivially emittable — `ModelEmitter` already knows the component name — but
   both consumers its docblock named evaporate. `ModelAttributeApplier` bakes
   every discriminator branch's FQCN into a literal array at generation time, so
   `Hydrator` never re-derives a class from a schema name; the "doc generation"
   tool does not exist.],
  [Deleted. Easy to emit is not the same as read by anything.],
)

`phpstan.neon.dist` loses all three `ignoreErrors` entries with nothing replacing
them — the finding is gone because the dead code is gone, not because it is
hidden again. `analysis-runs-at-maximum-strictness`'s `structural:` count drops
from five to two, and the two that remain are the genuine
`tests/generated/*Steps.php` blind spots.
`attribute-and-phpdoc-driven-serialization` is amended rather than rewritten,
following the superseded-section pattern `openapi-31-strategy` set, and now
records a vocabulary of three: `WireName`, `Format`, `Discriminator`.

Two artifacts the deletion made stale were caught afterwards and fixed in the
same change. `CHANGELOG.md`'s `0.1.0` section — unreleased, so it describes what
will ship rather than history — still advertised all six attributes and put the
marshal pair at `src/Runtime/Marshal/`, a path the runtime package split had
already moved. And the decision artifact justified two deletions partly by what
lay outside the implementing task's file boundary; a boundary is a work-splitting
device that does not outlive the task, so those passages were rewritten onto the
design reason that was already underneath them.

Coverage rose on both tiers rather than falling, since the deleted properties
carried none: `src/` 87.46%, `runtime/src/` 88.91%, against floors of 87.0 and
88.0.
