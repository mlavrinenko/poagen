#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "rename the vendor packages and namespaces before publishing",
  tags: ("release", "naming"),
  priority: 4,
  difficulty: 4,
  status: accepted(
    2026,
    8,
    3,
  )[The one open string is confirmed. The owner ruled the vendor is `poagen`, and gave the reason: it is the initialism of PHP OpenAPI Generator. Nothing else blocked this task.],
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

=== The one open string, confirmed 2026-08-03

Asked as a straight choice — `poagen` or `paogen` — and answered `poagen`, with
the reason: it is the initialism of PHP OpenAPI Generator, taking `p`, `oa` and
`gen` in that order. So the vendor is `poagen` and it is not a transposition of
the repository's spelling. It is the intended name.

That answer carries further than the string it settles, and the last acceptance
criterion is where it lands. If `poagen` is what the initialism spells, then
`paogen` — the repository, the binary, the namespace segment, every artifact in
`truth/` — is the transposed one. Shipping `poagen/client-generator` whose
binary is `paogen` and whose namespace is `Paogen\` leaves two spellings of one
name differing by a swap, in a project whose whole argument is that a declared
shape is not silently altered.

The owner has not ruled on the tool's own name and this task must not guess it.
Put the question to them before the rename runs, as a second one-word answer:
does the binary, the repository and the prose follow the vendor to `poagen`, or
does the tool stay `paogen` deliberately? Either is defensible — a vendor org
distinct from the tool it publishes is a normal shape — but it has to be chosen,
not fall out of a diff. The rename is cheapest to run once, over both strings at
the same time, which is the practical reason to ask before starting rather than
after.

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
  confirmation is recorded in this task before any file changes. Done:
  `poagen`, 2026-08-03, recorded above with the owner's reasoning.
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
  the package — rather than left to fall out of the diff. This now needs a
  second one-word answer from the owner, because their reason for `poagen`
  makes `paogen` the transposition rather than the other way round. Get it
  before the rename runs; running Rector twice over the same symbols is the
  avoidable cost.

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
