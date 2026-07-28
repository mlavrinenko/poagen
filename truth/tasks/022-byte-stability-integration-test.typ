#import "@local/mindtape:0.2.0": *

#show: task.with(
  id: "49f804d7-dc60-4168-907f-1758513c0495",
  title: "Assert byte-stability as an integration test, not just a scenario",
  status: done(2026, 4, 18),
  priority: 5,
  x-paogen: (spec: "truth/specs/model-generator.typ", decision: "truth/decisions/001-profile-driven-generation.typ", legacy-id: "T-022"),
)

== Summary

Golden-file testing is the only safety net outside per-feature tests.
The "run the generator twice and diff" invariant from ADR-001 is
asserted as a spec scenario but not by an independent integration test
against the Petstore fixture. Any drift between the fixture and a
real invocation is caught only when `just check-generated-tests`
happens to notice.

== Rationale

Pre-release review P2 #23 — packaging gap. Cheap to add and lifts
ADR-001's byte-stability promise out of the realm of "trust me" into
the test matrix.

== In scope

+ Add a PHPUnit integration test under `tests/` that:
  - Invokes the `Generator` twice in-process against the Petstore
    profile, writing to two temporary directories.
  - Asserts that every file is byte-for-byte identical between the
    two runs (and matches the golden fixture at
    `tests/fixtures/generated/petstore/`).
  - Cleans up the temp dirs afterwards.
+ Pair the test with a second one that runs generator-then-prune
  (once task 007 lands) against a schema edit and asserts the
  orphan is gone.
+ No spec changes — the behaviour is already specified in the
  Model Generator feature's byte-stability rule.

== Non-goals

- Running the check against schemas other than Petstore (future
  work once the validation-tier schemas land per ADR-005).
- Parallelising the two runs — serial is fine for v0.1.
- Benchmarking wall-time / memory (P3 item).

== Acceptance criteria

- A new PHPUnit test under `tests/Integration/` (create the
  directory if absent) passes against the current Petstore golden
  tree.
- `just check` green end-to-end.
