#import "@local/speconaut:0.1.0": task, done

#show: task.with(
  title: "Round-trip BindsFormat scalar value objects on both send and receive",
  status: done,
  date: datetime(year: 2026, month: 4, day: 19),
  priority: "critical",
  spec: "truth/specs/model-generator.typ",
  decision: "truth/decisions/007-hydration-serialization.typ",
)

== Summary

A user wraps a scalar in `Email { public string $value }` and binds
it via `#[BindsFormat('email')]`. Today `json_encode($contact)`
produces `{"email":{"value":"..."}}` — the whole VO is serialised.
Response hydration has the mirror bug. Request bodies with bound
scalars therefore go out malformed and responses fail to populate.

== Rationale

Pre-release review P0 #3 — release blocker. `#[BindsFormat]` is the
advertised DX hook (ADR-003) for scalar formats; it is unusable until
round-trip is fixed.

== In scope

+ Add a scenario under the Model Generator "User bindings replace
  generated types" rule: serialising a Model with a `#[BindsFormat]`
  VO emits the underlying scalar; hydrating a Model from a payload
  containing the underlying scalar produces a VO instance.
+ Introduce the `ScalarBinding` interface proposed in ADR-007 under
  an appropriate namespace in `src/` (e.g. `src/Runtime/`).
+ Teach the Model emitter / hydrator / body-marshaller to route
  property values through `ScalarBinding::fromScalar()` and
  `::toScalar()` when the bound VO implements it.
+ VOs that do *not* implement `ScalarBinding` keep today's
  whole-object (de)serialization to preserve backwards compatibility
  for complex-format bindings.
+ Update the Petstore fixture profile (if needed) to demonstrate the
  round-trip and regenerate the golden output.

== Out of scope

- Complex-format bindings (e.g. an `Address` VO for
  `format: address`). Those stay on today's object-wrap path.
- Auto-synthesis of `ScalarBinding` for user VOs that are already
  scalar wrappers — users opt in by implementing the interface.
- Hydration of list-of-VO properties — covered indirectly by task
  002 once `PROPERTY_MAP` lands; add a regression test here if it
  does not.

== Acceptance

- The `ScalarBinding` interface lives in `src/Runtime/` (or the
  equivalent chosen path) with a short docblock.
- New scenario in Model Generator is locked by the implementing
  agent.
- A regression test proves both directions of the round-trip for a
  `BindsFormat('email')`-bound `Email` VO.
- Petstore golden fixture regenerated.
- `just check` green end-to-end.
