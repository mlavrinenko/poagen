#import "@local/mindtape:0.2.0": *

#show: task.with(
  id: "869202f7-f97b-408e-9fff-47032ae3431a",
  title: "Built-in DateTimeImmutable mapping for format: date-time (and date)",
  status: done(2026, 4, 19),
  priority: 7,
  x-paogen: (spec: "truth/specs/model-generator.typ", decision: "truth/decisions/007-hydration-serialization.typ", legacy-id: "T-010"),
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
+ Route through the `ScalarBinding` contract from
  `hydration-and-serialization-contract` so the
  mapping is *the* first in-tree example of how built-ins and
  `#[BindsFormat]` compose.
+ Regenerate Petstore fixture (none of its schemas use `date-time`
  today, so add a minimal synthetic fixture if needed to exercise
  the scenario).

== Non-goals

- `format: uuid` and `format: binary` — file as follow-ups once a
  fixture needs them.
- Time-zone-sensitive parsing policy — document the chosen
  convention and stop (implementation task decides).
- Allowing users to *override* the built-in for a project (e.g. swap
  `DateTimeImmutable` for Carbon). A project-level binding via
  profile is a future nice-to-have.

== Acceptance criteria

- Date-time scenario locked in the Model Generator feature.
- A fixture schema (Petstore or synthetic) exercises a `date-time`
  property in round-trip, with a regression test.
- `just check` green end-to-end.

== Implementation notes

- Hydration uses `new \\DateTimeImmutable($raw)` — permissive ISO-8601 /
  RFC-3339 parsing, no explicit format pinning. `createFromFormat`
  was rejected because OpenAPI `format: date-time` vendors emit
  slightly different RFC-3339 profiles (trailing `Z`, fractional
  seconds, numeric offset) and we want all of them to round-trip.
- Serialisation pins a canonical form on the way *out*: `date-time`
  serialises via `\\DateTimeInterface::RFC3339` (`Y-m-d\\TH:i:sP`),
  `date` serialises via `'Y-m-d'`. Input with fractional seconds is
  preserved by the in-memory `\\DateTimeImmutable` but normalised to
  second precision when re-emitted on the wire — acceptable for v0.1.
- The Petstore fixture already exercises the round-trip via
  `Order.shipDate` (lines 686–688 of the 3.0 YAML); no synthetic
  fixture was needed.
- Composition with `#[BindsFormat]`: built-ins and user bindings flow
  through a single `Bindings::scalarFormat($format)` lookup. A user
  `BindsFormat('date-time')` VO implementing `ScalarBinding` wins
  over the built-in; a non-`ScalarBinding` user VO stays on the
  object-binding path.
- Parameter support: path / query / header parameters with
  `format: date-time` or `format: date` serialise via `format()` in
  the generated `RequestAssembler` output. No petstore operation
  currently exercises this in a parameter slot, so it is covered by
  unit path only, not by a golden-fixture diff.
