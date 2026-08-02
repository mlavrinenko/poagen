#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Publish the runtime package to Packagist",
  tags: ("release",),
  priority: 4,
  difficulty: 3,
  status: accepted(2026, 8, 2),
)

== Summary

Every client paogen emits requires `mlavrinenko/paogen-runtime` at run time.
Today that package exists only inside this repository, reached through a
symlinked path repository in each example's `composer.json`, so a generated
client cannot be installed anywhere else.

That is the blocker under extracting the kilbil client to its own repository,
and it is a blocker on the emitted trees being usable by anyone at all. The
generator itself is deliberately not published yet — the owner's ruling on
2026-08-02 is that paogen ships only after its capability is proven — but the
runtime has to go first regardless, because the client depends on it and not on
the generator.

The runtime is already packaged for this: it has its own `composer.json`
naming `mlavrinenko/paogen-runtime`, its own tests, and a standalone
verification recipe that proves it installs and runs without the generator
present.

== Acceptance criteria

- The runtime is published to Packagist under its existing name, at a version
  the changelog explains.
- A clean project, with no clone of this repository, installs it from Packagist
  and runs a generated client against a fake transport.
- The version is tagged in git and the tag is what Packagist resolves.
- The examples switch from the symlinked path repository to the published
  version, or the reason for keeping the path repository during development is
  recorded where the next reader meets it.
- The standalone verification recipe still passes against the published
  package rather than only against the working tree.
- The package declares its own stability honestly. A `0.x` version that says so
  is fine; a `1.0` that means `0.x` is not.

== Non-goals

- Publishing paogen itself. The owner deferred it until the generator's
  capability is proven against the example corpus.
- Any change to what the runtime does. This task packages what exists.
- Automating releases. One published version by hand is the goal; a release
  pipeline is its own task if the cadence ever justifies one.

== Files

- `runtime/composer.json`
- `CHANGELOG.md`
- `examples/*/composer.json`
- `Justfile`
