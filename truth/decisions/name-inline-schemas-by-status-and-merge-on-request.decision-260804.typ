#import "@local/speconaut:0.1.0": *
#import "../domain/generation.context.typ": *
#import "../domain/guidance.context.typ": *

#show: decision.with(
  title: "Inline payload classes are named by operation and status, and merge only by profile entry",
  status: accepted(2026, 8, 4),
  contexts: (generation-context, guidance-context),
  goals: (
    link("../goals/real-world-schemas.goal.typ"),
    link("../goals/fail-loud-never-silent.goal.typ"),
    link("../goals/user-code-guides-generation.goal.typ"),
  ),
  standards: (
    link("../standards/regeneration-is-deterministic-and-total.standard-260729.typ"),
    link("../standards/guidance-is-data-not-code.standard-260729.typ"),
  ),
)

== Context

`InlinePayloadPlanner` named an operation's inline request as
`{OperationId}Request` and its one picked 2xx response as
`{OperationId}Response`. That derivation had no room for a second response
worth typing, and kilbil's loyalty document makes a second response
universal: all 36 operations declare a `200` and a `403`, both with bodies.
`AddClientResponse` could only ever name one of them, so the `403` — and
whatever body it carried — was silently dropped, the exact shrinkage
`fail-loud-never-silent` exists to forbid.

The `403` bodies are also byte-identical across all 36 operations —
`{result_code: integer, result_text: string}` — which raises a second
question a naming fix alone does not answer: one class or 36? Collapsing
them automatically would assume every operation's `403` means the same
thing because their fields happen to line up, which the document never
states. Two endpoints returning `{id, name}` may be a tag and a user.

== Choice

Two changes, landed together because the second only makes sense once the
first exists.

+ *Naming*: `{OperationId}{Position}Content`, where `Position` is the
  response status exactly as the document spells it — `200`, `403`,
  `default`, `4XX` — mangled only as far as making it a legal PHP
  identifier fragment requires, or the literal word `Request` where a
  status would sit for the request direction. Every response status now
  earns a class this way, not only the one 2xx that drives the operation's
  parameter and return type — the picked status still drives those; every
  other status claims a class and nothing else, until a follow-up
  (`typed-error-responses`) wires one in.
+ *Merging*: `Profile::$inlineModels` flips from `site → class` to
  `class → sites`, so a consumer's guidance reads as one class name to many
  sites, the direction they think in. Nothing merges without an entry:
  identical shapes stay as many classes as they have sites until named
  together. A merge whose sites do not all emit the identical shape fails
  the run, naming the two sites that differ and the property they differ
  on — `SchemaShapeFingerprint` decides "identical" by the same shape-key
  rule `AllOfAccumulator` already used for a repeated `allOf` property, so
  the merge validator and the report below agree with an existing rule
  instead of inventing a second one. Every run also reports each group of
  structurally identical inline schemas on the notice channel
  `report-unrecognised-formats` established — stderr, informational, never
  the exit status — with the exact `Profile::$inlineModels` block that
  would merge them, so the duplication and its fix are both visible without
  a consumer having to notice 36 near-identical files by hand.

=== Alternatives rejected

- *Merge automatically when shapes match.* Rejected by the owner in the
  originating task: structural identity is not identity of meaning, and a
  generator that guesses a domain relationship the document never stated
  is exactly what `user-code-guides-generation` keeps out of the
  generator's hands.
- *Keep `{OperationId}Response` for the picked status and add a second
  pattern only for the rest.* Two independently-invented rules instead of
  one read two ways — the request direction and the response direction
  would drift the moment either changed alone.

== Consequences

- Every inline payload class name paogen has ever emitted moves. This is a
  breaking, byte-stable rename: `just check-examples` reports no drift
  because all four examples were regenerated in the same change
  (`AddClientResponse` → `AddClient200Content`, `AddClientRequest` →
  `AddClientRequestContent`), and any consumer's own code referencing an
  old name breaks at compile time, which `regeneration-is-deterministic-and-total`
  treats as the correct outcome for a naming rule change rather than
  something to soften.
- kilbil's committed `generated/` gains 36 files it never had —
  `{Operation}403Content` for every operation — none referenced by the
  emitted client yet. `examples/kilbil/src/PhoneConfirmation.php` and the
  `tests/Integration/Kilbil/` fixtures that name generated classes by hand
  follow the rename.
- `Profile::$inlineModels`' key format is now part of the public guidance
  surface `typed-error-responses` builds on: that task wires a non-picked
  status into a return type or `ApiException`, and needs the same
  `'<operationId>.<status>'` site vocabulary this decision establishes to
  stay coherent with it.
- `ModelNameLedger` gains `claimMerge()`, a second claim path that accepts
  a name already claimed under a different origin exactly when the pin
  naming it is shared by several sites — the merge validator has already
  proven those sites agree before this path is reached, so the ledger does
  not re-inspect the schema itself.
