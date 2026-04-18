#import "@local/speconaut:0.1.0": task, proposed

#show: task.with(
  title: "Built-in DateTimeImmutable mapping for format: date-time (and date)",
  status: proposed,
  date: datetime(year: 2026, month: 4, day: 18),
  priority: "high",
  spec: "truth/specs/model-generator.typ",
  decision: "truth/decisions/007-hydration-serialization.typ",
)

== Summary

`format: date-time`, `format: date`, `format: uuid`, `format: binary`
all degrade to `string` today. The only escape hatch is for users to
define their own VO and bind it via `#[BindsFormat]`. A minimal
built-in `DateTimeImmutable` mapping for `date-time` (and `date`) is
table-stakes.

== Rationale

Pre-release review P1 #9 — coverage gap. Listed in the review's
"suggested ordering" alongside enums as low-effort / high-DX.

== In scope

+ Add a scenario under the Model Generator: a `string` property with
  `format: date-time` is emitted with type
  `\\DateTimeImmutable`, and the hydrator constructs it via
  `new \\DateTimeImmutable($raw)` (or `::createFromFormat` — pick one
  in the implementation task and document).
+ Do the same for `format: date` → `\\DateTimeImmutable` (documented
  as using the date-only format on the wire).
+ Apply the mapping to operation parameters as well as Model
  properties.
+ Route through the `ScalarBinding` contract from ADR-007 so the
  mapping is *the* first in-tree example of how built-ins and
  `#[BindsFormat]` compose.
+ Regenerate Petstore fixture (none of its schemas use `date-time`
  today, so add a minimal synthetic fixture if needed to exercise
  the scenario).

== Out of scope

- `format: uuid` and `format: binary` — file as follow-ups once a
  fixture needs them.
- Time-zone-sensitive parsing policy — document the chosen
  convention and stop (implementation task decides).
- Allowing users to *override* the built-in for a project (e.g. swap
  `DateTimeImmutable` for Carbon). A project-level binding via
  profile is a future nice-to-have.

== Acceptance

- Date-time scenario locked in the Model Generator feature.
- A fixture schema (Petstore or synthetic) exercises a `date-time`
  property in round-trip, with a regression test.
- `just check` green end-to-end.
