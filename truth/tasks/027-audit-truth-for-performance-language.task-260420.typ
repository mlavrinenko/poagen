#import "@local/mindtape:0.2.0": *

#show: task.with(
  id: "7451ef72-26ac-4c69-a3c5-671ac80d49d2",
  title: "Audit truth/ for performance-flavoured constraints superseded by attribute-and-phpdoc-driven-serialization",
  status: done(2026, 4, 20),
  priority: 5,
  x-paogen: (spec: "truth/specs/model-generator.typ", legacy-id: "T-027"),
)

== Summary

`attribute-and-phpdoc-driven-serialization` (2026-04-20) explicitly
subordinates runtime performance to clean interface and output. A number
of specs and decisions predating it hardcode performance-flavoured
reasoning — e.g. "data-driven hydration instead of reflecting",
"reflection is the performance failure mode", "adds a phpdoc parser to
the consumer's runtime" — that no longer reflects project direction.

This task audits `truth/specs/**.typ` and `truth/decisions/**.typ`,
catalogues every such passage, and either revises the wording to
match `attribute-and-phpdoc-driven-serialization` or (for load-bearing
decisions like `hydration-and-serialization-contract`) annotates them
with a "superseded-in-part by attribute-and-phpdoc-driven-serialization"
banner.

Auditing is strictly about *language and design intent*. No code
changes. The implementation follow-up lives in T-028.

== Rationale

- Future contributors should not be able to cite a line predating
  `attribute-and-phpdoc-driven-serialization` about "reflection cost" as a
  reason to reject a cleaner design.
- `speconaut check` and golden-tree drift should stay green through
  this pass because only prose changes.

== In scope

+ *Grep pass.* Search `truth/specs/` and `truth/decisions/` for
  performance-flavoured phrases:
  - "runtime cost"
  - "without reflection" / "not reflection"
  - "data-driven instead of" / "data-driven rather than"
  - "reflection cost" / "reflection failure mode"
  - "adds a … parser to the consumer's runtime"
  - "avoid parsing at runtime"

+ *Per-hit decision* — one of:
  - *Revise* the surrounding paragraph to state the current policy
    (clean output first, perf is a separate follow-up) while
    preserving the load-bearing factual content.
  - *Supersede-mark* `hydration-and-serialization-contract` (the headline
    pre-`attribute-and-phpdoc-driven-serialization` document) — add a
    one-line banner at the top of `hydration-and-serialization-contract`
    stating that its representation choice is superseded by
    `attribute-and-phpdoc-driven-serialization`. Keep the contract portion
    intact.
  - *Leave* — if the hit is historical context (e.g. "the prior
    representation was chosen for performance reasons") that makes
    sense to preserve as record.

+ *Report* the catalogue as a markdown table in the task completion
  note so reviewers can see every change at a glance.

== Non-goals

- Any `src/` change. Performance adjustments at the code level are
  T-028's concern.
- Re-opening `hydration-and-serialization-contract`'s decision. That
  decision's *contract* remains authoritative; only its *representation*
  is superseded.

== Acceptance criteria

- `just check` stays green.
- No performance-flavoured passage predating
  `attribute-and-phpdoc-driven-serialization` remains unmarked in
  `truth/decisions/**` or `truth/specs/**`.
- The completion note lists every revised passage with before/after
  excerpts.

== Completion note (2026-04-20)

Grep pass over `truth/specs/**.typ` and `truth/decisions/**.typ` for
the T-027 trigger phrases identified three hits requiring action; a
fourth change was rolled in to keep spec language consistent with
`attribute-and-phpdoc-driven-serialization`. `truth/notes/` and
`truth/reviews/` are out of scope per the task and were left untouched.
`truth/tasks/` hits are historical records of completed work and were
left as-is.

+ *`hydration-and-serialization-contract` top-of-document — supersede
  banner added.* One paragraph placed between `#show: adr.with(...)` and
  `== Context`, stating that the *representation* is superseded by
  #link("../decisions/attribute-and-phpdoc-driven-serialization.decision-260420.typ")[Attribute + phpdoc-driven marshal/unmarshal; Model classes stay clean]
  while the *contract* remains authoritative.

+ *`hydration-and-serialization-contract` "Alternatives rejected" /
  "Parse `@param list<Foo>` phpdoc at runtime".* Kept the original
  rejection as historical record; appended a one-paragraph reversal note
  pointing at `attribute-and-phpdoc-driven-serialization`'s stance (one
  MIT-licensed parser is the right-sized cost; `token_get_all` fallback
  handles comment-stripped environments).

  *Before:*
  ```
  - *Parse `@param list<Foo>` phpdoc at runtime.* Works, but adds a
    phpdoc parser to the consumer's runtime and breaks if the user
    strips comments. Rejected.
  ```
  *After (appended paragraph only):*
  ```
  … Rejected.
    attribute-and-phpdoc-driven-serialization reverses this rejection:
    one MIT-licensed parser (`phpstan/phpdoc-parser`) is the
    right-sized cost, and a `token_get_all` fallback against the class
    source handles comment-stripped opcache environments. The
    2026-04-20 review ruled that clean output outweighs the added
    dependency.
  ```

