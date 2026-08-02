#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Clear the expected-failure markers on the DigitalOcean and GitHub examples",
  tags: ("generator",),
  priority: 4,
  difficulty: 4,
  status: blocked(
    2026,
    8,
    2,
  )[Three emitter defects stand between the two large examples and a clear run, all filed and linked. The one that matters is the skip cascade: the profile cannot supply discriminators for these fifteen unions, because none of them has a field common to every branch, so skip is the only route and skip is broken. Not owner work — this is queued behind its own dependencies.],
  links: (
    depends-on("skipped-component-leaves-dangling-references.task-260802.typ"),
    depends-on("security-schemes-sharing-a-ctor-arg-collide.task-260802.typ"),
    depends-on("scalar-union-path-parameter-degrades-to-mixed.task-260802.typ"),
  ),
)

== Summary

Both large example trees carry an expected-failure marker, left when property-level unions without a discriminator became a generation-time abort. The abort is correct and deliberate; the markers are the unpaid half of that change. While they stand, the two schemas that exercise the generator hardest are not actually exercised, and the release criteria that depend on them cannot be met.

== Acceptance criteria

- Both examples generate without a marker file.
- The discriminators they need are supplied from their profiles, which is the documented mechanism.
- Both trees pass the strict analysis configured for generated output.
- The check-examples recipe reports no stale markers.

== Non-goals

- Weakening the undiscriminated-union abort.
- Adding discriminator inference.

== Files

- \`examples/digitalocean/\`
- \`examples/github/\`

== Result

Neither example cleared, and the task's own premise turned out to be wrong.
Its second criterion says the discriminators these schemas need are supplied
from their profiles, "which is the documented mechanism". They cannot be. All
fifteen flagged property-level unions — four in DigitalOcean, eleven across ten
components in GitHub — were checked branch by branch against the vendored
schemas, and not one shares a field name common to every branch. GitHub's
`commit.author` is the clearest case: it is a union with `empty-object`, which
is declared `properties: {}` with `additionalProperties: false` and so can never
carry any field at all. `event.payload` and `secret-scanning-location.details`
do have a real discriminator, but it sits on the parent object's sibling `type`
field, not inside the polymorphic value, which is the only place a
property-level `#[Discriminator]` can read. Any entry that could be written here
would name a tag absent from at least one branch — the silent mis-hydration the
abort exists to refuse.

Skipping the components instead, the only other granularity
`DiscriminatorEnforcer` offers, was tried and is independently worse: a skip
does not cascade, so the referencing operations still name a type that is never
emitted. Eight dangling `class.notFound` errors on DigitalOcean, 231 on
GitHub's more cross-referential schema, and none of the referencing operations
can be skip-listed either, because paogen considers them representable and calls
the entry stale.

Two further emitter defects surfaced on the way, independent of any of this:
DigitalOcean's two named `http bearer` schemes collapse onto one constructor
argument and are forwarded twice (50 errors), and a scalar `anyOf` path
parameter degrades to `mixed` past the unsupported-parameter-shapes abort in
both documents. Both are in `src/Generator/Emit/`, outside this task's boundary,
and are filed as `security-schemes-sharing-a-ctor-arg-collide` and
`scalar-union-path-parameter-degrades-to-mixed`. The cascade gap is filed as
`skipped-component-leaves-dangling-references`, and this task now depends on all
three.

What did land: the roughly ninety-nine unrelated operation-level gaps both
documents already carried are fully catalogued in each profile's `skip` list and
verified clean on their own — real debt that `abort-on-unrepresentable-constructs`
and `default-deny-on-degradation` turned from silent drops into hard aborts
after this task was filed. Both markers stay, with their reasons rewritten from
a guess to a per-branch accounting a reader can check.
