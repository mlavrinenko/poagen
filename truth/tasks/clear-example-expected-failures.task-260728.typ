#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Clear the expected-failure markers on the DigitalOcean and GitHub examples",
  tags: ("generator",),
  priority: 4,
  difficulty: 4,
  status: wip(2026, 8, 3),
  links: (
    depends-on("declare-an-undiscriminated-union-as-raw-data.task-260802.typ"),
    depends-on("skipped-component-leaves-dangling-references.task-260802.typ"),
    depends-on(
      "sub-client-constructors-take-every-scheme-in-the-document.task-260802.typ",
    ),
    depends-on("security-schemes-sharing-a-ctor-arg-collide.task-260802.typ"),
    depends-on("scalar-union-path-parameter-degrades-to-mixed.task-260802.typ"),
  ),
)

== Summary

Both large example trees carry an expected-failure marker, left when property-level unions without a discriminator became a generation-time abort. The abort is correct and deliberate; the markers are the unpaid half of that change. While they stand, the two schemas that exercise the generator hardest are not actually exercised, and the release criteria that depend on them cannot be met.

=== Two claims in the markers are already stale, 2026-08-03

Measured while closing `path-parameters-run-through-no-shape-gate-at-all`. Both
markers, and `examples/digitalocean/README.md:90` and
`examples/github/README.md:91` which echo them, still say a scalar-union path
parameter resolves to `mixed` instead of tripping the unsupported-shapes abort
— three PHPStan errors on DigitalOcean, eight on GitHub.
`scalar-union-path-parameters-resolve-not-refuse` closed that before this
session began: `images_get`'s `image_id` and `actions/get-workflow`'s
`workflow_id` both resolve to `int|string` today, and neither operation is
refused.

DigitalOcean's marker also still describes its two `http bearer` schemes
colliding on one `bearerToken` constructor argument, which
`distinct-ctor-args-for-colliding-schemes` decided and closed.

So the markers overstate what is left. Whoever clears them re-measures every
claim in both rather than trusting the text — that is the point of this
section, not the two corrections themselves.

== Acceptance criteria

- Both examples generate without a marker file.
- The guidance they need is supplied from their profiles: a discriminator where
  the schema has one, and a raw-data declaration where it does not. The second
  criterion this task originally carried — that a discriminator is the
  mechanism — was measured false and is replaced by
  `declare-an-undiscriminated-union-as-raw-data`.
- Both trees pass the strict analysis configured for generated output.
- The check-examples recipe reports no stale markers.
- Every profile entry either names a real construct or fails the run as stale,
  so neither example carries permissions nobody re-examines.

== Non-goals

- Weakening the undiscriminated-union abort. It stays the default; the
  examples opt out of it by name, per property.
- Adding discriminator inference.

== Files

- \`examples/digitalocean/\`
- \`examples/github/\`

== Result

=== Both cleared, 2026-08-03

The account below is the first attempt and it stands as written — every
measurement in it was true when taken. What changed is the mechanism, not the
facts: `declare-an-undiscriminated-union-as-raw-data` landed, and all fifteen
unions resolve without a single one needing the per-branch tag this task
originally assumed. Eight are decided by a discriminating field computed from
the branches, three by a tag on the enclosing object, two by the closed-shape
predicate, and two by a pin.

So the answer was never a `#[Discriminator]` entry per property, which is what
the attempt below correctly proved impossible. Both markers are gone, both
trees are committed, and all four examples generate cleanly.

Two of the three dependencies were closed on the way —
`sub-client-constructors-take-every-scheme-in-the-document` and
`security-schemes-sharing-a-ctor-arg-collide`.
`skipped-component-leaves-dangling-references` stays open and is no longer
blocking: nothing is skipped at component granularity any more, so the cascade
gap it describes has no live trigger in either example.

=== First attempt, 2026-08-02

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
