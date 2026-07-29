# kilbil loyalty — acceptance target

The vendor's OpenAPI document for the kilbil loyalty API, committed exactly as
published at <https://docs.kilbil.ru/openapi/loyalty_v1.yaml>. It is not
reformatted, trimmed, or bundled through a normaliser — see the
`fixtures-are-unmodified-vendor-documents` standard.

This example exists because it is hard in the specific ways real documents are
hard, and paogen's claim to work is measured against it rather than against
Petstore.

## What makes it a real test

**Declares OpenAPI 3.1 and uses exactly one 3.1 construct, 87 times.** The
construct is `type: [T, "null"]`, JSON Schema's way of saying nullable:

```
array:["string","null"]  => 48    string:string  => 248   string:object  => 146
array:["integer","null"] => 26    string:integer => 140   string:number  =>  77
array:["array","null"]   => 12    string:array   =>  43   string:boolean =>   9
array:["number","null"]  =>  1
```

Nothing else from 3.1 appears: no `const`, no `prefixItems`, no
`unevaluatedProperties`, no `$defs`, no plural `examples`, and no 3.0-style
`nullable:` either.

Two earlier versions of this file got this wrong in opposite directions, and
both wrong versions informed the backlog, so it is worth being precise about
which part of the original claim held.

The part that held: paogen has no version gate. It never inspects
`$openApi->openapi` and never calls `validate()`, so the document parses
cleanly and reaches the emitters. The parser swap is not what blocks this
client, and `swap-openapi-parser-for-31-support` stays postponed.

The part that did not: this file previously asserted "no `type: [T, "null"]`"
in as many words, and structurally called it a 3.0 document. It is not one.
`cebe/php-openapi` hands the list over verbatim as a PHP array while declaring
`Schema::$type` as `string`, so every `is_string($schema->type)` guard in the
generator missed it and 87 properties the vendor had typed fell through to
`mixed` — with 11 inline enums lost on the same guard. Reading the list needed
no parser swap, only for paogen to read what the parser already handed over;
`nullable-type-arrays` is that work.

**No named components at all.** `components/schemas` is empty. Every payload is
declared inline at its use site: 29 inline JSON request bodies and 71 inline
JSON response schemas across the 36 operations. paogen's model planner works by
walking the component catalogue, so against this document it has nothing to walk
and emits no models whatsoever. Roughly a hundred model names have to be
synthesised, which is what makes the naming rule load-bearing rather than
cosmetic — a collision here silently overwrites an emitted file.

**Cyrillic tags.** All eleven operation tags are Russian words — `Клиенты`,
`Операции`, `Подарочные сертификаты`. Tags become sub-client names, so this
example is what forces tag-to-identifier normalisation and the profile-level
tag renaming that goes with it. A generator that assumes ASCII tags either
emits unusable type names or falls over.

**One tag per operation.** All 36 operations carry exactly one tag and none are
untagged, so the multi-tag and untagged paths need a different fixture to
exercise.

**operationIds that cannot be split by machine.** `searchclient`,
`getclientfullbalance`, `checkconfirmphonecode`, `goodslistxml`. All lowercase,
run together, no separators. `getclientfullbalance` has no algorithmic path to
`getClientFullBalance` without a dictionary, and guessing would produce a
different wrong answer per schema. Two do carry separators — `generate_promocode`
and `legal_info` — so snake_case handling still matters. The honest consequence
is that a readable method name here comes from consumer guidance, not from a
generator heuristic.

**Two XML request bodies.** 32 operations take `application/json`, two take
`application/xml` (`goodsxml`, `goodslistxml`, the XML twins of `goods` and
`goodslist`), and two take no body. Every response on every operation is
`application/json`, so XML is request-only.

**Formats that are mostly not OpenAPI formats.** Nine distinct values across 292
uses: `int` (166), `double` (94), `date time` (15), `date` (9), `phone` (4),
`data time` (3), `time` (2), `email` (2), `data` (1). Only `date` matches a
paogen built-in. `date time` is a misspelling of `date-time` with a space, and
`data`/`data time` look like further typos of it. A generator that silently
ignores an unrecognised format loses 15 timestamps quietly; one that aborts on
each loses the whole client. This is what `report-unrecognised-formats` is for,
and `#[BindsFormat('date time')]` is the mechanism a consumer repairs it with.

**Uniform, tiny error surface.** Every operation declares exactly two responses:
`200` and `403`, both JSON. So the generic `ApiException` is sufficient here and
typed-per-schema exceptions buy nothing — which is why that question stays
deferred rather than guessed at.

**Authentication is a query-string API key.** One security scheme, `h`, of type
`apiKey`, `in: query`, applied globally rather than per-operation. Six other
query parameters exist across the whole document, and there are no path, header,
or cookie parameters at all.

## Status

Marked `.expected-failure`. The marker's own text names the three tasks that
have to land before it generates, and `just check-examples` fails if the
generator ever starts succeeding here without the marker being removed — a
stale marker is treated as an error, not a convenience.
