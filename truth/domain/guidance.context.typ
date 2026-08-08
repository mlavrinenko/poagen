#import "@local/speconaut:0.1.0": entity, bounded-context

#let guidance-context = bounded-context("guidance", layer: "functional")

// What the consumer writes to steer generation. Every term names something the
// user authors and poagen reads as data — never a template poagen expands, and
// never code that reaches the people who consume the generated client.
//
// Why this is one of five bounded contexts rather than one: see
// "bounded-contexts.md".

// `schema` and `discoverIn` are the two Profile fields profile.feature
// dereferences by name — where the document lives, and which namespaces
// AttributeScan walks. Profile carries other knobs (`output`, `namespace`,
// `renames`, …) that no spec pins at property granularity yet; add them
// when a scenario actually needs to say so, not before.
#let Profile = entity("Profile", props: (schema: str, discoverIn: list(str)))

// `value` is the single field the ScalarBinding scenarios in
// model-generator.feature care about: the raw scalar a value object wraps
// and round-trips.
#let ValueObject = entity("Value Object", props: (value: str))

// `format` is the string every `#[BindsFormat(...)]` scenario names — the
// OpenAPI `format` keyword this binding claims.
#let BindsFormat = entity("BindsFormat attribute", props: (format: str))

// Propertyless on purpose: AttributeScan is the walk itself. What it finds
// lands on Profile's binding map, not on a field of the scan.
#let AttributeScan = entity("Attribute Scan", props: ())

// Propertyless on purpose: no spec references UserFile yet, at any
// granularity — inventing a field here would ground it in nothing.
#let UserFile = entity("User File", props: ())
