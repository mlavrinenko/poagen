#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Codec bindings for foreign value types",
  tags: ("generator", "runtime"),
  priority: 2,
  difficulty: 4,
  status: proposed(2026, 8, 9),
  links: (related("built-in-uuid-and-binary-format-bindings.task-260808.typ"),),
)

== Summary

A format binding today must be a type poagen can recognise by reflection:
`Marshal\PropertyTypeResolver` reads the property's declared class and tests
`is_a($type, ScalarBinding::class)`. That works for a value object the
consumer writes, because they can implement the interface on it. It does not
work for a type someone else already wrote — `Ramsey\Uuid\UuidInterface`,
`Symfony\Component\Uid\Uuid`, `Brick\Money\Money`, `Carbon\CarbonImmutable`,
`Brick\Math\BigDecimal` — none of which implement poagen's interface and none
of which the consumer can make implement it.

The workaround that ships with `built-in-uuid-and-binary-format-bindings` is a wrapper:
`Format\RamseyUuid` holds the library value, the emitted property is typed as
the wrapper, and reading the real value costs a hop. Acceptable for one
format, wrong as the general answer — it means every third-party type a
consumer wants on a model arrives boxed.

The fix is a second binding shape: a codec, registered for a foreign type,
that converts between the wire scalar and that type without the type knowing
anything about poagen. The emitted property is then declared as the library's
own type, and marshalling routes through the codec.

== Acceptance criteria

- A codec contract in the runtime that names its target type and converts both
  ways, with no requirement on the target type itself.
- The emitted property for a codec-bound format is declared as the target type
  — `public UuidInterface $id`, not a wrapper — and hydration, marshalling and
  response decoding all round-trip it.
- `Profile::$formats` and `$propertyFormats` accept a codec where they accept a
  `ScalarBinding` today, and the validators tell the two apart with a clear
  message when neither contract is satisfied.
- The `uuid` wrappers shipped by `built-in-uuid-and-binary-format-bindings` are re-expressed
  as codecs, or kept and documented as the boxed alternative — decided in this
  task, not left ambiguous.
- Nullable, list and map properties carrying a codec-bound type all round-trip.
- `just check`, `just check-examples` and `just verify-runtime-standalone`
  green end-to-end.

== Non-goals

- Whole-object bindings. A codec converts a scalar to one object; a binding
  that maps a whole JSON object to a class is the existing non-`ScalarBinding`
  path and stays as it is.
- Shipping codecs for any library beyond the ones already covered by
  `built-in-uuid-and-binary-format-bindings`.

== Files

- `runtime/src/Contract/PropertyType.php`
- `runtime/src/Contract/ResponseType.php`
- `runtime/src/Marshal/PropertyTypeResolver.php`
- `runtime/src/Marshal/Hydrator.php`
- `runtime/src/Marshal/Marshaller.php`
- `runtime/src/Http/ResponseDecoder.php`
- `src/Generator/ScalarFormat.php`
- `src/Generator/Emit/WireValueExpr.php`
- `src/Generator/Emit/ReturnSpec.php`
