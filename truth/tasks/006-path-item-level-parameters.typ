#import "@local/speconaut:0.1.0": task, proposed

#show: task.with(
  title: "Emit operation methods that account for PathItem-level parameters",
  status: proposed,
  date: datetime(year: 2026, month: 4, day: 18),
  priority: "critical",
  spec: "truth/specs/operation-generator.typ",
)

== Summary

Only `operation->parameters` are scanned today. OpenAPI also allows
parameters at the `PathItem` level (shared across every operation
under that path). Ignoring them produces methods missing required
path or query args — another silent-skip class.

== Rationale

Pre-release review P0 #5 — release blocker. Paired with task 005; both
must land before any non-trivial real-world schema has a hope of
generating correctly.

== In scope

+ Add a scenario under the Operation Generator: when a `PathItem`
  declares a parameter (e.g. `orderId` on `/store/order/{orderId}`)
  and each operation under it does not restate it, each emitted
  method still takes the parameter with the correct type.
+ Extend `OperationAnalyzer` to merge `PathItem::$parameters` into
  the per-operation parameter list, with operation-level entries
  winning on name conflicts (per OpenAPI 3.0.3 §4.8.9).
+ Make sure references resolved by task 005 are honoured at the
  PathItem level too.
+ Regenerate any affected golden fixtures.

== Out of scope

- Hoisting PathItem parameters into a shared base method (future
  optimisation).
- Parameter `style` / `explode` variants that fall outside the
  already-covered cases — those belong to the Operation Generator
  coverage task (001) if they matter.

== Acceptance

- The Operation Generator feature grows the PathItem-parameter
  scenario (promoted from `draft` to `unstable` by the implementing
  agent).
- A fixture schema demonstrating PathItem-level parameters exists
  under `tests/fixtures/schemas/`, with its golden output committed.
- `just check` green end-to-end.
