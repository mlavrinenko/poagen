#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "merge allOf members into one model",
  tags: ("generator", "strictness"),
  priority: 8,
  difficulty: 5,
  status: accepted(
    2026,
    8,
    3,
  )[Split out of resolve-composition-schemas-in-bodies-and-responses, which bundled four independent mechanisms behind one count. This is the first of the four and the only one that also fixes a defect shipping today.],
)

== Summary

`allOf` is the composition keyword DigitalOcean writes and it lands in two
places at once — a refusal on eighteen operations, and a silent widening on
nine more.

Measured on the current tree, not carried over from the parent task:

=== The refusal, eighteen operations

Eighteen DigitalOcean request bodies are skip-listed with the reason
"application/json request body with an inline (non-`$ref`) schema", and every
one of them is an `allOf` node: eleven with one member, six with two, one with
three. One GitHub response joins them — `apps/create-from-manifest`'s 201 is an
`allOf` of two and is skip-listed as a 201 "of type 'unspecified'".

Nothing about them is exotic. Four idioms cover all nineteen:

- `allOf: [$ref]` plus a sibling `required` list — take a component and make
  some of its properties mandatory. `addons_create`, `projects_create`.
- `allOf: [$ref, {type: object, properties: {...}}]` — a component plus one or
  two extra fields. `databases_create_cluster` adds `backup_restore`.
- `allOf: [$ref, $ref]` — two components merged. `vpcs_patch`.
- A member whose own target carries `allOf` again. Seven operations nest one
  level; a flat merge leaves them with no properties at all.

=== The widening, nine operations

Nine DigitalOcean operations declare `type: object` alongside `allOf` and no
`properties` of their own. `RequestBodyAnalyzer` reads the `type` keyword,
finds an object with nothing declared, and emits `KIND_JSON_MAP` — so the
generated client ships

```php
/** @param array<string, mixed> $body */
public function uptimeCreateCheck(array $body): void
```

for a schema that names every one of its fields through `check_updatable`. The
`allOf` is discarded without a word: exit 0, no notice, a committed example
tree. The nine are `vpcs_create`, `vpcs_update`, `vpcs_patch_peerings`,
`vpcPeerings_create`, `vpcPeerings_patch`, `uptime_create_check`,
`uptime_update_check`, `uptime_create_alert` and `uptime_update_alert`.

That is the fourth site of the root cause `close-the-three-sites-that-widen-a-declared-shape`
closed at the other three, and unlike the form-urlencoded fourth site
(`form-urlencoded-body-requires-the-literal-type-object-keyword`) this one is
not a refusal that is merely conservative — it is a wrong type in shipped
output. `declared-shapes-become-types` and `silence-means-success` both name
it directly.

`vpcs_patch` and `vpcs_update` are the proof the two halves are one bug: the
same two `$ref` members, and the only difference between them is that
`vpcs_update` writes `type: object` on the node. One refuses; the other emits
`array`.

=== What the merge has to do

`CompositionResolver::flattenAllOf()` already exists and is close. Four things
are wrong with it for this purpose, each measured against the corpus:

+ It reads `$node->allOf` and ignores the node's own `properties` and
  `required`. Six DigitalOcean bodies put `required` next to `allOf`; those
  requirements are dropped today.
+ It does not recurse. Seven bodies have a member whose target is itself an
  `allOf`, and a flat merge yields zero properties for them.
+ Later members overwrite earlier ones on a name collision. Under a recursive
  merge across both large documents there are zero collisions, so nothing is
  relying on that behaviour and it can become a refusal at no cost.
+ It returns `null` when the merge yields no properties, which is
  indistinguishable from "not an `allOf`".

== Acceptance criteria

- `allOf` resolves by merging, recursively, into one synthesised model:
  the node's own `properties` and `required`, plus every member's, with a
  `$ref` member dereferenced and a member that carries only `required`
  contributing its requirements. Proven on `firewalls_update`, whose
  requirements sit on the node and whose properties sit two levels down.
- The same property name declared by two members with two different schemas
  refuses the run by name, naming both sites and the property. It does not
  pick one. A fixture drives this, since neither vendor document does.
