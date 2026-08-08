#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "generate the standalone harness consumer instead of hand-writing it",
  tags: ("gates",),
  priority: 4,
  difficulty: 5,
  status: wip(2026, 8, 8)[dispatched to a worktree agent],
  links: (
    related(
      "keep-the-standalone-runtime-check-from-rotting-outside-the-gate.task-260805.typ",
    ),
  ),
)

== Summary

`keep-the-standalone-runtime-check-from-rotting-outside-the-gate` chose the
mitigation, not the cure. `tests/Integration/StandaloneHarnessTracksGeneratedApiTest.php`
now pins, inside the offline gate, the two API shapes
`scripts/verify-runtime-standalone`'s hand-written `run.php` depends on — the
`ApiClient` constructor's arity and order, and `getPetById` returning an
`Envelope` wrapping a `Pet`. That closes the two ways the harness has actually
drifted. It does not close the category.

Two gaps the decision records rather than hides. The test pins only those two
shapes: a changed endpoint URI, a renamed header, a different stub-transport
contract still drifts silently. And the pin is a copy of `run.php`'s
expectations, not a reading of `run.php` — so a future change that updates the
generated API and this test together, but not the harness, drifts exactly as
before with one more file to keep in step.

The pin is also brittle in a way worth naming: it asserts against generated
source text with exact whitespace and parameter names. A php-cs-fixer rule
change or a parameter rename that breaks nothing real still turns it red, and
the fix will look like "update the string", which is the reflex that empties a
pin of meaning.

The cure is that `run.php` stops being hand-written. The harness's consumer
side is derived from the generated tree the same run produces it from, so
there is nothing left to keep in step by hand and the whole category closes at
once.

== Acceptance criteria

- `scripts/verify-runtime-standalone`'s consumer code is derived from the
  generated tree rather than authored beside it, so a change to the generated
  API cannot leave the harness behind.
- Every drift the current test pins by hand is caught by construction after
  this lands, and the hand-written pins it replaces are removed rather than
  left as a second, now-redundant copy of the same expectations.
- The check still proves what it proved before: a generated client runs on
  `poagen/client-runtime` alone with the generator absent, asserted by name
  and not merely by the absence of a crash.
- It stays offline. The network dependency was removed in the task above and
  does not come back.
- A drift the derivation cannot catch — if any remains — is named in the
  script, not discovered later.

== Non-goals

- Does not move the recipe into `just check`. The scratch composer project is
  a heavier shape than the offline gate runs, and that call stands on its own.
- Does not change what the check proves.
- Does not generalise to the other examples. Petstore is the harness's subject
  because it is the tree the recipe copies.

== Files

- `scripts/verify-runtime-standalone`
- `tests/Integration/StandaloneHarnessTracksGeneratedApiTest.php`
- `Justfile`
