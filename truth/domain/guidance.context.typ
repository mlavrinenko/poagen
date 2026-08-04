#import "@local/speconaut:0.1.0": entity, bounded-context

#let guidance-context = bounded-context("guidance", layer: "functional")

// What the consumer writes to steer generation. Every term names something the
// user authors and poagen reads as data — never a template poagen expands, and
// never code that reaches the people who consume the generated client.
//
// Why this is one of four bounded contexts rather than one: see
// "bounded-contexts.md".

#let Profile = entity("Profile", props: ())
#let ValueObject = entity("Value Object", props: ())
#let BindsFormat = entity("BindsFormat attribute", props: ())
#let AttributeScan = entity("Attribute Scan", props: ())
#let UserFile = entity("User File", props: ())
