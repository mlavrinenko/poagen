#import "@local/speconaut:0.1.0": task, proposed

#show: task.with(
  title: "ClientEmitter renders scalar-VO / ScalarBinding path params via toScalar()",
  status: proposed,
  date: datetime(year: 2026, month: 4, day: 20),
  priority: "medium",
  spec: "truth/specs/operation-generator.typ",
)

== Summary

T-026 emits a `ScalarBinding`-implementing VO for every top-level
scalar component (DO's `urn`, `ssh_key_id`, `ssh_key_fingerprint`,
GitHub's `alert-number`, ...). Downstream `$ref`s now resolve to a
real class. `RequestAssembler::stringExpr()` does not know about
these classes yet, so for path / query / header parameters whose
schema `$ref`s a scalar VO (or is an `anyOf` / `oneOf` of such refs)
the emitter still writes `(string) $var` — which PHPStan rejects:

```
Generated/ApiClient.php:453: sshKeys_get(
    SshKeyId|SshKeyFingerprint $ssh_key_identifier,
): void {
    $path = \str_replace(
        '{ssh_key_identifier}',
        (string) $ssh_key_identifier,  # ← cast.string error
        $path,
    );
}
```

Same error for `alert-number`, `workflow-run-id`, any DO `ssh_key_*`
path param.

== Rationale

Without this, the DO and GitHub golden trees remain noisy under
`phpstan-generated.neon` (~20 `cast.string` + matching
`argument.type` errors). T-026 closed `class.notFound`; this task
closes the immediate downstream `cast.string` wave that T-026
exposed. Every `ScalarBinding` already carries a `toScalar()` method
whose return type is `string|int|float|bool`, so the fix is a local
rendering change in one place.

== In scope

+ Teach `RequestAssembler::stringExpr()` to accept the
  `ComponentCatalog` (or an equivalent shape hint) so it can detect
  when the parameter schema is a `$ref` to — or an `anyOf` / `oneOf`
  of refs to — a scalar-VO component.
+ In that case, emit `(string) $var->toScalar()` instead of
  `(string) $var`. Union-of-ScalarBindings works because every branch
  is guaranteed to expose `toScalar()`.
+ Thread the `ComponentCatalog` through the emitter chain
  (`ClientEmitter` → `OperationEmitter` → `RequestAssembler`).
+ Add an Operation Generator scenario locking a path-param that
  `$ref`s a scalar component: the emitted line is
  `(string) $param->toScalar()`, not `(string) $param`.
+ Regenerate `examples/digitalocean/generated` and
  `examples/github/generated`; `phpstan analyse -c
  phpstan-generated.neon` no longer reports `cast.string` against a
  Model-ScalarBinding type.

== Out of scope

- The pre-existing `Cannot access property $value on string` errors
  (T-025 era; enum-vs-string mismatch in array query params); those
  belong to their own follow-up.
- The pre-existing `parameter.requiredAfterOptional` errors
  (~7000); those belong to their own follow-up.
- Mutation of the `ScalarBinding` interface shape — the fix lives
  purely in the emitter.

== Acceptance

- New Operation Generator scenario locking the emitted expression
  for a path parameter whose schema `$ref`s a top-level scalar
  component (e.g. DO's `ssh_key_id`).
- `examples/digitalocean/generated` and
  `examples/github/generated` carry zero `cast.string` errors
  whose message references a `Model\*` class.
- `just check` and `just check-examples` green.
