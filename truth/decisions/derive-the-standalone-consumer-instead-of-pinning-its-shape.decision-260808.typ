#import "@local/speconaut:0.1.0": *
#import "../domain/generation.context.typ": *

#show: decision.with(
  title: "The standalone harness derives its consumer call by reflection instead of pinning its shape as text",
  status: accepted(2026, 8, 8),
  contexts: (generation-context,),
  goals: (link("../goals/typed-injectable-surface.goal.typ"),),
  standards: (link("../standards/caller-surface-is-injectable.standard-260729.typ"),),
  supersedes: (link("standalone-harness-drift-is-caught-offline.decision-260808.typ"),),
)

== Context

`standalone-harness-drift-is-caught-offline` chose option 3 of three named
candidates: pin, inside `just check`,
the two API shapes `scripts/verify-runtime-standalone`'s hand-written
`run.php` depended on — `ApiClient`'s constructor arity and order, and
`getPetById`'s `Envelope`-wrapped return. It explicitly deferred option 2
("stop hand-writing the consumer") to its own task, for a concrete reason:
that task's file boundary excluded `src/` and `examples/petstore/`, and a
`run.php` that stops being hand-written "would have to be synthesised from
the generated API's actual shape."

`generate-the-standalone-harness-consumer-instead-of-hand-writing-it` is
that task, and it names why the pin, though it worked, was the wrong
long-term shape: it asserted against generated *source text* — exact
whitespace, exact parameter names — through `Generator::plan()`. A
php-cs-fixer rule change or a harmless parameter rename neither one breaks
anything real, and both turn the pin red; the fix then looks like "update
the string," which is the reflex that empties a pin of meaning over time.
It also pinned only the two shapes the two historical breaks happened to
change, not the category.

This task's file boundary is narrower still than the previous one's, and
narrower than option 2 as originally scoped: `scripts/verify-runtime-
standalone`, `tests/Integration/StandaloneHarnessTracksGeneratedApiTest.php`,
the `verify-runtime-standalone` Justfile region, and new files under
`tests/Support/` or `tests/Integration/` — again no `src/` and no
`examples/petstore/`. The synthesis the previous decision worried would need
a second code generator turned out not to: `scripts/verify-runtime-
standalone` already builds a real, installed copy of the generated tree in
a scratch composer project before it runs `run.php` against it. Reading
`ApiClient`'s constructor with PHP's own `ReflectionClass`, on the
*installed class*, needs nothing from `src/` — the generator that produced
the class is not even in that scratch project's `vendor/` by design (the
whole point of the check).

== Choice

`run.php` builds its `ApiClient` from `ReflectionClass(ApiClient::class)
->getConstructor()->getParameters()` rather than a literal `new
ApiClient(...)` call. Each parameter is classified by its declared type:
a `TransportInterface`-typed parameter gets the stub transport; a
`string`-typed parameter gets a distinct, traceable placeholder
(`verify-standalone-cred-{$name}`), recorded so the stub transport can
confirm it actually reached the outgoing request (a header value or the
URI) rather than only being accepted by the constructor. The client is then
constructed with PHP's named-argument spread
(`$apiClientClass->newInstance(...$namedArgs)`), so parameter order carries
no meaning and an optional parameter this derivation does not recognise is
simply left at its default rather than rejected.

A parameter that is required, has no recognised type, and has no default
stops the run with a message naming the parameter and its type — the same
`fail-loud-never-silent` discipline the generator itself is held to,
applied here to the derivation's own blind spots rather than pretending
they do not exist.

`getPetById`'s return is asserted, not derived: `$result instanceof
Envelope` fails loudly by name if it is anything else, then `->status` and
`->body` are read and checked — `$pet instanceof Pet`, `$pet->name ===
'Rex'` — never by the absence of a crash, so deriving the call shape does
not cost the result assertion (the trap the task named directly: "a
derivation that reflects the constructor and passes arbitrary strings
positionally proves LESS than the hand-written version if it stops
asserting that the call succeeded and returned the right thing"). This one
shape is *not* tolerant of an alternative: every operation returning a
status-and-body `Envelope` is itself an accepted decision
(`envelope-supersedes-error-response-policy`, 2026-08-04), not one of two
live shapes this harness should shrug at — a `getPetById` that stopped
returning an `Envelope` would mean that decision was reverted, which this
harness must fail on, not adapt to. An earlier version of this change
branched on `$result instanceof Envelope` and read a bare value from the
`else`, which quietly re-opened exactly the drift the deleted test used to
pin; caught before landing and corrected to a hard assertion.

`tests/Integration/StandaloneHarnessTracksGeneratedApiTest.php` is
deleted, not left beside the new derivation as a second, now-redundant
copy of the same two expectations — there is nothing left for it to
usefully pin: the shapes it asserted as source text are exactly the two
shapes `run.php` now follows by reflection instead of hard-coding.

=== What the derivation still cannot catch, and why that is acceptable here

Three gaps, named in `scripts/verify-runtime-standalone` itself so a future
reader meets them at the code rather than discovering them later:

- Each credential placeholder is proven to reach the request *somewhere* —
  a header value or the URI — not the *specific* header or place its own
  security scheme requires. Two same-typed credentials wired to each
  other's header (`apiKey` landing in `Authorization`, `petstoreAuth` in
  `api_key`) would still pass, since both placeholders would still be
  present, just swapped. Closing this would mean reading the OpenAPI
  document's security-scheme declarations at check time, which is a
  step toward option 2's original, larger shape (a second generator-like
  reader) and is out of this task's scope.
- Which sub-client accessor and operation to call (`pet()->getPetById(42)`)
  stays a named, concrete call rather than a derived one — deliberate,
  per this task's own non-goal against generalising past petstore. A
  rename of either now fails with a named message
  (`method_exists` guards ahead of the call) rather than a bare "call to
  undefined method" fatal, which is strictly better than before but still
  not derived.
- The derivation understands exactly two constructor-parameter kinds:
  `TransportInterface` and `string`. An entirely new required parameter of
  any other type — an enum, a value object — is not guessed at; the run
  stops and names the parameter and its type.

None of these were closed by the pin this decision replaces either — the
pin only ever covered the two shapes named at the top of this document,
strictly fewer than what the derivation now proves by construction.

=== Alternatives rejected

- *Widen the pin to cover more shapes.* Keeps every future shape change a
  manual pin-update, and does not touch the brittleness the task named:
  pinning generated source text turns a cosmetic change into a red check
  whose fix looks like updating a string.
- *Read the OpenAPI document at check time to resolve credential-to-header
  mapping precisely.* Would close the swap gap above, but needs the parser
  (`src/`) or a second, independent reader of the same document — outside
  this task's file boundary and closer to the larger option 2 the previous
  decision priced out as its own task.

== Consequences

- `scripts/verify-runtime-standalone`'s `run.php` no longer hard-codes
  `ApiClient`'s constructor call; a change to its arity, order, or
  parameter types that this derivation understands needs no update here at
  all.
- `tests/Integration/StandaloneHarnessTracksGeneratedApiTest.php` is
  removed. Neither of the two shapes it pinned is checked inside
  `just check` any more — both are checked, more completely, inside `just
  verify-runtime-standalone`, which stays outside `just check` per that
  task's own non-goal, unchanged from every decision before this one.
- The recipe's own staleness — nobody running it — is unchanged by this
  decision; it was never this decision's problem to solve, and remains
  whatever `keep-the-standalone-runtime-check-from-rotting-outside-the-
  gate` left it as.
