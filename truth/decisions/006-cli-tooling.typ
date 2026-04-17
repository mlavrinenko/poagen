#import "@local/speconaut:0.1.0": adr, accepted

#show: adr.with(
  number: 6,
  title: "Use plain PHP `getopt()` for the CLI",
  status: accepted,
  date: datetime(year: 2026, month: 4, day: 17),
)

== Context

The `paogen` binary exposes a small CLI surface:

- `paogen generate <profile> [--output=<dir>]`
- `paogen validate <schema>`
- `paogen --help`, `paogen --version`

Realistic options for the CLI layer:

#table(
  columns: (auto, 1fr, 1fr),
  [*Option*], [*Pros*], [*Cons*],
  [`symfony/console`],
  [Batteries-included, sub-commands, completion scripts],
  [Heavy (symfony/console + string + service-contracts)],

  [`minicli/minicli`],
  [Zero runtime deps, small],
  [Less polish, smaller community],

  [`league/climate`],
  [Nice output primitives],
  [Still a dep; overkill for our needs],

  [Plain PHP (`getopt()`)],
  [No deps, obvious behavior],
  [No free `--help` generation; we write it ourselves],
)

== Decision

Use plain PHP with `getopt()`. The CLI surface is tiny (≤5 commands) and
will not grow beyond that — the *generator* does the work; the CLI is a
thin entry point. Dependencies are a liability here: any bug or CVE in the
CLI lib forces a point release in a tool that is meant to be boring and
reliable.

If the CLI surface ever grows past what `getopt()` can carry cleanly,
migrate to `minicli/minicli` first (near-zero cost) before considering
`symfony/console`.

== Consequences

- `bin/paogen` is hand-rolled; `src/Cli.php` contains the dispatch.
- Help text is a single `const` string. Keep it short.
- No autocompletion scripts out-of-the-box. Fine for a generator.
