#import "@local/speconaut:0.1.0": task, proposed

#show: task.with(
  title: "Make speconaut-phpunit's step-stub appender class-aware",
  status: proposed,
  date: datetime(year: 2026, month: 4, day: 18),
  priority: "low",
)

== Summary

`speconaut-phpunit` appends new step-method stubs into *whichever
class appears last in the target Steps file*, not the class named by
the Test file. While
`tests/generated/OperationGeneratorSteps.php` temporarily held a
helper class (`RecordingClient`) after `OperationGeneratorSteps`, a
`just generate-tests` run spliced the stubs into `RecordingClient` —
leaving them unreachable from `OperationGeneratorTest` and silently
breaking the feedback loop.

== Rationale

The generated Test file already references the Steps class by its
fully-qualified name. Step-stubs should append into the class the Test
calls into, not a lexical "last class wins" heuristic that breaks the
moment a Steps file grows a helper class.

== Reproduction

Before the workaround in commit #raw("78f1e40"):

+ Keep `RecordingClient` and `OperationGeneratorSteps` in the same
  file, helper class last.
+ Add a new scenario to the spec.
+ Run `just generate-tests`.
+ Observe the new `givenX`/`thenY` stubs land inside `RecordingClient`.

== Current workaround

Helper classes used by Steps files live in their own files
(see `tests/generated/RecordingClient.php`). Steps files contain a
single class, so the appender targets it correctly.

== Acceptance

- `speconaut-phpunit` appends stubs to the class named by the Test
  file's `new <StepsClass>($this)` call, regardless of class order.
- The convention "one class per Steps file" is documented as a
  nice-to-have rather than a hard requirement.
