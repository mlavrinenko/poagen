#import "@local/speconaut:0.1.0": *
#import "../domain/generation.context.typ": *
#import "../domain/guidance.context.typ": *

#show: decision.with(
  title: "A skip that leaves a dangling reference refuses the run instead of cascading",
  status: accepted(2026, 8, 4),
  contexts: (generation-context, guidance-context),
  goals: (
    link("../goals/fail-loud-never-silent.goal.typ"),
    link("../goals/strict-clean-output.goal.typ"),
  ),
  standards: (link("../standards/silence-means-success.standard-260729.typ"),),
  relates-to: (link("skip-is-the-only-opt-out.decision-260801.typ"),),
)

== Context

`Profile::$skip` omits a component the generator cannot represent — a
`DiscriminatorEnforcer` union failure, or a `ComponentCatalog` shape it does
not recognise. Omitting it never stopped another component's property or
another operation's parameter or response from still naming it by `$ref`.
The class the emitted tree pointed at simply did not exist, and nothing in
the plan noticed: the run completed, printed its success line, and left a
tree that fails `class.notFound` under `strict-clean-output`'s own
maximum-strictness PHPStan config — found on DigitalOcean's config
components and, at far larger scale, on GitHub's, where ten skipped
components fed forward into dozens of unrelated models.

`silence-means-success` already settles the shape of the only permitted
omission: "an omission the consumer asked for by name". A referencer nobody
named — pulled in only because it happened to point at something the
consumer did skip — is not that, whether it is one operation or forty
models deep in a reference graph.

== Choice

The generator refuses rather than cascades. Excluding a component does not
silently exclude whatever reaches it; instead every component and operation
still reaching an excluded one becomes a problem of its own, reported
through the same `Profile::$skip` staleness mechanism every other
unrepresentable construct already uses. The run stops, and the failure
names the referencer, what it reaches, and the exact `Profile::$skip` entry
that would resolve it — printed ready to paste, because erroring and asking
the consumer to configure generation better is only honest when the
generator says exactly what to configure.

`DanglingReferenceScanner` computes this as a fixed point over the
component reference graph rather than one level at a time: a component
that is otherwise perfectly representable becomes excluded the moment it
is left pointing at an omitted class, so anything that in turn references
*that* component inherits the same problem, and the search repeats until a
pass finds nothing new. GitHub's ten skipped components reaching Issue,
Deployment, CheckRun, and dozens of webhook payload models is exactly this
— a real, multi-level blast radius the scan surfaces in one refusal rather
than one newly-discovered layer per re-run. Operations never need the same
closure: nothing in the document references an operation, so each is
checked once against the fully closed set.

Accepting a referencer's own name in `Profile::$skip` is what turns its
refusal into an omission — the same test `skip-is-the-only-opt-out` already
applies to every other entry. Nothing here decides on the consumer's
behalf to omit a referencer; the run refuses until they do, or until the
schema no longer needs it. An operation accepted only because a type it
names was skipped is not reported stale for want of a reason of its own —
the same staleness check `SkipListValidator` already runs treats it as a
problem this run found, exactly like any other unrepresentable construct,
so accepting it is never mistaken for an unused entry.

== Consequences

- A schema with cross-referenced components that the generator cannot
  represent may need a much longer `Profile::$skip` list than the single
  entry a consumer expected — the whole point being that the list is now an
  honest account of what left the client, rather than a shorter list next
  to a tree that does not analyse.
- `Profile::$skip`'s own meaning is unchanged: it still only ever omits,
  never emits something degraded, and a component's own staleness rule is
  unchanged. This decision only widens what counts as "a problem this run
  found" to include a referencer, not what accepting one does.
- What `Profile::$skip` means for an operation, as opposed to a component,
  is unchanged — an operation reported here is refused by the same
  mechanism (and the same message shape) any other unrepresentable
  operation already uses.
- Discriminator inference and the undiscriminated-union abort are untouched
  — this closes the gap after a component is already excluded, not how or
  whether it gets excluded in the first place.
