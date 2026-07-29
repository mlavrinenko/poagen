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

```bash
composer install
```

All tasks are exposed via [`just`](https://github.com/casey/just):

```bash
just            # list recipes
just check      # lint + test
just format     # auto-fix code style
just test       # run PHPUnit
```

### Tooling

| Purpose           | Tool                                                    |
| ----------------- | ------------------------------------------------------- |
| Code style        | [php-cs-fixer](https://cs.symfony.com) (PER-CS 2.0)     |
| Static analysis   | [PHPStan](https://phpstan.org) at `max` + strict rules  |
| Refactoring       | [Rector](https://getrector.com)                         |
| Tests             | [PHPUnit](https://phpunit.de)                           |
| Code generation   | [nette/php-generator](https://github.com/nette/php-generator) |

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
