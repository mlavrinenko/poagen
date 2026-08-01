#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Scope a format binding to a property, not the whole document",
  tags: ("generator", "dx", "naming"),
  priority: 4,
  difficulty: 6,
  status: proposed(2026, 8, 1),
)

== Summary

A `#[BindsFormat]` value object is keyed on the format string alone and applies
document-wide, so a format the vendor spends on several meanings cannot be bound
at all. On the kilbil document `double` covers `price`, `quantity`,
`bonus_percent` and `purchases_sum` alike: a `Money` bound to `double` would type
every non-money double as money, which is worse than the float it replaces. So
the example ships money as a PHP `float` and says so plainly in its README
(`bind-kilbil-numeric-formats`). That is an honest answer to a missing surface,
not a fix — money in a float stays a defect the consumer inherits.

The profile already scopes guidance below the document elsewhere: discriminators
are keyed by schema path, renames by component name. Per-property scoping is a
shape this codebase already has.

== Acceptance criteria

- The profile accepts a format binding scoped to one property of one model,
  keyed so it cannot reach a same-named property on a different model.
- An unscoped binding is emitted exactly as today, byte for byte.
- A scoped binding round-trips: hydration and marshalling still key on the wire
  name and the wire format, and only the PHP surface changes.
- A scoped binding naming a model or property absent from the schema fails the
  run with a diagnostic naming both, per `fail-loud-never-silent`.
- `examples/kilbil/` binds a `Money` value object to the price property alone,
  and its README stops recording float money as acceptable.

== Non-goals

- Inferring which properties are money. The vendor did not say, and a guess that
  moves between runs is what `cheap-regeneration` forbids.
- Renaming the property, which `property-name-renaming-guidance` owns.
- A built-in paogen binding for `int` or `double`. They are not OpenAPI formats
  and the generator keeps reporting them.

== Files

- `src/Generator/Profile.php`
- `src/Generator/Bindings.php`
- `src/Generator/AttributeScanner.php`
- `src/Generator/Emit/`
- `examples/kilbil/`
