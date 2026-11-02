#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Reconcile the kilbil schema with what the live API actually sends",
  tags: (),
  priority: 8,
  difficulty: 6,
  status: done(
    2026,
    8,
    5,
  )[Fixed against the live test API on 2026-08-05. result\_code widened to type: \[string, integer\] across all 30 200-responses (emits string|int, passthrough, no coercion). SearchClient200Content: \_bill\_data made optional, eight fields nullable, five widened to string|int — each from a real recorded response. Three scrubbed fixtures plus a hydration test. All four live calls verified after the fix. Five mutating endpoints could not be live-verified with a read-only credential; addclient shares searchclient's shape and is recorded in the README as an open risk.],
  links: related(
    "extract-the-kilbil-client-to-its-own-repository.task-260802.typ",
  )[the schema fixes here are what the extracted client carries],
)

== Summary

The kilbil client was exercised against the live test API for the first
time on 2026-08-05, with a real credential. The transport works: query
auth via `h`, JSON encoding, PSR-7/PSR-18 plumbing, enum and nested-model
and list hydration all round-trip. `getclientfullbalance` came back clean.

Two of the three calls still failed, both in hydration, and both because
the vendor's OpenAPI document describes an API the vendor does not
actually serve.

First, `result_code`. The document declares it `type: string`. The wire
sends JSON int `0` from `getprograms` and JSON string `"6"` from
`searchclient` — the same field name, two types, one document. The
runtime decodes by passthrough and constructs under `declare(strict_types=1)`,
so PHP itself rejects the int, and hydration throws before anything else
in the payload is read.

Second, `SearchClient200Content` models only the "client found" shape.
Roughly fifty fields are declared required and non-nullable, because the
document was written against a successful lookup. The real "not found"
response is HTTP 200 with a wall of nulls that omits several of those keys
outright — `_bill_data` first among them — so the constructor fails on its
first missing argument.

Neither is a runtime defect. Both surfaced as a well-formed `ApiException`
carrying a descriptive reason rather than an uncaught crash, which is the
behaviour we want. The document is what is wrong, and this repository's
copy of it is the only thing we control.

This matters more than an example's tidiness: `searchclient` is the single
busiest function in the port map — it backs directory lookup, balance and
cart quoting — so a client that throws on every not-found lookup cannot
back a real integration.

== Acceptance criteria

- `examples/kilbil/schemas/loyalty_v1.yaml` describes `result_code` in a way
  that accepts both the int and the string the API sends, and the emitted
  model hydrates both without throwing. Verified against recorded responses,
  not asserted.
- A not-found `searchclient` response — HTTP 200, mostly nulls, several
  declared-required keys absent — hydrates into a usable object. Fields the
  API genuinely omits are optional and nullable in the document.
- Both shapes are captured under `examples/kilbil/fixtures/responses/` as
  recorded real responses, with a test that hydrates each. The credential
  must not appear in any recorded fixture.
- Every divergence from the vendor's published document is recorded in
  `examples/kilbil/README.md`: which field, what the vendor declares, what
  the API sends, and the date it was observed. A fork nobody wrote down is
  a fork nobody can re-check when the vendor fixes their document.
- The whole document is re-read for the same two classes of defect rather
  than only the three endpoints that happened to be called. `result_code`
  appears on nearly every response; the found-shape-only mistake is likely
  repeated wherever a lookup can miss.
- `just check` stays green, including the generated-tier duplication
  ceilings — a union type may move those numbers.

== Non-goals

- Does not add scalar coercion to the runtime hydrator. Silently accepting a
  type the document forbids would trade a loud, precise failure for a quiet
  wrong value, everywhere, to work around one vendor. If leniency is ever
  wanted it belongs behind an explicit profile binding, filed separately.
- Does not change `runtime/src/`.
- Does not chase endpoints the integration will not call. Breadth is bounded
  by the port map in the consuming project's `api-kilbil.md`.
- Does not report the divergences upstream to the vendor. Worth doing, not
  this task.

== Files

- `examples/kilbil/schemas/loyalty_v1.yaml`
- `examples/kilbil/generated/` (regenerated, not hand-edited)
- `examples/kilbil/fixtures/responses/`
- `examples/kilbil/README.md`
- `scripts/jscpd-generated-baselines`, if the ceilings move
