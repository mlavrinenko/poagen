#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Report unrecognised format annotations instead of degrading silently",
  tags: ("strictness", "generator"),
  priority: 6,
  difficulty: 3,
  status: done(2026, 8, 1),
)

== Summary

An unknown `format` falls through to the bare base type with no diagnostic. Real schemas make this common and consequential: the kilbil loyalty document carries 172 occurrences of `format: int`, 94 of `format: double`, 15 of `format: "date time"` with a space where a hyphen belongs, three of `format: "data time"` which is a typo for the same thing, plus `phone` and `data`. Several sit on a string type rather than a numeric one. Every one of these is a place a user could bind their own value object and get a typed field, and today nothing tells them the opportunity exists.

== Acceptance criteria

- The plan reports every format annotation the generator did not recognise, with the component or operation and property that carried it, and a count.
- The report names the mechanism for binding a value object to that format.
- Recognised built-ins and user-bound formats are not reported.
- Whether an unrecognised format is a hard failure follows the profile policy established by the abort-on-unrepresentable-constructs task, rather than inventing a second policy here. Applying that policy resolves to "not a failure": nothing is omitted from the emitted tree, and the distinction that policy draws is between a run that shrank the client and a run that could be more pleasant. So the report is a notice on the plan, printed to stderr after the skip lists, and it never moves the exit status — the same channel the unseparated-operation-id advisory uses.
- One line per distinct format, with a use count and one document location, ordered by descending count. Once per use would bury the rest of the output: kilbil has 292 uses across nine values.
- Recognised means paogen already resolves the format to a real type — one of its built-ins, or one the consumer bound. Standard width hints like `int64` are still reported, because a consumer may want a value object over one and a rule deciding which formats are "already good enough" would be the generator choosing on their behalf.
- `#[BindsFormat]` is repeatable, so one value object answers several spellings. Without that, the three ways kilbil misspells `date-time` would need three near-identical classes.
- The kilbil example binds the four format values that carry meaning — `date time`, `data time`, `data`, `phone` — under `examples/kilbil/src/ValueObject/`, and those four drop out of the report while appearing as types in the emitted tree. `int` and `double` stay unbound and reported: the point is that the opportunity is visible, not that every opportunity is taken.

== Non-goals

- Guessing what a misspelled format meant; the generator reports, the user binds.
- Shipping built-in bindings for vendor-specific formats.

== Files

- `src/Generator/Emit/FormatAdvisor.php` (new)
- `src/Generator/Attribute/BindsFormat.php` (repeatable)
- `src/Generator/Generator.php`
- `examples/kilbil/paogen.php` and `examples/kilbil/src/ValueObject/`
- `composer.json` (autoload-dev, so the example VOs resolve when `check-examples` runs from the repo root)
- `tests/`
