#import "@local/speconaut:0.1.0": *

#show: goal.with(
  title: "Generated output survives the strictest static analysis",
  status: active(2026, 7, 29),
  acid-test: [
    Point the strictest available static-analysis configuration at the
    generated tree — maximum level, strict rule sets, deprecation rules
    enabled — with no baseline file, no suppression annotations, and no
    per-path exclusions. It reports zero findings. The same holds for the
    project's style and modernisation linters.
  ],
)

A generated tree that has to be excluded from the project's checks is a
generated tree the project cannot trust. The moment a consumer adds an
ignore rule for it, the boundary between "the generator's problem" and
"my problem" dissolves, and every future finding inside that directory
becomes invisible.

So the output carries its own proof. Types are exhaustive rather than
convenient: no escape-hatch value where a real type was derivable, no
suppression annotation, no unchecked cast that the analyser merely
tolerates.

Where the schema genuinely does not determine a type, that is a fact
about the schema and it must surface as a generation-time decision the
user can influence, not as a permissive type quietly emitted into their
codebase.
