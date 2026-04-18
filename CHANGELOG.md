# mlavrinenko/paogen Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/)
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added

- Nothing.

### Changed

- `composer.json` `minimum-stability` flipped from `dev` to `stable`; all
  current deps are already stable releases, so this only tightens the
  invariant and prevents accidental `-dev` installs for downstream users.
- CLI version string now resolves from Composer's installed metadata
  (`Composer\InstalledVersions`) rather than a hardcoded constant, so releases
  installed via Packagist report the real tag and in-repo runs report
  `dev-<branch>`.
- PHPUnit configuration scopes deprecation tracking to `src/`
  (`ignoreIndirectDeprecations="true"`). PHP 8.4 deprecations triggered from
  `cebe/php-openapi` no longer clutter test output. Tracking a replacement
  parser is captured under `truth/tasks/`.
- `tests/bootstrap.php` suppresses `E_DEPRECATED` / `E_USER_DEPRECATED` at
  the PHP level for the same reason; the per-test `error_reporting()`
  dance in `OperationGeneratorSteps` is gone.

### Deprecated

- Nothing.

### Removed

- Dropped the unused `infection/infection` dev dependency (and its
  transitive plugin allow-list entry). Mutation testing was advertised in
  `CONTRIBUTING.md` but never wired up; a task in `truth/tasks/` records
  the decision to re-introduce it deliberately or leave it out.

### Fixed

- Nothing yet.

## 0.1.0 - TBD

First pre-release. Pending items are tracked under `truth/tasks/` and
summarised in `docs/reviews/2026-04-18-pre-release-review.md`.
