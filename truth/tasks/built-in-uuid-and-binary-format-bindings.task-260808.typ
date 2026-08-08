#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Give format: uuid and format: binary a built-in scalar binding",
  tags: ("generator", "dx"),
  priority: 2,
  difficulty: 3,
  status: proposed(2026, 8, 8),
)

== Summary

`date-time` and `date` are the only two format values poagen resolves to a
built-in type (`DateTimeImmutable`, T-010). Every other format, including
`uuid` and `binary` on a plain property, falls through `FormatAdvisor`'s
advisory: the property keeps its base string type and a stderr notice tells
the consumer to bind it themselves via `#[BindsFormat]` on their own value
object. That escape hatch already works today, so nothing is silently lost,
but `uuid` and `binary` are common enough on real schemas that asking every
consumer to write their own value object for them is friction poagen could
remove the same way it already did for `date-time`. Left as a post-v0.1
follow-up in `ROADMAP.md`'s exit criteria, filed here now that the roadmap is
retiring, per T-010's own out-of-scope note.

== Acceptance criteria

- A schema with a `format: uuid` property on either a request or response
  schema resolves to a built-in scalar type without the consumer writing a
  `#[BindsFormat]` value object of their own, the same way `format: date-time`
  already does.
- A schema with `format: binary` on a plain property (not a request or
  response body's own content schema, which
  `represent-non-json-request-and-response-bodies` and the binary-stream work
  already cover) gets an equivalent built-in treatment, or an explicit
  decision recorded for why it stays advisory-only.
- `FormatAdvisor`'s notice count drops for any fixture that used to report
  `uuid` or `binary` as unrecognised.
- A regression test locks the new binding for both formats.
- `just check` green end-to-end.

== Non-goals

- Any other unrecognised format kilbil or another fixture happens to use.
  This task is scoped to `uuid` and `binary` specifically, the two named in
  `ROADMAP.md`.
- Changing how `format: binary` is read on a request or response body's own
  content schema. That is `BodyMediaType`'s job and already ships.
- Picking a specific UUID value-object implementation for the consumer
  (`ramsey/uuid`, `symfony/uid`). The built-in binding only needs a canonical
  scalar representation, not a dependency on a UUID library.

== Files

- `src/Generator/Emit/FormatAdvisor.php`
- `src/Generator/Bindings.php`
- `src/Generator/ScalarFormat.php`
