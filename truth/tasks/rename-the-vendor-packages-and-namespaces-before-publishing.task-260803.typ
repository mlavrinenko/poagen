#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "rename the vendor packages and namespaces before publishing",
  tags: ("release", "naming"),
  priority: 4,
  difficulty: 4,
  status: done(
    2026,
    8,
    5,
  )[Packages are poagen/client-generator and poagen/client-runtime; namespaces Poagen\\Generator and Poagen\\Runtime, siblings rather than nested, because they publish separately. Binary, profile filenames, the hook's env var, prose and every emitted header moved with them. rg paogen returns only truth/tasks, the deliberate CHANGELOG entry, one literal disk path, three task-slug references whose targets are unrenamed filenames, and four session notes quoting the ruling's own before-and-after. Gated on the merged HEAD: 555 tests, unchanged as a rename should be. verify-runtime-standalone passes, after fixing two pre-existing breaks it had accumulated outside the gate - see keep-the-standalone-runtime-check-from-rotting-outside-the-gate.],
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

Asked, and answered on 2026-08-04: `paogen` is a typo and should be replaced
everywhere. The tool follows the vendor. When the rename is finished the only
surviving occurrences of `paogen` should be inside `truth/tasks/`.

So this is one rename over two strings, not a vendor rename with a tool left
behind. Everything moves: the binary, the repository, the PHP namespace
segment, the CLI's own name, prose in `truth/` outside the tasks folder,
`README.md`, `CONTRIBUTING.md`, `AGENT.md`, `AGENT_HAZARDS.md`, the example
profiles' filenames if they carry it, and the emitted trees by regeneration.

`truth/tasks/` is the deliberate exception, and it is worth saying why rather
than treating it as an oversight. A task artifact is a record of what was
decided and when, in the words used at the time. Rewriting `paogen` out of a
task that argued about the spelling would destroy the evidence for the ruling
this section records. History keeps its own spelling; everything a reader
consumes today gets the corrected one. That also gives the rename a clean
verification: after it runs, `rg paogen` outside `truth/tasks/` should return
nothing, which is a mechanical check rather than a judgment call.

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
- The binary, the repository and the prose are renamed with the package. Ruled
  2026-08-04: `paogen` is a typo everywhere it appears.
- `rg paogen` returns matches only under `truth/tasks/`, and nothing else in
  the tree. That is the completion check for this task, and it is mechanical.
- `CHANGELOG.md` names the old spelling deliberately, so a reader who has the
  old package installed can find where it went. That entry is the one place
  outside `truth/tasks/` the old string is allowed to survive; the criterion
  above is read against the tree with it excluded.

== Non-goals

- Publishing. `publish-the-runtime-package-to-packagist` and the generator's
  own publication own that, and both come after this.
- Rewriting `truth/tasks/`. Those artifacts keep the spelling they were
  written in, for the reason given above: they are the record of the decision,
  including the one that changed the spelling.
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
