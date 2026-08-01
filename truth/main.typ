// paogen — unified knowledge entry point.
//
// Every artifact except tasks must be #include-d here, wherever it lives under
// truth/. Files are classified by sub-extension (`.goal`, `.context`,
// `.standard-<yymmdd>`, `.feature-<yymmdd>`, `.decision-<yymmdd>`), not by
// directory. Tasks are discovered by their `.task-<yymmdd>` sub-extension and
// need no entry here.
//
// Run `speconaut check truth/` to detect missing includes.

#import "@local/speconaut:0.1.0": *

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

// --- Vision & Goals ---

#include "vision.typ"
#pagebreak()
#include "goals/never-edit-generated.goal.typ"
#pagebreak()
#include "goals/user-code-guides-generation.goal.typ"
#pagebreak()
#include "goals/strict-clean-output.goal.typ"
#pagebreak()
#include "goals/typed-injectable-surface.goal.typ"
#pagebreak()
#include "goals/fail-loud-never-silent.goal.typ"
#pagebreak()
#include "goals/real-world-schemas.goal.typ"
#pagebreak()
#include "goals/cheap-regeneration.goal.typ"
#pagebreak()

// --- Standards ---

#text(size: 16pt, weight: "bold", fill: rgb("#B45309"))[= Standards]

#include "standards/guidance-is-data-not-code.standard-260729.typ"
#pagebreak()
#include "standards/generated-types-are-total.standard-260729.typ"
#pagebreak()
#include "standards/analysis-runs-at-maximum-strictness.standard-260729.typ"
#pagebreak()
#include "standards/fixtures-are-unmodified-vendor-documents.standard-260729.typ"
#pagebreak()
#include "standards/silence-means-success.standard-260729.typ"
#pagebreak()
#include "standards/caller-surface-is-injectable.standard-260729.typ"
#pagebreak()
#include "standards/regeneration-is-deterministic-and-total.standard-260729.typ"
#pagebreak()

// --- Specifications ---

#text(size: 16pt, weight: "bold", fill: rgb("#5B21B6"))[= Specifications]

#include "specs/cli.feature-260417.typ"
#include "specs/profile.feature-260418.typ"
#include "specs/model-generator.feature-260418.typ"
#include "specs/operation-generator.feature-260418.typ"

// --- Decisions ---

#pagebreak()
#text(size: 16pt, weight: "bold", fill: rgb("#1E40AF"))[= Decisions]

#include "decisions/plain-getopt-for-the-cli.decision-260417.typ"
#pagebreak()
#include "decisions/profile-driven-generation.decision-260418.typ"
#pagebreak()
#include "decisions/no-inheritance-no-protected-regions.decision-260418.typ"
#pagebreak()
#include "decisions/typed-profile-and-colocated-attributes.decision-260418.typ"
#pagebreak()
#include "decisions/quality-gates-at-maximum-strictness.decision-260418.typ"
#pagebreak()
#include "decisions/schema-fixture-policy.decision-260418.typ"
#pagebreak()
#include "decisions/hydration-and-serialization-contract.decision-260418.typ"
#pagebreak()
#include "decisions/error-response-policy.decision-260418.typ"
#pagebreak()
#include "decisions/openapi-31-strategy.decision-260419.typ"
#pagebreak()
#include "decisions/attribute-and-phpdoc-driven-serialization.decision-260420.typ"
#pagebreak()
#include "decisions/openapi-31-through-a-maintained-parser.decision-260729.typ"
#pagebreak()
#include "decisions/tagged-subclients-as-the-primary-surface.decision-260729.typ"
#pagebreak()
#include "decisions/code-references-permitted-in-generator-specs.decision-260729.typ"
#pagebreak()
#include "decisions/xml-request-bodies-are-serialised-not-refused.decision-260730.typ"
#pagebreak()
#include "decisions/operations-delegate-to-an-injected-transport.decision-260730.typ"
#pagebreak()
#include "decisions/a-header-not-a-chmod.decision-260731.typ"
#pagebreak()
#include "decisions/review-gate-must-be-mechanical.decision-260801.typ"
#pagebreak()
#include "decisions/skip-is-the-only-opt-out.decision-260801.typ"
#pagebreak()
#include "decisions/xml-responses-refused-at-generation-time.decision-260801.typ"

// --- Supplementary artefacts ---
//
// Markdown notes and historical reviews stored under truth/ for portability.
// Referenced here so the orphan detector sees them as reachable.

#pagebreak()
#text(size: 16pt, weight: "bold", fill: rgb("#0F766E"))[= Supplementary artefacts]

- Design notes: #link("notes/openapi-3.1-gap.md")[notes/openapi-3.1-gap.md], #link("notes/runtime-type-reflection.md")[notes/runtime-type-reflection.md].
- Review archives: #link("reviews/2026-04-18-pre-release-review.md")[reviews/2026-04-18-pre-release-review.md].
