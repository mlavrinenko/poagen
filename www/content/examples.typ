#import "/templates/page.typ": page
#import "/utils/site.typ": REPO, u

#let meta = (
  title: "Examples",
  summary: "Four real documents, regenerated and checked by this repository's own gate.",
)
#metadata(meta) <page-meta>

#show: page.with(..meta)

Each example is a standalone consumer project: its own `composer.json`,
profile, schema, Justfile and committed `generated/` tree. The root gate
regenerates every one and fails on drift.

#table(
  columns: 2,
  table.header([Example], [What it proves]),
  [`petstore`], [`The canonical Swagger Petstore 3.0 document: models, enums, inline classes, security schemes and a small client.`],
  [`kilbil`], [`A real vendor document: 36 operations, inline payloads with no named components, Cyrillic tags, XML request bodies and no machine-splittable operation ids.`],
  [`digitalocean`], [`A 2.7 MB public API bundle with composition-heavy schemas and hundreds of components.`],
  [`github`], [`An 8.8 MB REST bundle with roughly a thousand operations and the widest parameter surface.`],
)

All four generate today and their trees are committed. The example READMEs
explain what each document made poagen handle, and the generated trees are
the shortest path to "what does the output look like on my kind of schema?".

= The kilbil client

The kilbil example is also published as a real consumer package,
#link("https://github.com/maximaster/kilbil-client")[`maximaster/kilbil-client`].
It carries the generated client, the profile, the hand-written value objects
and wrappers, and the recorded-response tests. The example stays in this
repository as the generator's acceptance target.

= Run one

```bash
cd examples/petstore
composer install
composer generate
```

The example's `composer.json` points at the local checkout with a path
repository, so it always generates with the working copy.

See the #link(REPO + "/tree/main/examples")[examples directory] for the
profiles and committed output.
