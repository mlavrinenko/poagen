#import "@local/speconaut:0.1.0": entity, bounded-context

#let generation-context = bounded-context("generation", layer: "technical")

// What poagen does and what it leaves on disk. Every term names something the
// generator owns end to end, which is why `never-edit-generated` can hold:
// nothing here has a hand-written counterpart.
//
// Why this is one of four bounded contexts rather than one: see
// "bounded-contexts.md".

#let Generator = entity("Generator", props: ())
#let ModelEmitter = entity("Model Emitter", props: ())
#let Client = entity("Client", props: ())
#let Model = entity("Model", props: ())
#let GeneratedFile = entity("Generated File", props: ())
#let Envelope = entity("Envelope", props: ())
