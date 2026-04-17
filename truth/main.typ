// paogen — unified knowledge entry point.
// Compiles specs + decisions into one document. Tasks are discovered
// automatically from truth/tasks/ when present.
//
// Every spec and decision file MUST be included here.
// Run `speconaut check` to detect missing includes.

#import "@local/speconaut:0.1.0": *
#import "domain.typ": *

#set document(title: "paogen — Source of Truth")
#set text(size: 10pt)
#set page(margin: 2cm, numbering: "1")

#align(center)[
  #text(size: 22pt, weight: "bold")[paogen]
  #v(0.3em)
  #text(size: 11pt, fill: rgb("#6B7280"))[
    OpenAPI-driven PHP client generator.
  ]
]

#v(1em)

// --- Specifications ---

#text(size: 16pt, weight: "bold", fill: rgb("#5B21B6"))[= Specifications]

#include "specs/cli.typ"
#include "specs/profile.typ"
#include "specs/model-generator.typ"

// --- Architectural Decisions ---

#pagebreak()
#text(size: 16pt, weight: "bold", fill: rgb("#1E40AF"))[= Architectural Decisions]

#include "decisions/001-profile-driven-generation.typ"
#pagebreak()
#include "decisions/002-no-inheritance-no-protected-regions.typ"
#pagebreak()
#include "decisions/003-profile-and-attribute-dx.typ"
#pagebreak()
#include "decisions/004-quality-gates.typ"
#pagebreak()
#include "decisions/005-schema-fixture-policy.typ"
#pagebreak()
#include "decisions/006-cli-tooling.typ"
