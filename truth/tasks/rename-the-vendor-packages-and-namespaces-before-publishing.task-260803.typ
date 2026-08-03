#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "rename the vendor packages and namespaces before publishing",
  tags: ("release", "naming"),
  priority: 4,
  difficulty: 4,
  status: proposed(2026, 8, 3),
)

== Summary

Owner ruling, 2026-08-03: both packages publish under a new vendor and new
names, with the PHP namespaces renamed to match. This has to happen before
anything is tagged, because a Packagist name and a published namespace are
both one-way doors.

Today, and where each string lives:

- `mlavrinenko/paogen`, namespace `Mlavrinenko\Paogen\` — `composer.json`
  autoload map, every file under `src/`, `tests/` (four autoload-dev prefixes,
  including two that point at fixture trees).
- `mlavrinenko/paogen-runtime`, namespace `Mlavrinenko\Paogen\Runtime\` —
  `runtime/composer.json`, every file under `runtime/src/`, and every emitted
  client, because generated code imports the runtime contracts by FQCN.

Target, as the owner gave it:

- generator: `poagen/client-generator`
- runtime: `poagen/client-runtime`
- kilbil client: `maximaster/kilbil-client`, in its own repository
  (`extract-the-kilbil-client-to-its-own-repository`)

=== One string to confirm before any rename runs

The owner wrote the vendor as `poagen`. This repository, its binary, its
documentation and its every artifact spell the project `paogen`. Those differ
by a transposition, and the difference is not recoverable after a Packagist
name is claimed and a namespace ships in someone's `composer.lock`.

So the first thing this task does is get a one-word confirmation: `poagen` or
`paogen`. Do not start the rename without it. Both readings are plausible —
`poagen` may be a deliberately distinct vendor org — and guessing is the one
move that cannot be undone cheaply.

=== The rename is Rector's job, not a find-and-replace

The owner named Rector, and it is already wired (`just lint-rector`,
`just format-rector`, `rector.php`). `RenameClassRector` or a namespace-level
rule renames every symbol and every reference to it, including in docblocks
and `@param` annotations, which a textual replace gets wrong.

What Rector does not reach, and has to be done beside it:

- the two `composer.json` autoload maps, and the four autoload-dev prefixes
- `phpstan.neon.dist`, `phpstan-generated.neon`, `phpunit.xml.dist` where they
  name a path or a namespace
- the emitted example trees, which carry the runtime FQCN in every generated
  file — these regenerate rather than being rewritten, which is the check that
  the generator itself was renamed correctly
- `tests/fixtures/generated/*`, the committed golden trees, same regeneration
- `README.md`, `CONTRIBUTING.md`, `AGENT.md`, `examples/*/README.md`
- `truth/`, where the artifacts name the project in prose

Run `just lint-rector`, never a bare `rector` — the shared `sys_get_temp_dir()`
DI cache belongs to whichever worktree wrote it last.

== Acceptance criteria

- The vendor spelling is confirmed by the owner in writing, and the
  confirmation is recorded in this task before any file changes.
- Both `composer.json` files name the new package, and both autoload maps the
  new namespace. `composer dump-autoload` runs clean and `just check` passes.
- No occurrence of the old namespace survives outside history and a changelog
  entry that names it deliberately. `rg 'Mlavrinenko\\\\Paogen'` returns only
  those.
- Every committed golden and example tree regenerates under the new runtime
  namespace, and the diff is exactly the namespace — no other line moves.
  This is the proof the generator's own rename was complete.
- `just verify-runtime-standalone` passes against the renamed runtime.
- `CHANGELOG.md` records the rename as a breaking change with the old and new
  names, so a reader who finds the old one knows where it went.
- The `paogen` binary's own name is decided explicitly — kept, or renamed with
  the package — rather than left to fall out of the diff.

== Non-goals

- Publishing. `publish-the-runtime-package-to-packagist` and the generator's
  own publication own that, and both come after this.
- Renaming the project in prose where it means the tool rather than the
  package. If the tool stays `paogen`, `truth/` keeps saying `paogen`.
- Moving anything between the two packages. This renames; it does not
  re-split.
- The kilbil client's namespace, which belongs to its own repository and its
  own extraction task.

== Files

- `composer.json`, `runtime/composer.json`
- `rector.php`
- `src/`, `runtime/src/`, `tests/`, `bin/`
- `phpstan.neon.dist`, `phpstan-generated.neon`, `phpunit.xml.dist`
- `examples/`, `tests/fixtures/generated/` (regenerated)
- `README.md`, `CONTRIBUTING.md`, `AGENT.md`, `CHANGELOG.md`
