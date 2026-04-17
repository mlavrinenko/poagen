// Domain entities for paogen.

#import "@local/speconaut:0.1.0": entity

// Inputs the generator consumes.
#let Schema          = entity("Schema")
#let Profile         = entity("Profile")
#let ValueObject     = entity("Value Object")

// Mechanisms by which user code talks to the generator.
#let BindsFormat     = entity("BindsFormat attribute")
#let AttributeScan   = entity("Attribute Scan")

// The generator and its outputs.
#let Generator       = entity("Generator")
#let ModelEmitter    = entity("Model Emitter")
#let Client          = entity("Client")
#let Operation       = entity("Operation")
#let Model           = entity("Model")
#let GeneratedFile   = entity("Generated File")
#let UserFile        = entity("User File")

// CLI surface.
#let PaogenCli       = entity("paogen CLI")
