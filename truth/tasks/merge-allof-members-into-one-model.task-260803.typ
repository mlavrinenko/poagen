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
- A member that is a `oneOf`/`anyOf` of required-only schemas contributes
  nothing to the shape and is reported once per site on the notice channel —
  the stderr one `report-unrecognised-formats` established, never moving the
  exit status. Four DigitalOcean operations carry it (`firewalls_create`,
  `firewalls_update`, `firewalls_add_rules`, `firewalls_delete_rules`, all
  spelling "at least one of `inbound_rules`/`outbound_rules`"), and PHP has no
  type for that constraint. See the ruling below.
- A `required` name that no member declares as a property is reported on the
  same channel and otherwise ignored. `uptime_create_check` requires `method`
  and no member declares it; that is the vendor's defect, and refusing an
  operation over it would punish the consumer for it.
- Every committed golden and example tree regenerates, and the diff on the
  nine widened operations is reviewed rather than accepted wholesale — it is
  the only place where output that already existed changes shape.

=== Ruling: a validation constraint is not a shape

Written here rather than left open, because it decides four shipping
endpoints. paogen types what a document declares; it is not a validator. It
already ignores `minLength`, `maximum`, `pattern` and every other assertion
keyword, and an `anyOf` of required-only schemas is the same kind of thing —
"at least one of these two" is a constraint on a value, not a statement about
its shape. So it is ignored, loudly, on the notice channel.

Refusing instead would remove `firewalls_create` and `firewalls_update` from
the client to enforce a rule paogen was never going to enforce anywhere else,
which trades a whole endpoint for a consistency the codebase does not have.

Reversing this is one criterion's worth of work if the owner disagrees.

== Non-goals

- `oneOf`/`anyOf` in the body or response position. Those are the three
  sibling tasks this one was split from, and they land after it.
- `not`, which no vendored document uses and which has no PHP type.
- Validating an `anyOf` of required-only members at run time. See the ruling.
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
