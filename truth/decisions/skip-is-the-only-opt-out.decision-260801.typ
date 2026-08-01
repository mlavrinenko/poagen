#import "@local/speconaut:0.1.0": *
#import "../domain/generation.context.typ": *
#import "../domain/guidance.context.typ": *

#show: decision.with(
  title: "Profile::$skip is the only opt-out from default-deny, and it means omit — never emit-degraded",
  status: accepted(2026, 8, 1),
  contexts: (generation-context,),
  goals: (link("../goals/fail-loud-never-silent.goal.typ"),),
  standards: (link("../standards/silence-means-success.standard-260729.typ"),),
)

== Context

`fail-loud-never-silent` and `silence-means-success` already settle that the
default is refusal: an unhandled construct stops the run rather than
vanishing into a degraded shape. Neither says what the opt-out surface looks
like — only that a relaxation must be "explicit, scoped to the constructs
[the consumer] named, and recorded in their guidance where the next reader
will find it." This decision settles that shape. It is not re-deciding
default-deny, which is already accepted.

Before this change, the rule was not applied uniformly. An unsupported
request body aborted the run (abort-on-unrepresentable-constructs); an
unsupported response content type fell back to `ReturnSpec::void()` and
compiled a method that threw the vendor's body away, silently, at exit 0.
Two constructs the generator could not represent failed differently — the
exact violation `silence-means-success` names outright.

== Choice

There is exactly one opt-out surface: #a(Profile)'s `$skip` map, keyed by
operation id or raw component name, valued by a human-readable reason. A
skip entry means *omit this from the output entirely* — the method or model
does not exist on the emitted client. It never means *emit something that
degrades* — a method whose body throws, whose return type is a lossy
`void`, or whose shape drops part of what the schema declared.

No second surface exists for "emit it anyway, knowing it degrades." A
consumer who wants a construct represented has one path: ask paogen to
support it (a task, upstream). A consumer who does not need it has one path:
name it in `$skip` and it disappears from the client. There is no third
button that produces a method compiling clean at max strictness and failing
only when called — that hollow-but-compiling method is the shape both the
goal and the standard were written to close off, and a second opt-out that
reintroduced it under a different name would undo the fix while looking like
a knob.

This is why the response-content-type fix (default-deny-on-degradation)
route unrepresentable responses through the *same* `SkippedOperation`
mechanism the request-body path already used, rather than inventing a
"lenient" response mode: one mechanism, one meaning, for every construct the
generator refuses.

=== Staleness is part of the same guarantee

`silence-means-success` requires that "when a named omission would now
generate cleanly, the run fails until the consumer removes it." This was
already implemented — `SkipListValidator` cross-checks every `$skip` entry
against what the run actually found unrepresentable this time, and fails the
run naming any entry that no longer matches a live problem, or that names an
operation id or component absent from the schema entirely. Extending
default-deny to responses did not require new staleness logic: the validator
already treats every skip-worthy construct uniformly, request or response,
so a response-side entry that starts generating cleanly is caught by the
exact same check that already caught a stale request-body one.

An opt-out list a consumer never has to prune again is not an opt-out list —
it is a second source of truth that silently drifts from the schema, which
is the same failure `$skip` exists to replace, one layer up.

== Consequences

- Adding support for a construct that used to require a skip entry is a
  breaking change to any profile that still names it — the run fails until
  the consumer deletes the now-stale entry. This is deliberate: it forces
  the profile to track what the generator can currently do, rather than
  accumulating permissions nobody re-examines.
- A consumer cannot silence a whole category (`skip: ["multipart/*"]` or
  similar) — every entry names one operation id or component. A category
  skip would hide the next unrelated construct that happens to share the
  category, which is exactly the blanket-allow shape this decision forbids.
- Nothing here changes what paogen can represent. It only removes the
  silent middle ground between "represented" and "refused."
