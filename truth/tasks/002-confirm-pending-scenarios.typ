#import "@local/speconaut:0.1.0": task, proposed

#show: task.with(
  title: "Record pending scenario confirmations in speconaut state.lock",
  status: proposed,
  date: datetime(year: 2026, month: 4, day: 18),
  priority: "normal",
  depends-on: ("001-speconaut-typst-mismatch",),
)

== Context

The "Operation Generator" feature (three scenarios, `truth/specs/operation-generator.typ`)
was specified and implemented in commit #raw("9146ad4"), but the
confirmations never landed in `.speconaut/state.lock` because
`speconaut implemented` is currently broken in this environment (see
task 001).

Additionally, the commit modified `src/Generator/Generator.php`, which
is traced by two *Model Generator* scenarios:

- "Each named schema component becomes a final readonly class"
- "Running the generator twice with the same inputs produces identical files"

Their trace hashes in the lockfile still point at the pre-edit
`Generator.php` (`sha256:c024f21f…`), not the current file
(`sha256:33613650…`).

== Action

Once task 001 is resolved:

+ `speconaut implemented -s "Each named schema component becomes a final readonly class"`
+ `speconaut implemented -s "Running the generator twice with the same inputs produces identical files"`
+ `speconaut implemented -s "A GET operation with a path parameter becomes a typed client method"`
+ `speconaut implemented -s "A POST operation with a JSON body takes a typed Model parameter"`
+ `speconaut implemented -s "A 2xx JSON response body is deserialized into the typed Model"`
+ Verify `just check-drift` exits 0.
+ Commit the lockfile delta as `chore(speconaut): confirm Operation
  Generator scenarios` (or equivalent).

== Verification

- `speconaut status` reports all features "ok" and the embedded hash
  check matches on-disk file hashes.
- `just gate` is green end-to-end.
