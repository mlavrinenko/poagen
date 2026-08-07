#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Opt-in OmitNullMarshaller for APIs that reject explicit null",
  tags: (),
  priority: 4,
  difficulty: 3,
  links: (related("reconcile-the-kilbil-schema-with-what-the-live-api-actually-sends.task-260805.typ"),),
)

== Summary

Some provider APIs reject a request body that carries an explicit `null` for an
unset optional field: they expect the key to be absent, not null. Kilbil's
`processsale` is the concrete case — a `goods_data` item whose optional `flags`
serialises as `null` is rejected with `result_code` 100 and no `_bill_data`
computed; the identical request with the key omitted succeeds (verified on the
test server 2026-08-06). poagen's default `Marshaller` emits every declared
property, so an unset optional goes out as an explicit `null`.

The downstream Kilbil client (decorado) worked around this with a hand-written
`KilbilRequestMarshaller` that prunes null map entries from the marshaled body.
That fix is generic — many sloppy-but-common APIs share the quirk — and does not
belong in a single consumer. It belongs in the runtime, as an opt-in decorator
any generated client can wrap the default `Marshaller` with.

== Acceptance criteria

- `runtime/src/Marshal/OmitNullMarshaller.php`: a `final readonly` decorator
  implementing `Poagen\Runtime\Contract\MarshallerInterface`, wrapping an inner
  `MarshallerInterface`, whose `marshal()` prunes null-valued MAP entries
  recursively while preserving null LIST positions (a null list position is a
  value, not an unset optional).
- Opt-in only — never the default `Marshaller`. Globally omitting null is wrong
  for a JSON-Merge-Patch API, where absent and null differ. The docblock states
  this.
- Runtime tests cover: null map entry dropped, nested-map null dropped, null
  inside a list preserved, non-null untouched, and a real `Marshaller` round
  trip where an unset optional is omitted and a set one is kept.
- `runtime/src` coverage floor (92.0%) stays green; full `just check` passes on
  a machine with speconaut available.

== Non-goals

- Does not make omit-null the default marshalling behaviour.
- Does not touch the generator (`src/`), emitted code, or model metadata — it
  operates on the already-marshaled array, needing no required/nullable flag.
- Does not rewire any downstream consumer. Swapping decorado's
  `KilbilRequestMarshaller` for this decorator and refreshing the vendored
  runtime mirror is downstream work in that repo.

== Files

- `runtime/src/Marshal/OmitNullMarshaller.php`
- `runtime/tests/OmitNullMarshallerTest.php`
- `runtime/tests/Fixtures/FixedArrayMarshaller.php`
