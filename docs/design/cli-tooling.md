# CLI Tooling Decision

**Status:** accepted  
**Date:** 2026-04-17

## Context

The `paogen` binary exposes a small CLI surface:

* `paogen generate <schema> [--output=<dir>] [--namespace=<ns>]`
* `paogen validate <schema>`
* `paogen --help`, `paogen --version`

There are three realistic options for the CLI layer:

| Option                                                    | Pros                                     | Cons                                                |
| --------------------------------------------------------- | ---------------------------------------- | --------------------------------------------------- |
| [`symfony/console`](https://symfony.com/doc/current/components/console.html) | Batteries-included, sub-commands, completion scripts | Heavy (symfony/console + string + service-contracts) |
| [`minicli/minicli`](https://github.com/minicli/minicli)   | Zero runtime deps, small                 | Less polish, smaller community                      |
| [`league/climate`](https://github.com/thephpleague/climate) | Nice output primitives                 | Still a dep; overkill for our needs                 |
| **Plain PHP (`getopt()`)**                                | No deps, obvious behavior                | No free `--help` generation; we write it ourselves  |

## Decision

Use **plain PHP with `getopt()`**. The CLI surface is tiny (≤5 commands) and
will not grow beyond that — the *generator* does the work; the CLI is a thin
entry point. Dependencies are a liability here: any bug or CVE in the CLI lib
forces a point release in a tool that's meant to be boring and reliable.

If the CLI surface ever grows past what `getopt()` can carry cleanly, migrate
to `minicli/minicli` first (near-zero cost) before considering `symfony/console`.

## Consequences

* `bin/paogen` is hand-rolled; `src/Cli.php` contains the dispatch.
* Help text is a single `const` string. Keep it short.
* No autocompletion scripts out-of-the-box. Fine for a generator.