- The nine widened operations emit a typed model parameter instead of
  `array $body`. Check them by name, not by grepping for `array $body` — an
  `array` parameter is also how a legitimate list body is spelled
  (`petstore`'s `createUsersWithListInput` takes `@param list<User>`), and how
  a body the document genuinely left shapeless is spelled (GitHub's three,
  none of which carry an `allOf`). The check that generalises: no `array`
  body parameter is left whose schema declares an `allOf`.
- The eighteen DigitalOcean skip entries and GitHub's
  `apps/create-from-manifest` are removed from the profiles, not left stale.
- A member that is a `oneOf`/`anyOf` of required-only schemas emits one
  synthesised model per branch — each the full merged shape, each carrying
  that branch's extra requirements — and the body parameter is the PHP union
  across them. Nothing is ignored and nothing is refused. See the ruling
  below, which walks `firewalls_create` in full.
- A branch set that cannot be expressed that way refuses the operation by
  name, naming the member and the schema pointer. It is never ignored with a
  notice: a constraint the emitter drops silently is the widening this task
  exists to remove, and `Profile::$skip` is where a consumer says they do not
  need the operation.
- A `required` name that no member declares as a property refuses the run,
  naming the operation, the name and the members searched.
  `uptime_create_check` requires `method` and no member declares it. That is
  the vendor's defect and the honest response is to stop and say so — the
  consumer can skip the operation, and a skip they wrote is an omission they
  asked for. Silently emitting a model missing a required field is not.
- Every committed golden and example tree regenerates, and the diff on the
  nine widened operations is reviewed rather than accepted wholesale — it is
  the only place where output that already existed changes shape.

=== Ruling: an `anyOf` member becomes a union of branches, not a dropped
constraint

Owner ruling, 2026-08-03, reversing what this task said when it was filed.
An earlier draft had the member ignored with a notice, on the argument that
paogen ignores `minLength` and `pattern` too. The owner rejected that: paogen
fails when it cannot generate something, and the consumer decides whether to
skip. An ignored constraint is a silent widening, which is the very defect the
rest of this task removes.

It also turns out not to be a choice between ignoring and refusing.
`firewalls_create` is the whole argument, in the document's own words:

```yaml
allOf:
  - $ref: '#/components/schemas/firewall'   # itself an allOf of two
  - required: [name]
  - anyOf:
      - title: Inbound Rules
        required: [inbound_rules]
      - title: Outbound Rules
        required: [outbound_rules]
```

`anyOf` is a union, and a union is expressible. Both branches declare only a
`required` list, and both properties are already declared by `firewall`, so
each branch is the same merged shape with one more field mandatory. Two
synthesised models, and a native PHP union across them:

```php
public function firewallsCreate(
    FirewallsCreateInboundRules|FirewallsCreateOutboundRules $body,
): FirewallResponse
```

The constraint is now in the type. A caller who wants both sets of rules picks
either branch and fills the other property, because neither branch forbids it —
which is exactly what `anyOf` means, as against `oneOf`. Nothing is dropped,
nothing is refused, and no PHPStan annotation is needed because native PHP
carries it.

The branch names come from the `title` each branch declares, through the same
`<Component><TitleOrIndex>` derivation `UnionInterfaceEmitter` and the inline
planner already use for an inline union branch. All four DigitalOcean sites
declare titles.

Where a branch set cannot be expressed as a union — branches that are not all
object shapes, or a member whose branches conflict — the operation refuses by
name and the consumer skips it if they do not need it.

=== Non-ruling, recorded so it is not re-derived: `allOf` is not `X&Y`

An intersection type is the other reading of `allOf` and it is the wrong one
here. An `allOf` payload is one flat JSON object carrying the union of its
members' properties. There is no value that "is both a `VpcUpdatable` and a
`VpcDefault`" — there is one object with both sets of fields, which is what the
merge emits.

`X&Y` would additionally require paogen to emit a property-declaring interface
per component and a class implementing all of them, since an intersection of
two classes is uninhabitable. The only interfaces paogen emits for models today
are the empty union markers `UnionInterfaceEmitter` writes, which declare no
properties and so constrain no shape. Emitting shape-bearing interfaces is a
design change that collides with `no-inheritance-no-protected-regions` and
roughly doubles the emitted class count; it is not part of this task and
nothing in the corpus asks for it.

== Non-goals

- `oneOf`/`anyOf` as the whole body or response schema. Those are the three
  sibling tasks this one was split from, and they land after it. This task
  covers only a `oneOf`/`anyOf` appearing as a member of an `allOf`.
- `not`, which no vendored document uses and which has no PHP type.
- Intersection types. See the non-ruling above.
- Reusing a referenced component as the emitted type instead of synthesising a
  new class. `allOf: [$ref Foo] + required: [x]` is not `Foo` — its required
  set differs — so a new class is the honest answer, and that is what the
  merge already produces.

== Files

- `src/Generator/Emit/CompositionResolver.php`
- `src/Generator/Emit/ObjectShape.php`
- `src/Generator/Emit/RequestBodyAnalyzer.php`
- `src/Generator/Emit/ResponseAnalyzer.php`
- `src/Generator/Emit/InlinePayloadPlanner.php`
- `examples/digitalocean/paogen.php`, `examples/github/paogen.php`
- `examples/*/generated/` (regenerated)
- `tests/`
