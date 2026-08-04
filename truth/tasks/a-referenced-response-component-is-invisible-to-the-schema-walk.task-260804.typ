#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "a referenced response component is invisible to the schema walk",
  tags: ("generator", "strictness"),
  priority: 4,
  difficulty: 3,
  status: wip(2026, 8, 4)[wave 1 agent dispatched],
)

== Summary

`SchemaWalk` does not resolve a `$ref` pointing at a named
`#/components/responses/*` entry down to its `Schema`, so nothing that walks
schemas ever sees that response's content. Whatever the walk feeds is blind to
it.

Found on 2026-08-04 while closing
`binary-format-advisory-fires-on-a-format-that-now-drives-behaviour`.
DigitalOcean's `invoice_pdf` declares `format: binary` under
`application/pdf`, through a named response component. `FormatAdvisor` never
reaches it, so no notice fired for it before that task and none fires after —
verified empirically, by grepping the dry-run output on both sides of the
change and finding it absent from each. The advisory fix was correct and this
is a different gap underneath it.

That this surfaced through an advisory is incidental. The advisory is the
cheapest consumer of the walk to notice a hole, because a missing notice is
silent by construction. The question this task has to answer first is what
ELSE reads `SchemaWalk` and is therefore equally blind — the walk feeds more
than one consumer, and a gap in a shared traversal is worth more than the one
symptom that exposed it.

Nothing is known to be mis-generated because of this today. It is filed
because a traversal that silently omits a whole class of node is the shape of
defect this project keeps finding late: `silence-means-success` reads false
for anything the walk cannot see.

== Acceptance criteria

- A `$ref` to a named response component resolves to its content schemas
  everywhere `SchemaWalk` traverses, so a consumer of the walk sees the same
  nodes whether a response is inline or referenced.
- The report says which consumers of `SchemaWalk` were blind before the fix
  and what each one now sees that it did not. Enumerating them is the point;
  the advisory was one symptom and probably not the only one.
- DigitalOcean's `invoice_pdf` is reached by the walk, proven by a check on
  the real document rather than a fixture alone.
- A fixture declares a response both inline and through a component `$ref`
  with the same content, and proves the walk yields the same nodes for both.
- Whether anything the walk feeds changes its output as a result is stated
  explicitly. If emitted code changes, `just check-examples` proves it; if
  nothing changes, say so, since "no diff" is the expected outcome and a
  reader needs to know it was checked rather than assumed.

== Non-goals

- Widening what any consumer of the walk does with a node it can now see.
  This makes the traversal complete; it does not change a policy.
- Request bodies and inline responses, which the walk already reaches.
- The remaining skip entries, which are correct refusals.

== Files

- `src/Generator/Emit/SchemaWalk.php`
- `tests/fixtures/schemas/`
- `tests/`
