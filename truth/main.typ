// poagen — unified knowledge entry point.
//
// Every artifact except tasks must be #include-d here, wherever it lives under
// truth/. Files are classified by sub-extension (`.goal`, `.context`,
// `.standard-<yymmdd>`, `.feature-<yymmdd>`, `.decision-<yymmdd>`), not by
// directory. Tasks are discovered by their `.task-<yymmdd>` sub-extension and
// need no entry here.
//
// Run `speconaut check truth/` to detect missing includes.

#import "@local/speconaut:0.1.0": *

#set document(title: "poagen — Source of Truth")
#set text(size: 10pt)
#set page(margin: 2cm, numbering: "1")

#align(center)[
  #text(size: 22pt, weight: "bold")[poagen]
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
#include "goals/declared-shapes-become-types.goal.typ"
#pagebreak()
#include "goals/guidance-cannot-mislead.goal.typ"
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
#include "decisions/process-only-decisions-may-name-a-file.decision-260801.typ"
#pagebreak()
#include "decisions/skip-is-the-only-opt-out.decision-260801.typ"
#pagebreak()
#include "decisions/xml-responses-refused-at-generation-time.decision-260801.typ"
#pagebreak()
#include "decisions/runtime-ships-as-a-separate-package.decision-260801.typ"
#pagebreak()
#include "decisions/coverage-floor-in-the-gate.decision-260801.typ"
#pagebreak()
#include "decisions/wire-or-drop-the-unwired-attributes.decision-260802.typ"
#pagebreak()
#include "decisions/mutation-testing-stays-out-of-the-gate.decision-260802.typ"
#pagebreak()
#include "decisions/untraced-source-is-a-ratcheted-warning.decision-260802.typ"
#pagebreak()
#include "decisions/runtime-src-excluded-from-untraced-source-check.decision-260802.typ"
#pagebreak()
#include "decisions/zero-statement-files-pinned-as-plumbing.decision-260802.typ"
#pagebreak()
#include "decisions/strictness-relaxation-is-opt-in-not-opt-out.decision-260802.typ"
#pagebreak()
#include "decisions/scalar-union-path-parameters-resolve-not-refuse.decision-260802.typ"
#pagebreak()
#include "decisions/distinct-ctor-args-for-colliding-schemes.decision-260802.typ"
#pagebreak()
#include "decisions/every-credential-scheme-is-wired-not-refused.decision-260803.typ"
#pagebreak()
#include "decisions/a-binary-body-is-a-psr-7-stream.decision-260803.typ"
#pagebreak()
#include "decisions/union-pin-is-a-second-opt-out.decision-260803.typ"
#pagebreak()
#include "decisions/generated-duplication-ceiling-is-per-tree.decision-260803.typ"
#pagebreak()
#include "decisions/payload-envelope-stays-the-consumers-business.decision-260804.typ"
#pagebreak()
#include "decisions/name-inline-schemas-by-status-and-merge-on-request.decision-260804.typ"
#pagebreak()
#include "decisions/the-code-ref-exemption-becomes-total.decision-260804.typ"
#pagebreak()
#include "decisions/envelope-supersedes-error-response-policy.decision-260804.typ"
#pagebreak()
#include "decisions/envelope-remeasures-the-generated-duplication-floors.decision-260804.typ"
#pagebreak()
#include "decisions/refuse-a-skip-that-leaves-dangling-references.decision-260804.typ"
#pagebreak()
#include "decisions/duplication-ceilings-follow-regeneration-not-collapse.decision-260808.typ"
#pagebreak()
#include "decisions/phpdoctypes-stays-scalar-only.decision-260808.typ"
#pagebreak()
#include "decisions/standalone-harness-drift-is-caught-offline.decision-260808.typ"
#pagebreak()
#include "decisions/derive-the-standalone-consumer-instead-of-pinning-its-shape.decision-260808.typ"
#pagebreak()
#include "decisions/queue-drained-models-swallow-emission-failures.decision-260808.typ"
#pagebreak()
#include "decisions/synthesised-model-failures-reach-the-run-report.decision-260808.typ"

// --- Supplementary artefacts ---
//
// Markdown notes and historical reviews stored under truth/ for portability.
// Referenced here so the orphan detector sees them as reachable.

#pagebreak()
#text(size: 16pt, weight: "bold", fill: rgb("#0F766E"))[= Supplementary artefacts]

- Design notes: #link("notes/runtime-type-reflection.md")[notes/runtime-type-reflection.md], #link("notes/decisions-audit-procedure.md")[notes/decisions-audit-procedure.md], #link("notes/backlog-handoff-260802.md")[notes/backlog-handoff-260802.md], #link("notes/session-resume-260803.md")[notes/session-resume-260803.md], #link("notes/session-resume-260803b.md")[notes/session-resume-260803b.md], #link("notes/session-plan-260803c.md")[notes/session-plan-260803c.md], #link("notes/session-resume-260803d.md")[notes/session-resume-260803d.md], #link("notes/session-resume-260804.md")[notes/session-resume-260804.md], #link("notes/session-resume-260804b.md")[notes/session-resume-260804b.md].
- Review archives: #link("reviews/2026-04-18-pre-release-review.md")[reviews/2026-04-18-pre-release-review.md], #link("reviews/2026-08-01-decisions-audit.md")[reviews/2026-08-01-decisions-audit.md].
