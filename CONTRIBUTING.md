# Contributing

Contributions are welcome. This project accepts pull requests on [GitHub][github].

This project adheres to a [code of conduct](CODE_OF_CONDUCT.md). By participating
in this project and its community, you are expected to uphold this code.

## Communication Channels

* GitHub Issues: <https://github.com/mlavrinenko/paogen/issues>

## Developing

Requirements: [PHP](https://www.php.net) 8.4+ and [Composer](https://getcomposer.org).

This repo uses [devbox](https://www.jetify.com/docs/devbox/) to pin toolchain
versions. If you have `devbox` + `direnv` set up, the environment is loaded
automatically when you `cd` into the repo.

`composer.lock` is committed, so `composer install` — never `composer update`
— reproduces the exact phpstan / rector / php-cs-fixer versions the gate was
last green under. paogen is an application, not a library: nothing else pins
its QA tooling, so an uncommitted lock means every checkout resolves its own
versions and `just check` can pass on one machine and fail on another for no
real reason.

```bash
composer install
```

All tasks are exposed via [`just`](https://github.com/casey/just):

```bash
just            # list recipes
just check      # lint + test-with-coverage-floor + speconaut check-specs
just format     # auto-fix code style
just test       # run PHPUnit, fast, no coverage instrumentation
just test-coverage  # run PHPUnit with coverage and enforce the floor
```

### Tooling

| Purpose           | Tool                                                    |
| ----------------- | ------------------------------------------------------- |
| Code style        | [php-cs-fixer](https://cs.symfony.com) (PER-CS 2.0)     |
| Static analysis   | [PHPStan](https://phpstan.org) at `max` + strict rules  |
| Refactoring       | [Rector](https://getrector.com)                         |
| Duplication       | [jscpd](https://github.com/kucherenko/jscpd) (ratchet: `just lint-jscpd`, `just lint-jscpd-generated`) |
| Coverage          | [PHPUnit](https://phpunit.de) + [PCOV](https://github.com/krakjoe/pcov) (ratchet: `just test-coverage`, `scripts/coverage-floor`) |
| Tests             | [PHPUnit](https://phpunit.de)                           |
| Code generation   | [nette/php-generator](https://github.com/nette/php-generator) |

### Coverage floor

`just check` (and CI's dedicated coverage job) enforce a statement-coverage
floor, per tier, over `src/` and `runtime/src/` — the two source trees a
human writes. `tests/fixtures/generated` and `examples/*/generated` never
count toward either figure: that is emitted output, already gated by the
generated-tier PHPStan config, the byte-stability fixtures, and `just
check-examples`, and counting it would inflate the number with code no
human wrote. See `truth/decisions/coverage-floor-in-the-gate.decision-260801.typ`
for the full reasoning, including why this does not reopen ADR-004's
rejection of codecov.

Two floors, not one: `src/` and `runtime/src/` are measured and gated
independently, because the runtime ships as its own installable package
(`runtime-ships-as-a-separate-package`) — a single blended number would let
a regression in either tier hide behind the other's tests.

The floor values live as arguments next to a `RATCHET` comment in the
Justfile's `test-coverage` recipe (and mirrored in `composer.json`'s
`test:coverage`), the same pattern `lint-jscpd`'s `--threshold` uses for
duplication — one greppable place per number. They only ever move **up**,
as real tests raise the measured figure. Lowering one to let a change land
is not a fix, it disables the gate; conversely, never raise one by writing
a test that asserts nothing just to hit the number — a floor met that way
is worse than no floor.

`scripts/coverage-floor` reads the clover report `just test-coverage`
produces, sums statements per tier, and fails naming the tier, the
measured percentage and the floor it missed.

Run it locally:

```bash
just test-coverage        # or: composer test:coverage
```

PCOV auto-detects its instrumentation root (`pcov.directory`) from the
working directory, and that auto-detection lands on `src/` alone —
`runtime/src/` would silently report 0% forever if nothing corrected it.
Both `just test-coverage` and `composer test:coverage` pass `-d
pcov.directory=.` explicitly so every tier `phpunit.xml.dist`'s `<source>`
lists is actually instrumented; verify this is still true after any
toolchain change with `php -d pcov.directory=. -i | grep pcov.directory`
under the exact command the recipe runs.

### Regenerating a fixture golden tree

`tests/fixtures/profiles/*.php` describe the generator's own test fixtures —
`petstore`, `parameters`, `contact`, `composition`,
`undiscriminated-oneof-resolved` — and each one's `output:` defaults to a
scratch directory under `$TMPDIR`
(`tests/fixtures/profiles/scratch-output.php`), never to the committed
golden tree it has the same name as. A `just test` or `just check` run loads
these profiles and generates from them, but it always writes to scratch and
never touches `tests/fixtures/generated/<name>/`.

That is deliberate: those directories are checked-in golden output, and
`tests/Integration/ByteStabilityTest.php` (and any sibling that regenerates
a fixture tree) compares fresh scratch output against them rather than
overwriting them. A fixture profile that wrote straight into its own golden
by default meant a test run silently regenerated the golden it was supposed
to be checked against — harmless when the generator agrees with the golden
byte for byte, and silent corruption the moment it does not. See
`truth/tasks/fixtures-generate-to-a-scratch-tree.task-260802.typ`.

Updating a golden on purpose — after an intentional generator change — is
still supported, just explicit:

```bash
just regenerate-fixture parameters
```

which runs `paogen generate` against that profile with `--output` pointed at
the real `tests/fixtures/generated/parameters` tree, overriding the
profile's scratch default for that one invocation. Review the diff before
committing; `git diff tests/fixtures/generated/parameters` is the whole
review.

### Closing a task

`truth/tasks/` is tracked with [MindTape](https://github.com/mlavrinenko/mindtape)
(`mt`). Flipping a task to `done` (`mt done <task>`, or `mt flip done <task>`)
runs an `[[on.flip]]` gate declared in `.mindtape/config.toml`: it refuses the
flip unless `just check` has already passed against the current worktree.

The gate does not run `just check` itself — that would make every close as
slow as the full lint+test+spec suite, and slow gates get bypassed with
`--force`. Instead it *asserts* a prior pass, via `scripts/gate-fresh
is-fresh`, which hashes the files `just check` reads (declared in
`scripts/gate-fresh.inputs`) and compares against the hash recorded the last
time the gate actually ran and passed.

So before flipping a task to `done`, run:

```bash
scripts/gated-check   # runs `just check`; on success, records the pass
mt done <task>
```

A bare `just check` still lints and tests your work correctly; it just does
not leave the record `mt flip`'s gate looks for, so the flip would be
refused immediately afterward with a message telling you to run
`scripts/gated-check`.

This stands in for `mmz --is-fresh -- just check` (a memoized command
runner, github:mlavrinenko/mmz) — the shape `.mindtape/config.toml`'s own
comments recommend. `mmz` is not part of this repo's toolchain (not in
`devbox.json`, not resolvable on `PATH`), so `scripts/gate-fresh` implements
the same assertion directly rather than adding a dependency the project does
not otherwise have. If `mmz` (or an equivalent) is ever added to
`devbox.json`, it can replace `scripts/gate-fresh` in the `[[on.flip]]`
`run` command with no other change needed.

`scripts/gate-fresh.inputs` deliberately excludes `truth/tasks`: `mt flip`
rewrites the status field (and note) of the task file it is closing, and
`just check` does not read `truth/tasks` for anything the gate cares about,
so including it would invalidate the freshness record on every flip and the
gate could never pass a second time.

`mt done --force <task>` bypasses a failing gate and records the override in
the task's status note, so the bypass leaves a trace instead of vanishing.

### Commit Messages

This project follows the [Conventional Commits][cc] specification. Keep commit
messages focused on the *why*, not the *what* — the diff speaks for itself.

Every commit carries a `Refs:` trailer naming the task it belongs to, using the
task's slug — the filename stem without the `.task-<yymmdd>.typ` suffix:

```
refactor(generator): synthesise models from inline payloads

Refs: inline-body-and-response-schemas
```

Slugs are stable and greppable, so `git log --grep` finds every commit behind a
task and `truth/tasks/<slug>.task-*.typ` is always the matching artifact. List
them with `mt ls`. A commit spanning several tasks repeats the trailer, one per
line. Work with no task behind it needs a task first — that is the point of the
trailer, not a formality it satisfies.

A commit whose type is `dev:` or `chore:` is exempt from the trailer — those
are process/tooling commits with no task of their own by design.

This is enforced, not just documented. `just install` (or `just install-hooks`
on its own) sets `core.hooksPath` to `.githooks`, and its `commit-msg` hook
rejects a commit that has neither an exempt type nor a `Refs:` trailer whose
slug resolves to a real `truth/tasks/<slug>.task-*.typ` — a trailer naming a
task that does not exist fails the same way a missing trailer does. For
emergency local WIP, `PAOGEN_SKIP_TASK_CHECK=1 git commit ...` bypasses the
check for that one commit; the hook still runs and prints a warning, so the
bypass is visible rather than silent, and the trailer is expected before the
commit leaves your machine.

To audit a range of existing history — in CI or by hand — run
`just check-commit-trailers <rev-range>`, e.g.
`just check-commit-trailers origin/main..HEAD`. It applies the identical rule
commit by commit and is unaffected by `PAOGEN_SKIP_TASK_CHECK`.

### Pull Requests

* One feature per PR.
* Use topic branches (not your `main`).
* Include tests for new behavior.
* Ensure `just check` passes locally before opening the PR.

## Reporting Bugs

Use the [issue tracker][issues]. Include:

* What you expected to happen
* What actually happened (including stack traces / CLI output)
* Minimal reproduction (schema snippet + command line)
* PHP / paogen version (`paogen --version`)

⚠️ Do not include secrets or proprietary schemas. Redact before posting.

## Security

For security issues, see [SECURITY.md](SECURITY.md). Please do **not** file
public GitHub issues for vulnerabilities.

[github]: https://github.com/mlavrinenko/paogen
[issues]: https://github.com/mlavrinenko/paogen/issues
[cc]: https://www.conventionalcommits.org/
