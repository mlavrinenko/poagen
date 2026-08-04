# Session resume — 2026-08-04 (second session of the day)

Fourteen tasks closed, one stopped mid-flight by a session limit. `main` is
green, gated and recorded; no worktree is left behind except `envelope`, which
is deliberate and described below.

## Start here

`typed-error-responses` is `blocked`, and the only thing blocking it is that the
session ran out. Nothing in the code is wrong.

- Step one is **merged and gated on main**: `runtime/src/Contract/Envelope.php`
  and `runtime/src/Contract/StatusResponseMap.php`, with unit tests. Additive
  only — no generated method returns an envelope and no transport reads one, so
  the tree behaves exactly as it did before. 522 tests, both coverage floors
  held.
- Step two is **preserved, not merged**, on branch `envelope` at `600beed7`.
  That commit is the generator switch caught mid-regeneration: the emitters are
  partly moved and the four example trees are partly regenerated. It has never
  passed a gate and must not be merged as it stands. Read it to see how far the
  switch got, then finish it or redo it — do not assume any file in it is
  complete.
- Its parent `f2b60245` is the same commit that is already on `main`, so the
  branch shares history and will merge cleanly once step two is finished.

The task artifact carries a section, `== Implementation plan, settled
2026-08-04`, that answers four questions the owner ruling leaves open. Those are
settled, not suggestions. Read them before touching the emitters.

## What landed

Generator correctness:

- `SchemaWalk` resolves a `$ref` to a response component, so DigitalOcean's
  `invoice_pdf` is finally visible to the pre-scan and the advisors.
- `SchemaWalk` also sees a parameter a `PathItem` declares once and shares,
  with operation-level overrides honoured per OpenAPI.
- An operation skipped for an unresolvable path parameter no longer leaks its
  inline payload model — the refusal is pre-scanned before models are planned.
- A form-urlencoded body is recognised by its object shape rather than by the
  literal `type: object` keyword.
- Inline schemas are named `{OperationId}{Position}Content`, and
  `Profile::$inlineModels` merges them only when a human asks. Nothing collapses
  on structural identity.
- A nested XML array can name its container per property.
- A webhook can be named in `Profile::$skip` as `<name>.webhook`, so the
  whole-document refusal finally has an opt-out.

Truth and tooling:

- `scripts/gate-fresh` gained `is-valid`, so a malformed task artifact can no
  longer record as fresh, and stopped hashing `examples/*/build`, which is
  regenerated every run and never byte-stable.
- The code-ref exemption is total again; portability across a reimplementation
  is not something this project pays for.
- Decisions recorded: the payload envelope stays the consumer's business, and
  the binary-stream decision now splits by direction because only the request
  half ever landed.

## Filed, not fixed

Each of these came out of work that was verifying something else, which is the
point.

- `response-analyzer-picks-a-2xx-without-resolving-a-ref` — the same `$ref`
  blindness one layer below the walk. `invoice_pdf`'s schema is visible now and
  the emitted method still returns `void`.
- `return-a-binary-2xx-as-the-stream-a-done-task-already-promised` — a `done`
  task lists this as its own acceptance criterion and it was never delivered.
- `thread-the-validated-nested-container-map-into-the-generated-client` — the
  nested XML binding validates against the schema and then does nothing; the
  consumer rebuilds the same map by hand.
- `a-binary-response-decision-claims-a-stream-the-generator-still-refuses` —
  closed, but it is where the pattern was first noticed.

## The lesson this session repeated

Twice, an artifact stated as settled something the tree did not do: the binary
decision claimed a response-side stream that is still refused, and a closed task
claimed a criterion it never delivered. Both were found by an agent reading the
code to check a claim rather than trusting it. A green gate said nothing about
either, because nothing was red — the code and the claim simply disagreed, and
only the claim was wrong.
