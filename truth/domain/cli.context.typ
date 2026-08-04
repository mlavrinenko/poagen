#import "@local/speconaut:0.1.0": entity, bounded-context

#let cli-context = bounded-context("cli", layer: "technical")

// The command surface a consumer actually runs. Thin by design: the CLI
// resolves a profile and hands off, so `cheap-regeneration` stays one command
// rather than a procedure.
//
// Why this is one of four bounded contexts rather than one: see
// "bounded-contexts.md".

#let PoagenCli = entity("poagen CLI", props: ())
