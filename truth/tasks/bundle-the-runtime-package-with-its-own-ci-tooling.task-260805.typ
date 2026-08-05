#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Bundle the runtime package with its own CI tooling",
  tags: (),
  priority: 5,
  difficulty: 5,
  status: accepted(2026, 8, 5),
  links: (related("publish-the-runtime-package-to-packagist.task-260802.typ"),),
)

== Summary

`runtime/` is a package in name only. It carries a `composer.json` that
declares `poagen/client-runtime` and nothing else: no `require-dev`, no
tests, no PHPStan config, no formatter config, no CI workflow. Every one
of those lives at the repository root and is written monorepo-shaped —
`phpstan.neon.dist` analyses `bin src runtime/src tests` as one tree, the
coverage floor names two paths, and the tests that exercise
`Poagen\Runtime\*` sit in `tests/Unit/Runtime/` under a
`Poagen\Generator\Tests\` namespace.

That is fine while the two packages share a checkout. It stops being fine
the moment `runtime/` is extracted to `poagen-runtime`, because the
extracted repository would arrive with source and no way to check it —
a published package whose CI is a directory it can no longer see. The
extraction would then either ship unverified or grow a second, hand-copied
set of configs that drifts from this one.

The fix is to make `runtime/` self-contained *here*, in the monorepo, so
that extraction is a mechanical `git subtree split` of a directory that
already builds, tests and lints on its own. One source of truth, and the
extracted repository inherits a CI that has been running all along rather
than one written the day it was split off.

== Acceptance criteria

- `runtime/` holds its own `composer.json` with `require-dev` and `scripts`,
  `phpunit.xml.dist`, `phpstan.neon.dist`, `rector.php`,
  `.php-cs-fixer.dist.php`, `.jscpd.json`, `.linecop.yaml`, `.editorconfig`,
  `Justfile`, `.gitignore`, `README.md`, `LICENSE`, and a GitHub Actions
  workflow — each scoped to the runtime tree alone, with no path escaping
  `runtime/`.
- The tests that exercise `Poagen\Runtime\*` live in `runtime/tests/` under a
  `Poagen\Runtime\Tests\` namespace, not in the generator's test tree.
- A `git subtree split --prefix=runtime` of the resulting tree, checked out
  in isolation with the generator absent, passes its own `just check`. This
  is the criterion that proves the point, and it must be demonstrated, not
  asserted.
- Root `just check` stays green, and the runtime's coverage floor is still
  enforced at its current level — the tests moved, so the floor must still
  find them.
- The runtime's PHPStan runs at the same level as the root's. Extraction is
  not an excuse to lower a bar.
- No config file is duplicated between root and `runtime/` in a way that lets
  the two disagree silently: either the root delegates to the runtime's, or
  the split is stated in a comment naming why.

== Non-goals

- Does not extract the repository. That is
  `publish-the-runtime-package-to-packagist` and whatever follows it; this
  task only makes the extraction mechanical.
- Does not publish anything, to Packagist or elsewhere.
- Does not touch `src/` (the generator), `examples/`, or the emitted-code
  tier (`phpstan-generated.neon`, `.jscpd.generated.json`). Those stay with
  the generator.
- Does not change any runtime behaviour. Files move and configs are added;
  `runtime/src/` keeps its current contents.

== Files

- `runtime/composer.json`, `runtime/phpunit.xml.dist`,
  `runtime/phpstan.neon.dist`, `runtime/rector.php`,
  `runtime/.php-cs-fixer.dist.php`, `runtime/.jscpd.json`,
  `runtime/.linecop.yaml`, `runtime/.editorconfig`, `runtime/Justfile`,
  `runtime/.gitignore`, `runtime/README.md`, `runtime/LICENSE`,
  `runtime/CHANGELOG.md`, `runtime/.github/workflows/`
- `runtime/tests/` (moved from `tests/Unit/Runtime/`)
- `composer.json`, `phpunit.xml.dist`, `Justfile`, `phpstan.neon.dist`,
  `rector.php`, `.php-cs-fixer.dist.php`, `.jscpd.json`, `.linecop.yaml` —
  reconciled at the root for the moved tests
