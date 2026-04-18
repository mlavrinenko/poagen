# mlavrinenko/paogen Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/)
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added

- Generator now prunes stale files under `Generated/` at the end of every
  run. Any `.php` emitted on a prior run but absent from the current
  emitted set is `unlink`-ed, restoring the byte-stability promise on
  component rename / removal. The walk is strictly scoped to the
  `Generated/` subtree so user files placed alongside it are never
  touched.
- `paogen validate <schema>` subcommand promised by ADR-006. Parses a
  YAML or JSON OpenAPI document, runs `OpenApi::validate()`, and reports
  parse / validation / usage errors on stderr. Exit codes: 0 on success,
  1 on file / parse / validation failure, 2 on missing argument.
- Every generated Model now publishes `public const array PROPERTY_MAP`
  and implements `\JsonSerializable` per ADR-007. The map pairs each
  PHP property name with `[wireKey, shape]` where `shape` is `null`
  (scalar), `\FQCN::class` (model `$ref`), or `['list', null|\FQCN]`
  (array / array of model). The emitted `jsonSerialize()` returns the
  array keyed by wire names.

### Changed

- `composer.json` `minimum-stability` flipped from `dev` to `stable`; all
  current deps are already stable releases, so this only tightens the
  invariant and prevents accidental `-dev` installs for downstream users.
- CLI version string now resolves from Composer's installed metadata
  (`Composer\InstalledVersions`) rather than a hardcoded constant, so releases
  installed via Packagist report the real tag and in-repo runs report
  `dev-<branch>`. `Cli::version()` is public and accepts an optional package
  name so the `dev` fallback path can be regression-tested. The
  `paogen --help` `USAGE` block gained a `NOTES` section documenting that
  the printed version reflects the installed package, not the working copy.
- PHPUnit configuration scopes deprecation tracking to `src/`
  (`ignoreIndirectDeprecations="true"`). PHP 8.4 deprecations triggered from
  `cebe/php-openapi` no longer clutter test output. Tracking a replacement
  parser is captured under `truth/tasks/`.
- `tests/bootstrap.php` suppresses `E_DEPRECATED` / `E_USER_DEPRECATED` at
  the PHP level for the same reason; the per-test `error_reporting()`
  dance in `OperationGeneratorSteps` is gone.
- `bin/paogen` now does the same `E_DEPRECATED` / `E_USER_DEPRECATED`
  suppression at CLI entry, so `paogen validate` and `paogen generate`
  no longer print cebe's PHP 8.4 nullable-type deprecations to stderr.
  Scoped to the CLI process only.

### Deprecated

- Nothing.

### Removed

- Dropped the unused `infection/infection` dev dependency (and its
  transitive plugin allow-list entry). Mutation testing was advertised in
  `CONTRIBUTING.md` but never wired up; a task in `truth/tasks/` records
  the decision to re-introduce it deliberately or leave it out.

### Fixed

- Hydrator no longer silently half-populates Models whose schema keys
  aren't valid PHP identifiers (e.g. kebab-case `display-name`). The
  generated `ApiClient::hydrate()` now consults `PROPERTY_MAP` to
  translate wire keys → PHP property names. Previously, reflection
  matched by PHP name only and missed every mangled wire key.
- Hydrator now recurses into `list<Model>` properties via the shape
  directive in `PROPERTY_MAP`, producing real lists of typed objects
  instead of raw associative arrays. Previously, reflection saw the
  builtin `array` type on `?array $tags` and stopped — the declared
  `@param list<Tag>` phpdoc contract was silently violated at the
  first `$pet->tags[0]->name`.

## 0.1.0 - TBD

First pre-release. Pending items are tracked under `truth/tasks/` and
summarised in `docs/reviews/2026-04-18-pre-release-review.md`.
