# kilbil loyalty — acceptance target

The vendor's OpenAPI document for the kilbil loyalty API, committed exactly as
published at <https://docs.kilbil.ru/openapi/loyalty_v1.yaml>. It is not
reformatted, trimmed, or bundled through a normaliser — see the
`fixtures-are-unmodified-vendor-documents` standard.

This example exists because it is hard in the specific ways real documents are
hard, and paogen's claim to work is measured against it rather than against
Petstore.

## What makes it a real test

**Declares OpenAPI 3.1, but does not use it.** The version string is `3.1.0`
and that is the whole of it: no `type: [T, "null"]`, no `const`, no
`prefixItems`, no `unevaluatedProperties`. Structurally it is a 3.0 document.

This is worth stating because the opposite was assumed at first, and the
assumption shaped the task backlog before anyone checked. paogen has no version
gate — it never inspects `$openApi->openapi` and never calls `validate()` — so
the document parses cleanly and reaches the emitters. The parser swap is still
worth doing for schemas that genuinely use 3.1, and to drop a patch we carry,
but it is not what blocks this client.

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

## Status

Marked `.expected-failure`. The marker's own text names the three tasks that
have to land before it generates, and `just check-examples` fails if the
generator ever starts succeeding here without the marker being removed — a
stale marker is treated as an error, not a convenience.