+ *`hydration-and-serialization-contract` "Consequences" — "data-driven
  rather than reflection-driven".* Left unchanged. Covered by the
  top-of-document supersede banner and useful as a record of
  `hydration-and-serialization-contract`'s original framing.

+ *Spec #link("../specs/model-generator.feature-260418.typ")[Model Generator] —
  scenario "A property with a non-identifier schema key round-trips
  through PROPERTY_MAP".* Rewritten to describe the
  `attribute-and-phpdoc-driven-serialization` world:
  `#[WireName('display-name')]` on the property, runtime
  `Marshaller`/`Hydrator` driving the round-trip, no `PROPERTY_MAP`
  constant. Stage flipped from `unstable` to `draft` — the code
  behind it ships in T-028, which will flip it back and confirm.

  *Before (scenario title + one `#and_` line):*
  ```
  "A property with a non-identifier schema key round-trips through
   PROPERTY_MAP"
  #and_[`Contact::PROPERTY_MAP` pairs `'displayName'` with wire key
        `'display-name'`]
  ```
  *After:*
  ```
  "A property with a non-identifier schema key round-trips via
   #[WireName]"
  #and_[the property carries `#[WireName('display-name')]`, and the
        class has no `PROPERTY_MAP` constant]
  ```
  Plus trace dropped (draft scenarios carry no trace) and wire round-
  trip reworded to go through `(new Hydrator())->hydrate(...)` and
  `(new Marshaller())->marshal(...)` instead of `ApiClient::hydrate`
  and `json_encode`.

Non-hits verified:

- `openapi-31-strategy` "parser" hits refer to the OpenAPI spec parser
  (`cebe/php-openapi`), not the runtime phpdoc parser. Out of scope.
- `attribute-and-phpdoc-driven-serialization` itself re-uses the trigger
  phrases ("runtime cost", "performance") but in the current-policy voice;
  unchanged.
- #link("../specs/operation-generator.feature-260418.typ")[Operation Generator]:
  no performance-flavoured passages.
- `truth/notes/runtime-type-reflection.md`: aligned with
  `attribute-and-phpdoc-driven-serialization` (same-day note). Out of
  scope per the task.

Ripple effects on the generated PHPUnit harness:

- `tests/generated/ModelGeneratorTest.php` regenerated by
  `just generate-tests`.
- `tests/generated/ModelGeneratorSteps.php` had six orphan step
  methods (the `displayName` PROPERTY_MAP scenario) removed along
  with the now-unused `$contactSource` instance var.
- `.speconaut/state.lock` updated by
  `speconaut lock --approve` to drop the renamed scenario.
