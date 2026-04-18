#import "@local/speconaut:0.1.0": task, proposed

#show: task.with(
  title: "Audit speconaut-phpunit's step-stub appender for multi-class files",
  status: proposed,
  date: datetime(year: 2026, month: 4, day: 18),
  priority: "low",
)

== Symptom

`speconaut-phpunit` appends new step-method stubs into *whichever class
appears last in the target Steps file*. When `OperationGeneratorSteps.php`
temporarily held a second class in the same file (`RecordingClient`),
the new stubs for the just-added query-parameter scenario were spliced
into `RecordingClient` instead of `OperationGeneratorSteps`. The file
still parsed but the steps were unreachable from the Test class.

Reproduction is in the diff between commits #raw("9146ad4") and the
follow-up that added query-parameter support: running
`just generate-tests` after adding a scenario placed the stubs in the
wrong class.

== Workaround already applied

Moved the helper class (`RecordingClient`) to its own file at
`tests/generated/RecordingClient.php`. With only
`OperationGeneratorSteps` left in `OperationGeneratorSteps.php` the
appender targets it correctly. This is now a convention to remember
rather than a tooling fix.

== Desired fix

Teach `speconaut-phpunit` to look up the Steps class *by name* rather
than by "last class in file" when appending stubs. The Test file
already references the Steps class by its fully-qualified name, so
the mapping is unambiguous.

== Related

- Depends on task 001 only in that all speconaut tooling shares a
  release cycle; this issue is independent of the check/extract
  mismatch.
