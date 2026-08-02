#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Zero-statement interfaces, enums, and marker classes never register as covered",
  tags: ("speconaut", "traceability"),
  priority: 3,
  difficulty: 3,
  status: proposed(2026, 8, 2),
)

== Summary

Filed from the `d879084`-lineage spot-check in
`restore-coverage-derived-traceability` (the actual deleting commits are
`8badb4b` for Model Generator and `f4a8b83` for CLI/Operation
Generator/Profile — the task text's `d879084` citation is stale; that commit
only touched `.speconaut/config.toml` and task renames, not any spec file).

Three files a human explicitly declared as traced in the deleted
hand-authored `traces:` tuples are still untraced under today's real
coverage run, and all three share the same shape: they carry no executable
PHP statement of their own.

- `src/Generator/Naming/NameNormaliser.php` — a bare interface. The
  scenario that named it, "A pattern-gated strategy only handles names
  matching its pattern and falls through otherwise", still runs today and
  covers all four concrete implementers (`CompositeNormaliser.php`,
  `NameRegistry.php`, `PascalCaseSanitiser.php`, `AsciiFolder.php`) but not
  the interface they implement — `NameNormaliser` is used only in phpdoc
  array-shape hints (`array<NameNormaliser>`), never a native param type, so
  nothing forces the autoloader to load the file.
- `src/Generator/Naming/SymbolKind.php` — a plain, caseless enum
  (`SchemaComponent`, `OperationId`, `ParameterName`, `Tag`). Same story:
  used, never autoloaded under a native type.
- `src/Exception/InvalidProfileException.php` — `final class
  InvalidProfileException extends RuntimeException {}`, no body at all. The
  scenario that named it, "A PHP file that does not return a Profile is
  rejected", still runs today and its coverage shows only
  `ProfileLoader.php` — the exception is almost certainly thrown and caught
  exactly as the scenario describes, but a class with zero of its own
  executable lines has nothing for line-based coverage to mark as hit,
  regardless of whether it runs. Contrast
  `src/Exception/ModelNameCollisionException.php`, an equally "pure-data"
  exception that *is* auto-classified plumbing today, purely because it
  carries a static factory method (`between()`) with an executable
  `sprintf` call in its body — the only difference between the two files is
  that one happens to have a line to count.

None of these are missing tests. The behaviour each scenario claims is
almost certainly still exercised; line coverage is structurally blind to
whether a zero-statement file was reached, so it cannot confirm or deny the
claim either way, and the file falls through both the "covered" and
"plumbing" buckets (plumbing classification is itself coverage-triggered —
a file with zero touches never enters the classifier) into "untraced",
indistinguishable from a real gap.

== Acceptance criteria

- Decide whether the classifier (or the host-side untraced-source check)
  should special-case files with no executable statement — auto-classifying
  them plumbing regardless of touch — the same way `[audit-traces].plumbing.files`
  lets a human pin one by hash today, or whether that decision belongs to
  a human via that existing pin mechanism instead. Record whichever is
  chosen and why.
- If tooling-side: implemented in speconaut (this is upstream, not a paogen
  source change — file it there per `~/projects/home/speconaut/truth/tasks/`
  if that is the direction).
- If human-pin-side: `NameNormaliser.php`, `SymbolKind.php`, and
  `InvalidProfileException.php` get `[[audit-traces.plumbing.files]]`
  entries in paogen's own `.speconaut/config.toml`, each with the reason
  above.

== Non-goals

- Fixing this for `runtime/src` — that gap has a different cause (out of
  the BDD loop entirely, not zero-statement) and is filed separately as
  `decide-runtimes-place-in-spec-derived-coverage`.
- Auditing every other file under the configured source roots for the same
  shape — these three are the ones the spot-check actually surfaced.

== Files

- `.speconaut/config.toml` — if the human-pin route is chosen
