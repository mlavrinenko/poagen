#import "@local/speconaut:0.1.0": *

#show: goal.with(
  title: "Regenerating is a single reviewable step",
  status: active(2026, 7, 29),
  acid-test: [
    Point the project at a newer revision of the same schema and run one
    command. The reviewer sees a diff that contains only what actually
    changed upstream — no reordered members, no churned formatting, no
    incidental renames. Running the same command twice in a row produces
    no diff at all.
  ],
)

Regeneration has to be boring, because a step people dread is a step
people skip, and a client that drifts from its schema is worse than no
generated client at all.

Boring means deterministic. Identical inputs produce identical bytes,
independent of filesystem ordering, hash seeds, or the machine. Emission
order is derived from the schema, not from whatever order the parser
happened to hand things over. Without that, every regeneration produces
noise, and noise is where a real change hides.

Boring also means honest about removal. When an operation or a payload
shape disappears upstream, the corresponding output disappears too, in
the same run. Stale files left behind would compile and lie.

The user should be able to see what a regeneration would do before it
does it, and to inspect the diff without writing anything to disk. A step
that can be previewed is a step that gets run.
