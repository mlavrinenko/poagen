#import "@local/speconaut:0.1.0": entity, bounded-context

#let generation-context = bounded-context("generation", layer: "technical")

// What poagen does and what it leaves on disk. Every term names something the
// generator owns end to end, which is why `never-edit-generated` can hold:
// nothing here has a hand-written counterpart.
//
// Why this is one of five bounded contexts rather than one: see
// "bounded-contexts.md".

// Propertyless on purpose: Generator is a run, not a value — "runs against
// a Profile" is a behaviour every scenario asserts, and nothing about the
// run persists as a field once it ends.
#let Generator = entity("Generator", props: ())

// Propertyless on purpose: ModelEmitter names the role Generator plays
// while walking `components.schemas`; what it produces lands on Model and
// GeneratedFile, not on a field of its own.
#let ModelEmitter = entity("Model Emitter", props: ())

// Propertyless on purpose, now that runtime-context exists: what used to
// read as "the Client's runtime Hydrator" was Client absorbing properties
// that belong to Hydrator and Marshaller instead. What is left — its
// constructor arguments, its methods, its exceptions — is emitted surface,
// not a stored field a scenario dereferences as `Client.x`.
#let Client = entity("Client", props: ())

// Propertyless on purpose: a Model's own properties are whatever the
// schema component declares — `id`, `name`, `shipping`, one set per
// generated class. Fixing a prop set here would hardcode one
// instantiation of a template that varies per document — exactly the
// PHP-mirroring the domain is not supposed to do.
#let Model = entity("Model", props: ())

// `path` is the one fact every scenario across all four specs pins about a
// GeneratedFile — which file, under `Generated/`, got written or read.
#let GeneratedFile = entity("Generated File", props: (path: str))

// `status` and `body` are the two fields operation-generator.feature
// dereferences directly — the HTTP status a response declared, and
// whichever Model (or scalar, or nothing) that status hydrated into.
#let Envelope = entity("Envelope", props: (status: int, body: Model))
