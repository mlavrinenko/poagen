#import "/templates/page.typ": page
#import "/utils/site.typ": u

#let meta = (
  title: "CLI",
  summary: "generate, validate, dry runs and diffs. The generator reports what it wrote, what it skipped and what it refused.",
)
#metadata(meta) <page-meta>

#show: page.with(..meta)

The binary is `vendor/bin/poagen`.

= generate

```bash
poagen generate path/to/poagen.php
```

Reads the profile, parses the document, and rewrites the output directory.
The output is owned by poagen: files from a previous run that the current
document no longer produces are removed.

#table(
  columns: 2,
  table.header([Flag], [Effect]),
  [`--dry-run`], [`Report what would be written and deleted, write nothing.`],
  [`--diff`], [`Print a unified diff against disk and write nothing.`],
  [`--diff=Generated/Model/**`], [`Scope the diff to a subtree.`],
  [`--color=always`], [`Force colour even when piped.`],
  [`--output=/tmp/out`], [`Override the profile's output directory.`],
)

= validate

```bash
poagen validate path/to/schema.yaml
```

Parses and validates the document without generating. A JSON document is read
as JSON by its `.json` extension; anything else is read as YAML. The same rule
applies to `Profile::$schema`, so a `.json` document generates the same client
its `.yaml` equivalent would.

= The run report

Every run reports:

- files written, updated and deleted;
- constructs it could not represent, each by name;
- format values it did not recognise;
- operations or components left out through `Profile::$skip`, each with the
  reason the profile gave.

A refusal exits non-zero. Nothing is written when the profile or the document
fails validation, so a broken profile cannot leave a half-generated tree.

= Skip or fix

A construct poagen refuses is a decision point, not a warning to scroll past.
Either:

- change the document to the shape poagen can represent, as the diagnostic
  suggests; or
- name the operation or component in `Profile::$skip` and record why.

There is no silent fallback. See #link(u("/status/"))[Status] for the
constructs that stop a run.
