# kilbil loyalty — acceptance target

The vendor's OpenAPI document for the kilbil loyalty API, committed exactly as
published at <https://docs.kilbil.ru/openapi/loyalty_v1.yaml>. It is not
reformatted, trimmed, or bundled through a normaliser — see the
`fixtures-are-unmodified-vendor-documents` standard.

This example exists because it is hard in the specific ways real documents are
hard, and paogen's claim to work is measured against it rather than against
Petstore.

## What makes it a real test

**OpenAPI 3.1.** Not 3.0. The nullable-array idiom, `const`, and JSON Schema
2020-12 constructs all appear where a 3.0 parser expects something else.

**Inline payloads.** 34 of 36 operations declare their request and response
bodies inline rather than referencing a named component, so there is no
`components/schemas` entry to emit a model from. A generator that only handles
`$ref` payloads emits almost nothing here.

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
