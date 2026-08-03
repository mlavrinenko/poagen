#import "@local/speconaut:0.1.0": *
#import "../domain/generation.context.typ": *
#import "../domain/guidance.context.typ": *

#show: decision.with(
  title: "Profile::$skip is one of two opt-outs from default-deny, and it means omit — never emit-degraded",
  status: accepted(2026, 8, 1),
  contexts: (generation-context,),
  goals: (link("../goals/fail-loud-never-silent.goal.typ"),),
  standards: (link("../standards/silence-means-success.standard-260729.typ"),),
  relates-to: (link("union-pin-is-a-second-opt-out.decision-260803.typ"),),
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

The first opt-out surface is #a(Profile)'s `$skip` map, keyed by operation
id or raw component name, valued by a human-readable reason. A skip entry
means *omit this from the output entirely* — the method or model does not
exist on the emitted client. It never means *emit something that
degrades* — a method whose body throws, whose return type is a lossy
`void`, or whose shape drops part of what the schema declared.

A consumer who wants a construct represented has one path: ask paogen to
support it (a task, upstream). A consumer who does not need it has one path:
name it in `$skip` and it disappears from the client. Until 2026-08-03 there
was no third: no button that produces a method compiling clean at max
strictness and failing only when called — that hollow-but-compiling method
is the shape both the goal and the standard were written to close off, and a
second opt-out that reintroduced it under a different name would undo the
fix while looking like a knob.

=== A second surface, added 2026-08-03

`declare-an-undiscriminated-union-as-raw-data` shipped a second opt-out,
#a(Profile)'s `$unionPins` map, for a property whose union no rule can
decide. It is an opt-out by the same test `$skip` passes and every other
guidance key fails — it is a key whose *absence* changes the exit status —
so `union-pin-is-a-second-opt-out` is a decision in its own right, not a
silent exception to this one. Read it there for the test, the mitigations,
and the condition for admitting a third; it is not restated here.

`$unionPins` does not reintroduce the hollow-but-compiling shape the
paragraph above forbids — it does not compile clean and fail when called,
it answers wrong without ever failing at all, which is a different and
worse shape than the one this decision was written against. It is
permitted anyway, narrowly and with mitigations `union-pin-is-a-second-opt-out`
names in full. There is still no third button: every construct the
generator cannot represent goes through `$skip`, `$unionPins`, or refuses
the run — nothing else.

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
- A second opt-out surface, `Profile::$unionPins`, was admitted on
  2026-08-03 by `union-pin-is-a-second-opt-out`. Nothing above about
  `$skip`'s own shape changed; a reader who wants the reasoning behind the
  second surface follows that decision rather than expecting it here.
