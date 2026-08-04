#import "@local/speconaut:0.1.0": *
#import "../domain/generation.context.typ": *

#show: decision.with(
  title: "Every operation returns a status-and-body envelope, typed per declared response",
  status: accepted(2026, 8, 4),
  contexts: (generation-context,),
  goals: (
    link("../goals/typed-injectable-surface.goal.typ"),
    link("../goals/declared-shapes-become-types.goal.typ"),
    link("../goals/fail-loud-never-silent.goal.typ"),
  ),
  standards: (link("../standards/caller-surface-is-injectable.standard-260729.typ"),),
  supersedes: (link("error-response-policy.decision-260418.typ"),),
)

== Context

`error-response-policy` chose a single generic `ApiException` for every
non-2xx status: one class, `getStatusCode()`, `getRequest()`,
`getResponse()`, and `getDecodedBody(): mixed` — a best-effort `json_decode`
with no shape behind it. That decision was explicit about why: it was a
proof-of-concept call, made before any real vendor document existed to
weigh it against, and it named its own upgrade path — "escalating ... is a
future decision, triggered when at least one validation-tier schema has a
typed error body that consumers want to catch structurally, not by status
code."

kilbil is that schema, measured rather than assumed. Its response surface,
counted directly: 36 of 36 operations declare exactly two statuses, `200`
and `403`. No `default`, no `2XX` wildcard, no operation with two success
statuses, no operation with none. All 72 bodies are `application/json`. The
403 body is byte-identical across all 36 operations —
`{result_code?: integer, result_text?: string}`, no `required` list, both
fields optional — which is exactly the "loosely typed error body"
`error-response-policy` worried a real schema would have, confirmed rather
than feared, and still strictly more than `mixed`.

Under `error-response-policy`, that 403 reached a consumer as
`getDecodedBody(): mixed` on an exception — a status code and an untyped
array, with the schema poagen already parsed thrown away. `typed-error-
responses` filed the question this decision answers: given a real schema
whose error body is worth reading, does the generator keep discarding it.

== Choice

The owner ruling behind `typed-error-responses`, 2026-08-02: the status
code does not change the shape of a response, so it should not change the
shape of the return. Every generated operation returns one envelope —
`Envelope<Status, Body, Response>` — carrying the HTTP status, the body
hydrated into the type the document declared *for that status*, and the
PSR-7 response. A 403 is a body now, not a throw. Nothing about "2xx" is
special: a status the document describes gets a model and a value, exactly
as 200 always did.

`error-response-policy` rejected this shape once already, as option (c), on
the grounds that an `Ok|Err` union is non-idiomatic PHP and forces
`if ($r instanceof Err)` at every call site. That objection targeted a sum
type; `Envelope` is not one. It is a single, always-present class — the call
site reads `->status` and `->body` unconditionally, and a consumer who cares
about one shape narrows once with `instanceof`, the same way they would
narrow any declared union. The rejection stands as history; this decision
supersedes it.

An operation returns one shape, not always a union: the body's static type
is the union of every distinct model the document declares across that
operation's responses, deduplicated before the union is joined, so an
operation with one declared shape has that shape as its body, not a union of
one. Status matching follows OpenAPI's own precedence — an exact status key,
then a range key such as `4XX`, then `default` — and that precedence decides
only which model to hydrate, never whether to throw. A status the document
did not describe at all, or a declared body that fails to hydrate, still
raises: an envelope with an untyped body would be lying about what the wire
said, the one thing `fail-loud-never-silent` does not let an envelope do
quietly.

PHP has no native generics, so the mechanism is the same one a top-level
union response already needed: the emitted method's native return type is
the bare `Envelope` class, and the real union rides a `@return` PHPDoc tag
over an intermediate variable —
`/** @var Envelope<Pet|null> $result */ $result = $this->transport->send(...); return $result;`
— generalised to every operation rather than only the ones a union used to
single out.

Identical inline error schemas still do not collapse on their own. Kilbil's
36 identical 403 schemas emit 36 classes, exactly as
`name-inline-schemas-by-operation-and-status` settled: structural identity
is not identity of meaning, and a generator that merges two shapes because
their fields happen to match invents a domain relationship the document
never stated. The run reports the group on the notice channel with the
`Profile::$inlineModels` block that would merge them; a consumer who wants
one `KilbilError` asks for it by name.

=== Alternatives rejected

- *Escalate to a typed exception per error schema (option (a)).* This was
  `error-response-policy`'s own named alternative, and the ruling passed it
  over rather than taking it: a declared error body is a return value now,
  so there is nothing left for an exception hierarchy to express. Kilbil's
  measured surface — one error shape shared by every operation — is also
  the case this option handles worst: 36 near-identical exception classes,
  or one shared class that stops being an *exception* about anything in
  particular.
- *Keep the generic `ApiException` and add a typed accessor beside it.*
  Leaves the 2xx/non-2xx branch in the emitted method and in every
  consumer's control flow, which is exactly the asymmetry this ruling
  removes: the status stops being the thing that decides whether the call
  unwinds.

== Consequences

- Every generated operation's return type changes, unconditionally: native
  `: Envelope`, `@return Envelope<...>` naming the union the document
  declares. A consumer who read a model directly back from a call now reads
  `->body`, and one who relied on catching `ApiException` for a declared
  error status now reads `->status` and narrows `->body` instead — the
  `ApiException` throw is dropped for any status the document describes,
  and stays only for a status it does not, or a declared body that fails to
  hydrate.
- `examples/kilbil/src/PhoneConfirmation.php` — the hand-written wrapper
  `kilbil-loyalty-client-proof` is measured against — changes with it:
  `isCodeValid()` narrows `->body` to the 200 shape before reading
  `result_code`, where it used to read the field straight off a return
  value the runtime had already guaranteed was a success.
- `Generated\ApiException` survives, narrower than before: it is raised
  only for the two cases an envelope cannot honestly represent — a status
  with no exact, range or `default` entry, and a declared body that fails
  to hydrate — never for a status the document describes, whatever the
  number.
- The runtime's transport contract is unchanged in shape: one call still
  sends a request and returns a value, and `TransportInterface::send()` is
  still the one method a substitute transport implements. What changed is
  what that value is for the common case, not how many calls it takes to
  get it.
