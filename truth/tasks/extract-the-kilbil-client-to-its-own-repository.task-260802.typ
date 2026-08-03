#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Extract the kilbil client to its own public repository",
  tags: ("release",),
  priority: 4,
  difficulty: 4,
  status: accepted(2026, 8, 2),
  links: (
    depends-on("publish-the-runtime-package-to-packagist.task-260802.typ"),
    depends-on("kilbil-xml-nesting-is-unrepresentable.task-260802.typ"),
  ),
)

== Summary

The kilbil loyalty client lives inside this repository as an example. It is
also the only client paogen has generated against a real vendor's document end
to end, with hand-written wrappers and recorded-response proofs beside it, and
it is meant to be used rather than demonstrated.

Extracting it makes both halves honest. paogen keeps an example it regenerates
on every run; the client becomes a package someone can require, versioned on
the vendor's document rather than on the generator's release cadence.

The owner ruled on 2026-08-02 that the extracted repository is public.

Two things have to be true first: the runtime has to be installable from
Packagist, since the generated code requires it; and the kilbil example has to
be complete, which today it is not — its XML nesting emits a body the vendor
rejects on two of thirty-six operations.

One factual matter for whoever does this, stated rather than decided here: the
vendor's document declares `license: unlicensed` in its own `info` block. The
extracted repository is a derived work of that document, and the owner has
chosen to publish it publicly with that known. Record the provenance in the new
repository's README — which document, which version, retrieved when — so the
position is legible rather than implied.

== Acceptance criteria

- A new public repository holds the generated client, its profile, the vendored
  schema, the hand-written wrappers and the recorded-response tests, with the
  history that produced them or a clean initial commit that says where they
  came from. It is published as `maximaster/kilbil-client` — the owner's
  ruling of 2026-08-03, and the name that satisfies the last criterion below,
  since it names the packager and not the vendor.
- It installs from a clean checkout with `poagen/client-runtime` resolved from
  Packagist, and its tests pass with no reference to this repository.
- Regenerating it from this repository's copy of the document produces the same
  tree, so the extraction did not fork the output.
- paogen keeps a kilbil example that its own gates regenerate and check. What
  the example is for — proving the generator against a real document — does not
  move to the new repository.
- The new repository's README records the vendor document's provenance and its
  declared licence.
- The client is published under a name that does not imply the vendor endorses
  it.

== Non-goals

- Publishing paogen itself.
- Generating clients for the other three examples as packages. Those are
  fixtures, not products.
- Any change to what the client emits. This task moves code; it does not fix
  it. If the kilbil client is not correct yet, this task waits.

== Files

- `examples/kilbil/` (source of the extraction)
- a new repository
- `README.md`, `examples/README.md`
