#import "@local/speconaut:0.1.0": entity, bounded-context

#let schema-context = bounded-context("schema", layer: "functional")

// What the vendor publishes and paogen only ever reads. Nothing here is ours
// to change — the point of `real-world-schemas` is that the document arrives
// exactly as published.

#let Schema = entity("Schema", props: ())
#let Operation = entity("Operation", props: ())
