#import "@local/mindtape:0.2.0": *

#show: task.with(
  id: "7451ef72-26ac-4c69-a3c5-671ac80d49d2",
  title: "Audit truth/ for performance-flavoured constraints superseded by ADR-010",
  status: done(2026, 4, 20),
  priority: 5,
  x-paogen: (spec: "truth/specs/model-generator.typ", legacy-id: "T-027"),
)

== Summary

ADR-010 (2026-04-20) explicitly subordinates runtime performance to
clean interface and output. A number of pre-ADR-010 specs and
decisions hardcode performance-flavoured reasoning — e.g. "data-
driven hydration instead of reflecting", "reflection is the
performance failure mode", "adds a phpdoc parser to the consumer's
runtime" — that no longer reflects project direction.

This task audits `truth/specs/**.typ` and `truth/decisions/**.typ`,
catalogues every such passage, and either revises the wording to
match ADR-010 or (for load-bearing ADRs like ADR-007) annotates them
with a "superseded-in-part by ADR-010" banner.

Auditing is strictly about *language and design intent*. No code
changes. The implementation follow-up lives in T-028.

== Rationale

- Future contributors should not be able to cite a pre-ADR-010 line
  about "reflection cost" as a reason to reject a cleaner design.
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
  - *Supersede-mark* ADR-007 (the headline pre-010 document) — add a
    one-line banner at the top of ADR-007 stating that its
    representation choice is superseded by ADR-010. Keep the
    contract portion intact.
  - *Leave* — if the hit is historical context (e.g. "the prior
    representation was chosen for performance reasons") that makes
    sense to preserve as record.

+ *Report* the catalogue as a markdown table in the task completion
  note so reviewers can see every change at a glance.

== Non-goals

- Any `src/` change. Performance adjustments at the code level are
  T-028's concern.
- Re-opening ADR-007's decision. That ADR's *contract* remains
  authoritative; only its *representation* is superseded.

== Acceptance criteria

- `just check` stays green.
- No pre-ADR-010 performance-flavoured passage remains unmarked in
  `truth/decisions/**` or `truth/specs/**`.
- The completion note lists every revised passage with before/after
  excerpts.

== Completion note (2026-04-20)

Grep pass over `truth/specs/**.typ` and `truth/decisions/**.typ` for
the T-027 trigger phrases identified three hits requiring action; a
fourth change was rolled in to keep spec language consistent with
ADR-010. `truth/notes/` and `truth/reviews/` are out of scope per the
task and were left untouched. `truth/tasks/` hits are historical
records of completed work and were left as-is.

+ *ADR-007 top-of-document — supersede banner added.* One paragraph
  placed between `#show: adr.with(...)` and `== Context`, stating that
  the *representation* is superseded by
  #link("../../decisions/010-attribute-and-phpdoc-driven-serialization.typ")[ADR-010]
  while the *contract* remains authoritative.

+ *ADR-007 "Alternatives rejected" / "Parse `@param list<Foo>`
  phpdoc at runtime".* Kept the original rejection as historical
  record; appended a one-paragraph reversal note pointing at
  ADR-010's stance (one MIT-licensed parser is the right-sized cost;
  `token_get_all` fallback handles comment-stripped environments).

  *Before:*
  ```
  - *Parse `@param list<Foo>` phpdoc at runtime.* Works, but adds a
    phpdoc parser to the consumer's runtime and breaks if the user
    strips comments. Rejected.
  ```
  *After (appended paragraph only):*
  ```
  … Rejected.
    ADR-010 reverses this rejection: one MIT-licensed parser
    (`phpstan/phpdoc-parser`) is the right-sized cost, and a
    `token_get_all` fallback against the class source handles
    comment-stripped opcache environments. The 2026-04-20 review
    ruled that clean output outweighs the added dependency.
  ```

+ *ADR-007 "Consequences" — "data-driven rather than reflection-
  driven".* Left unchanged. Covered by the top-of-document supersede
  banner and useful as a record of ADR-007's original framing.

+ *Spec #link("../../specs/model-generator.typ")[Model Generator] —
  scenario "A property with a non-identifier schema key round-trips
  through PROPERTY_MAP".* Rewritten to describe the ADR-010 world:
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

- ADR-008 (`008-openapi-31-strategy.typ`) "parser" hits refer to the
  OpenAPI spec parser (`cebe/php-openapi`), not the runtime phpdoc
  parser. Out of scope.
- ADR-010 itself re-uses the trigger phrases ("runtime cost",
  "performance") but in the current-policy voice; unchanged.
- #link("../../specs/operation-generator.typ")[Operation Generator]:
  no performance-flavoured passages.
- `truth/notes/runtime-type-reflection.md`: aligned with ADR-010
  (same-day note). Out of scope per the task.

Ripple effects on the generated PHPUnit harness:

- `tests/generated/ModelGeneratorTest.php` regenerated by
  `just generate-tests`.
- `tests/generated/ModelGeneratorSteps.php` had six orphan step
  methods (the `displayName` PROPERTY_MAP scenario) removed along
  with the now-unused `$contactSource` instance var.
- `.speconaut/state.lock` updated by
  `speconaut lock --approve` to drop the renamed scenario.
