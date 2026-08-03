#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "a union response selects its branch",
  tags: ("generator", "strictness"),
  priority: 7,
  difficulty: 5,
  status: accepted(
    2026,
    8,
    3,
  )[Split out of resolve-composition-schemas-in-bodies-and-responses. This is the incoming direction — the only one of the four that needs the undiscriminated-union machinery, and the only one that can end in a refusal no rule resolves.],
  links: (depends-on("declare-an-undiscriminated-union-as-raw-data.task-260802.typ"),),
)

== Summary

Eight GitHub operations are skip-listed because their success response is a
`oneOf` or an `anyOf` and the analyser has no way to say which branch arrived.
Measured on the current tree, all eight are two-branch unions on a 200:

- `oneOf` of two — `users/get-authenticated`, `users/get-by-id`,
  `users/get-by-username`.
- `anyOf` of two — `interactions/get-restrictions-for-org`,
  `interactions/get-restrictions-for-repo`,
  `interactions/get-restrictions-for-authenticated-user`,
  `activity/list-stargazers-for-repo`,
  `activity/list-repos-starred-by-user`.

The skip reason they carry — "200 response has an application/json schema of
type 'unspecified'" — describes the symptom (`SchemaType` finds no `type`
keyword) rather than the cause.

`declare-an-undiscriminated-union-as-raw-data` built exactly the mechanism
these need, and built it for the *property* position: `UnionCatalog`,
`BranchSelectors`, the three resolution layers (a discriminating field computed
from the branches, a tag on the enclosing object via `Profile::$unionTags`, the
closed-shape predicate), `Profile::$unionPins` as the last resort, and a
runtime `UnionBranchPicker` that raises when a payload matches zero branches or
two. All fifteen property-position unions across both documents resolve through
it. Nothing about it is property-specific except where it is wired.

This task wires the response position into it. The expected shape of the work
is a reuse, not a second mechanism — if it ends up as a second branch-selection
path beside the existing one, that is a failure of this task.

The two `activity/list-*` operations are worth a look before assuming
uniformity: they are list endpoints, so their 200 is plausibly a union of two
*array* shapes rather than two object shapes, and an array branch is a
different question from an object branch. Measure it rather than assume it.

== Acceptance criteria

- A `oneOf`/`anyOf` response resolves its branch through the same
  `UnionCatalog` / `BranchSelectors` / `UnionBranchPicker` path the property
  position uses. One mechanism, one set of rules, one runtime picker.
- The emitted return type is the PHP union of the branch classes, and it
  narrows under `instanceof` at the generated tier's PHPStan strictness with no
  suppression.
- A response union no rule resolves refuses at generation time, naming the
  operation, the status and the branches — the same sentence shape the property
  position already uses — rather than emitting something that decides at run
  time.
- `Profile::$unionPins` and `$unionTags` accept a response-position key, are
  stale-checked exactly as the property-position keys are, and are reported on
  every run rather than only the run that added them. A pin is the one guidance
  key whose absence changes the exit status; see
  `record-the-union-pin-as-a-second-opt-out`.
- All eight GitHub entries are removed from the profile if they resolve, or
  each surviving one carries a reason naming the real cause and, where it is a
  pin, a written justification. How many resolve unaided is a measurement to
  take, not a number this task predicts.
- A fixture drives a two-branch response union end to end — one payload per
  branch, plus a payload matching neither and one matching both — proving all
  three outcomes.

== Non-goals

- Re-deciding any of the three resolution layers, or their order. That is
  settled and the property position proves it on fifteen unions.
- `oneOf`/`anyOf` in a request body, which needs no selection at all and is
  `a-union-request-body-takes-a-union-parameter`.
- The status-and-body envelope (`typed-error-responses`), which changes which
  responses get a model at all. This task types the success response the
  generator already looks at; the envelope generalises that to every declared
  status and lands after.
- Reading `discriminator.mapping`. No branch here declares one.

== Files

- `src/Generator/Emit/ResponseAnalyzer.php`
- `src/Generator/Emit/UnionCatalog.php`
- `src/Generator/Emit/BranchSelectors.php`
- `src/Generator/Emit/ResponseTypeEmitter.php`
- `src/Generator/UnionGuidanceValidator.php`
- `src/Generator/Profile.php`
- `examples/github/paogen.php`
- `examples/*/generated/` (regenerated)
- `tests/`
