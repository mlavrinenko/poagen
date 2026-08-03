#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "a union request body takes a union parameter",
  tags: ("generator", "strictness"),
  priority: 8,
  difficulty: 5,
  status: done(
    2026,
    8,
    3,
  )[Landed as 0994ae9, merged and re-gated on the integrated HEAD with check-examples clean on all four trees. Skip list 60 to 43: seventeen entries removed, and ten GitHub refusals rewritten in place to name the real cause — a branch set mixing an object with an array or scalar — instead of the stale "inline (non-`$ref`) schema" text they had carried. Both silent widenings are typed. Every figure in the task reproduced exactly. The allOf task's KIND_JSON_UNION, its parameter emitter and the runtime marshaller were reused unchanged; one new planner exists because a whole-body union folds no accumulated properties into its branches and a branch may be a scalar, neither of which the allOf branch builder expects.],
)

== Summary

Twenty-seven operations across the two large examples are skip-listed for a
request body that is a `oneOf` or an `anyOf`. Measured on the current tree:

- DigitalOcean, thirteen: `certificates_create`, `droplets_create` and
  `dropletActions_post_byTag` are `oneOf` of two; `floatingIPsAction_post`,
  `imageActions_post`, `reservedIPsActions_post`, `reservedIPv6Actions_post`,
  `volumes_create` and `volumeActions_post` are `anyOf` of two;
  `volumeActions_post_byId` of three, `nfs_create_action` of six, and
  `domains_create_record` and `dropletActions_post` of nine.
- GitHub, fourteen: `actions/review-custom-gates-for-run` is an `anyOf` of two;
  seven are a `oneOf` of two (the six `repos/*-status-check-contexts` and
  `*-team-access-restrictions` operations, plus
  `codespaces/create-for-authenticated-user`); four a `oneOf` of three;
  `projects/add-field-for-org` of four; `issues/set-labels` of five.

Outgoing, this is easy in a way the response direction is not, and that is the
whole reason it is its own task. The consumer constructs one branch and passes
it. Nothing has to be inferred from a payload, no branch has to be
distinguishable from any other, and the undiscriminated-union machinery
`declare-an-undiscriminated-union-as-raw-data` built is not involved: the
method takes a PHP union type across the branches and the marshaller
serialises whichever object it was handed.

`CompositionResolver::resolveUnion()` already produces exactly this union type
for a `$ref`-only `oneOf`/`anyOf` — it is what a model property with the same
shape already gets. The request-body path does not call it.

Two branch spellings appear that `resolveUnion()` returns `null` for, and both
need covering: a branch that is an inline object rather than a `$ref` (which
needs a synthesised model, the machinery `InlinePayloadPlanner` already has),
and a branch that is a scalar or an array — `issues/set-labels` mixes an
`{type: array, items: string}` branch with object branches.

=== Two more operations, not skip-listed, silently widened

`orgs/delete-attestations-bulk` and `users/delete-attestations-bulk` declare
`type: object` alongside a two-branch `oneOf` — "either `subject_digests` or
`attestation_ids`, but not both", in the document's own words. Because the node
writes the `type` keyword, `RequestBodyAnalyzer` reads an object with no
declared properties, emits `KIND_JSON_MAP`, and ships

```php
/** @param array<string, mixed> $body */
public function orgsDeleteAttestationsBulk(string $org, array $body): void
```

The `oneOf` is discarded without a word, at exit 0, in a committed tree. It is
the same defect `merge-allof-members-into-one-model` fixes for `allOf`, in the
same place, for the other keyword — so this task carries the union half of it.
Twenty-seven refusals and two widenings, twenty-nine operations in total.

== Acceptance criteria

- A `oneOf`/`anyOf` request body emits one method parameter whose type is the
  PHP union of the branches, and the marshaller serialises whichever branch the
  caller passed. No branch selection is computed and none is needed.
- An inline object branch is synthesised into a model exactly as a whole inline
  body already is, named by the same derivation, so the union reads as a list
  of classes rather than one class and one `array`.
- A branch set paogen cannot name a PHP type across — a mix that would put
  `array` or a bare scalar beside a class in the union — refuses by name,
  naming the operation, the branch index and the schema pointer. Which of the
  twenty-seven fall here is a measurement to take during the work, not a number
  to trust from this task; `issues/set-labels` is the known candidate.
- `orgs/delete-attestations-bulk` and `users/delete-attestations-bulk` emit a
  union parameter instead of `array<string, mixed> $body`. They are not
  skip-listed, so nothing else would catch them: check them by name.
- Every one of the twenty-seven that resolves has its skip entry removed from
  the profile, and every one that does not keeps an entry whose reason names
  the real cause rather than the stale "inline (non-`$ref`) schema".
- Both large examples regenerate and pass the generated tier's PHPStan config.
- A fixture drives a two-branch `oneOf` request body end to end — construct
  each branch, assert the serialised body — so the behaviour is proven without
  a vendor document.

== Non-goals

- `oneOf`/`anyOf` in a response, which needs branch selection from a payload
  and is `a-union-response-selects-its-branch`.
- `allOf`, which is `merge-allof-members-into-one-model` and lands first.
- Inferring a discriminator, or reading one if the document declares it. A
  discriminator on an outgoing body decides nothing — the caller already chose
  the branch by constructing it.
- Widening what `Profile::$unionPins` or `$unionTags` mean. Neither applies
  outgoing, and neither should gain a request-side meaning here.
- A union nested *inside* a typed map body.
  `copilot/set-copilot-content-exclusion-for-organization` emits
  `array<string, list<mixed>>` for an `additionalProperties` whose items are an
  `anyOf` of a string and two closed objects. The map and the list are typed
  and only the branch union degrades to `mixed`, which is a narrower hole than
  this task's and belongs to whoever next has `InlineObjectResolver` open.
  Named here so it is not mistaken for in-scope, and not filed, because
  nothing proves it worth a class yet.

== Files

- `src/Generator/Emit/RequestBodyAnalyzer.php`
- `src/Generator/Emit/CompositionResolver.php`
- `src/Generator/Emit/InlinePayloadPlanner.php`
- `src/Generator/Emit/RequestBodyParameterEmitter.php`
- `runtime/src/Marshal/Marshaller.php`
- `examples/digitalocean/paogen.php`, `examples/github/paogen.php`
- `examples/*/generated/` (regenerated)
- `tests/`
