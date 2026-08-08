# Why the domain vocabulary is five bounded contexts

`migrate-domain-to-context` moved poagen's domain vocabulary from one
untyped file into `truth/domain/`. Its own Non-goals said splitting into
several bounded contexts was out of scope — "one context is correct at this
size" — and then the same task's implementing commit split it into four
anyway, argued only in the commit message. `reword-the-domain-context-split`
corrects the task record; this note is the standing argument the task record
never carried: why four contexts, not one, was right at poagen's size then,
and what would change that answer.

`typed-domain-entity-props` added a fifth, `runtime-context`, for exactly
the reason the "What would justify changing it" section below already
named as the test: Hydrator and Marshaller run on every request a
consumer's own process makes, long after generation ends, which is a
different lifecycle from anything the other four contexts own. No
single-context model was ever shipped. This note documents the five
contexts that exist today, not a plan to collapse them.

## What each context owns

- **`schema-context`** (`schema.context.typ`, functional) — `Schema` and
  `Operation`: what the vendor publishes. poagen only ever reads this; it is
  never poagen's to change, which is the whole point of
  `fixtures-are-unmodified-vendor-documents`.
- **`guidance-context`** (`guidance.context.typ`, functional) — `Profile`,
  `ValueObject`, `BindsFormat`, `AttributeScan`, `UserFile`: what the
  consumer writes to steer generation. Every term names something the user
  authors and poagen reads as data, per `guidance-is-data-not-code` and the
  `user-code-guides-generation` goal.
- **`generation-context`** (`generation.context.typ`, technical) —
  `Generator`, `ModelEmitter`, `Client`, `Model`, `GeneratedFile`,
  `Envelope`: what poagen does and what it leaves on disk. Every term here
  has no hand-written counterpart, which is why `generated-types-are-total`
  and `never-edit-generated` can hold across the whole context.
- **`cli-context`** (`cli.context.typ`, technical) — `PoagenCli` alone: the
  command surface a consumer actually runs. Thin by design, so
  `cheap-regeneration` stays one command rather than a procedure.
- **`runtime-context`** (`runtime.context.typ`, technical) — `Hydrator`,
  `Marshaller`: the hydration machinery the emitted `Client` carries at
  request time. poagen controls this end to end too, same as
  `generation-context`, but on a different lifecycle — see below.

## Why five, at this size

The five names line up with five different authorities and lifecycles, not
with an arbitrary grouping of terms:

- The vendor controls `schema-context` and republishes it on their own
  schedule, independent of anything poagen or its consumer does.
- The consumer controls `guidance-context` and edits it directly, on their
  own schedule.
- poagen controls `generation-context` end to end; nothing under it is ever
  hand-edited, and a consumer never authors anything in this vocabulary.
- `cli-context` is the one surface a human (or a script) invokes directly,
  and it does almost nothing beyond resolving a profile and handing off —
  one entity, no state of its own.
- poagen controls `runtime-context` end to end too, same authority as
  `generation-context` — but a different lifecycle. `generation-context`'s
  five entities finish their work when a `poagen generate` run ends;
  `Hydrator` and `Marshaller` ship inside the emitted `Client` and run on
  every request a consumer's own process makes, long after generation is
  over. Folding them into `generation-context` would blur exactly the
  run-once/runs-forever distinction a consumer needs to reason about which
  code executes when.

Every accepted standard and decision that cites `contexts:` already leans on
this split to say precisely which authority boundary it depends on:
`fixtures-are-unmodified-vendor-documents` cites `schema-context` alone;
`guidance-is-data-not-code` cites `guidance-context`;
`caller-surface-is-injectable`, `generated-types-are-total` and
`regeneration-is-deterministic-and-total` cite `generation-context`;
`silence-means-success` cites both `cli-context` and `generation-context`,
because that is genuinely where a run's exit behaviour is decided. Collapsing
these into one context would not remove any of that structure — it would
just stop the `contexts:` slot from being able to say it. `[check.context-deps]`
in `.speconaut/config.toml` is declined for now (pending a standards-tree
sweep), but it exists specifically to check dependencies between contexts
like these; the five-context shape is what makes that check meaningful once
it is turned on, not an artifact of when the split happened to land.

## What would justify changing it

Collapsing two contexts would need their authority and lifecycle to
actually merge — for example, if `guidance-context` were removed outright
(no consumer-facing knobs at all) and `cli-context` became nothing but a
straight call into `generation-context`, `cli-context` folding into
`generation-context` would cost nothing, because there would be no
independent surface left to distinguish.

Splitting `generation-context` further would need two of its six entities
to start serving genuinely different authority or lifecycle groups — for
instance, if client emission and model emission ever needed different
standards or a different pace of change from each other. Nothing about
poagen's current shape points at that; the six entities there are still
one thing poagen does end to end. `runtime-context` already shows what such
a split looks like when the case is real: `Hydrator` and `Marshaller` were
never generation-context entities to begin with, and the lifecycle argument
above is why they were not added as two more.
