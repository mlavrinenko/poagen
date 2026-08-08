#import "@local/speconaut:0.1.0": entity, bounded-context

#let schema-context = bounded-context("schema", layer: "functional")

// What the vendor publishes and poagen only ever reads. Nothing here is ours
// to change — the point of `real-world-schemas` is that the document arrives
// exactly as published.
//
// Why this is one of five bounded contexts rather than one: see
// "bounded-contexts.md".

// Propertyless on purpose: specs read Schema through its nested structure —
// `paths`, `components.schemas` — never through one scalar fact of its own.
// No spec pins a fact like an `openapi` version field today, so declaring
// one here would be a property nothing references.
#let Schema = entity("Schema", props: ())

// `operationId` is the one scalar every operation-generator.feature scenario
// pins by name — the OpenAPI document's own identifier for the operation,
// not a PHP-side invention.
#let Operation = entity("Operation", props: (operationId: str))
