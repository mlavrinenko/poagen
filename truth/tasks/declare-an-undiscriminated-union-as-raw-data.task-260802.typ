#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Hydrate an undiscriminated union into a real PHP union type",
  tags: ("generator", "guidance", "strictness"),
  priority: 9,
  difficulty: 8,
  status: accepted(2026, 8, 2),
)

== Summary

A property-level union with no `discriminator` aborts the run. The emitted PHP
type was never the problem — `public readonly SimpleUser|EmptyObject $author`
is expressible and correct. The problem is one step later: given a payload off
the wire, the hydrator has to choose a class to construct, and the only
mechanism it has is a tag field named by `discriminator`.

The two forms of guidance the generator offers are both unusable on the two
large vendor documents. `Profile::$discriminators` needs a tag present in every
branch, and none of the fifteen flagged unions has one. Skipping the component
removes types the rest of the document still references — 8 dangling references
on DigitalOcean, 231 on GitHub.

An earlier version of this task proposed emitting the decoded value as an
array. That was rejected by the owner on 2026-08-02, and rightly: a generator
that answers a declared shape with an array has stopped generating a client.
Where a document describes a structure, the emitted code carries that
structure.

=== What the fifteen unions actually look like

All fifteen were classified branch by branch. Under strict JSON Schema
validation semantics — "could this payload validate against both branches" —
only two are cleanly decidable, and the reason is instructive: of the roughly
forty-five branch schemas involved, exactly one declares
`additionalProperties: false`. That one is GitHub's `empty-object`, which
therefore accepts only `{}` and can never be confused with `simple-user`. Every
other branch tolerates unknown keys, so a payload carrying the union of two
branches' required fields validates against both.

That reading is correct and it is not the right rule for a client generator.
Vendors do not send kitchen-sink payloads; they send one branch. The question
worth answering is not "could a hostile payload satisfy two branches" but "does
this payload carry a field that only one branch declares".

Under that narrower rule most of the fifteen resolve:

- `commit.author`, `commit.committer` — decidable outright.
- `integration.owner`, `installation.account`,
  `integration-installation-request.account`, `nullable-integration.owner` —
  `simple-user` requires `login`, and `enterprise` does not declare `login` at
  all.
- `autoscale_pool.config`, `autoscale_pool_create.config` — the two branches
  require disjoint fields.
- `projects-v2-item-simple.content`, `copilot-seat-details.assigning_team`,
  `repository-ruleset.conditions` — each branch requires fields the others do
  not declare.
- `event.payload` and `secret-scanning-location.details` need a different
  mechanism: their tag exists, on the parent object's sibling `type` property,
  which is where GitHub actually puts it. One of `event.payload`'s sixteen
  branches (`public-event`) declares no properties at all, so nothing inside
  the value could ever discriminate it.
- `database_config.config` and `logsink_update.config` are genuinely
  undecidable. The seven database configs declare no required fields at all,
  and `elasticsearch_logsink` and `opensearch_logsink` are identical field for
  field. Neither parent carries a sibling tag — both are wrappers whose only
  property is `config`.

So the design needs three layers, and the third has to exist because two real
unions land in it.

== Acceptance criteria

- A union property emits the real PHP union type across its branches. No
  branch is ever represented as an array or as `mixed`.
- Layer one, a tag on a sibling. The profile can name a property on the parent
  object whose value selects the branch, with the value-to-branch mapping. The
  document's own `discriminator` is honoured wherever it appears, including on
  the parent. This is what `event.payload` and
  `secret-scanning-location.details` use.
- Layer two, selection by discriminating fields. Where no tag exists, the
  generator computes at generation time which required fields distinguish each
  branch — a field one branch requires and another does not declare — and emits
  that mapping as data on the property. The run reports, per union, which field
  it will discriminate on, so the rule is visible before anything runs.
- Layer three, refusal. Where two branches share every discriminating field, the
  run refuses, names both branches, and names what would resolve it. The
  profile can then pin one branch for that property, which types it as that
  single class, or declare a preference order across branches.
- At runtime, a payload matching zero branches, or two, raises. It never picks
  one silently. This is the whole reason layer two is safe: the ambiguity that
  strict validation worries about becomes an exception, not a wrong object.
- The classification above is re-measured by the implementation rather than
  taken from this task, and the count that lands in each layer is recorded.
- Both large examples generate. Any union that ends in layer three carries a
  profile entry with a written reason, as `$skip` entries do.
- #link("../decisions/skip-is-the-only-opt-out.decision-260801.typ") is amended by a
  new decision only if layer three's pin counts as an opt-out. Argue it either
  way, but argue it — a pin that produces a fully typed property is a different
  animal from an omission, and the reader needs to know which one this is.

== Non-goals

- Guessing by likelihood, scoring, or best-match ranking. Every rule here is
  computed from what the document declares, and a tie is an error rather than a
  winner.
- Widening the abort's default. Without guidance and without a computable
  discriminating field, the run still stops.
- `oneOf` at the request-body level, which needs no selection at all — the
  caller passes one branch and the marshaller serialises it. That is
  `resolve-composition-schemas-in-bodies-and-responses`.

== Files

- `src/Generator/Profile.php`
- `src/Generator/Emit/DiscriminatorEnforcer.php`
- `src/Generator/Emit/CompositionResolver.php`
- `src/Generator/Emit/TypeResolver.php`
- `runtime/src/Attribute/Discriminator.php` and a sibling attribute
- `runtime/src/Marshal/Hydrator.php`
- `examples/digitalocean/paogen.php`, `examples/github/paogen.php`
- `truth/decisions/`
