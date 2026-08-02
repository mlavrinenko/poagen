#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "pathitem level parameters are invisible to the document wide scan",
  tags: ("generator", "openapi-31"),
  priority: 3,
  difficulty: 2,
  status: proposed(2026, 8, 3),
)

== Summary

SchemaWalk operationRoots reads an operation's own parameters only, at SchemaWalk.php line 99, so a parameter declared once on a PathItem and shared by every operation under it never reaches the document-wide probe. TypeListScanner therefore cannot see a multi-member type declared on a shared parameter.

Found while closing path-parameters-run-through-no-shape-gate-at-all. The emitter's own refusal does cover that case, because the analyser merges path-item parameters before gating them; it is the pre-scan alone that is blind. So the consequence today is narrow: a probe that reports what 3.1 constructs a document uses under-reports them for one declaration site.

Filed rather than fixed because it is one line of walk and a fixture, and it belongs with whoever next has that file open.

== Acceptance criteria

- The document-wide walk yields parameters declared at the PathItem level as well as on the operation, without yielding a shared parameter once per operation that inherits it.
- A fixture declares a multi-member type on a PathItem-level parameter and the probe reports it.
- The emitter's existing refusal for that shape is unchanged.

== Non-goals

- How the analyser merges path-item parameters into an operation, which is correct.
- Any other walk root.

== Files

- src/Generator/Emit/SchemaWalk.php
- tests/fixtures/
