#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Name inline schemas by operation and status, and merge them only on request",
  tags: ("generator", "dx", "guidance"),
  priority: 7,
  difficulty: 5,
  status: done(2026, 8, 4),
)

== Summary

A document may write every payload inline, with no `components:` section at
all — kilbil does exactly that, which is why its client carries 107 classes
whose names paogen derived rather than read. The derivation today produces one
name per operation and direction: `AddClientRequest`, `AddClientResponse`.

That stops working the moment an operation has more than one response worth
typing, which the status-and-body envelope makes universal. kilbil declares a
200 and a 403 on all 36 operations; both need a class and `AddClientResponse`
can only name one of them.

So the derivation gains the status: `{OperationId}{StatusCode}Content`. And the
36 identical 403 bodies raise a second question — one class or 36? — settled by
the owner as: 36, unless a human says otherwise. Structural identity is not
identity of meaning. Two endpoints that both return `{id, name}` may be
returning a tag and a user, and collapsing them because their fields line up
invents a domain relationship the document never stated.

What paogen owes the consumer instead is the observation, and a good way to act
on it.

== Acceptance criteria

- An inline response schema is named `{OperationId}{StatusCode}Content`, with
  the status as the document writes it — including a `default` key and range
  keys such as `4XX`, spelled so they are legal PHP identifiers.
- An inline request body is named on the same pattern, with the direction where
  the status would go, so the two rules read as one rule.
- Nothing merges on its own. Thirty-six identical bodies produce thirty-six
  classes until a profile entry says otherwise.
- The profile expresses a merge as one class name to many sites, so the
  grouping reads in the direction the consumer thinks in — one entry per class
  they want, not one per site they have:

  ```php
  inlineModels: [
      'KilbilError' => ('addclient.403', 'blockcard.403', 'getclient.403'),
      'AddClientRequest' => 'addclient.request',
  ],
  ```

- A merge whose sites do not all emit the identical shape fails the run, naming
  the two sites that differ and the property they differ on. A consumer cannot
  merge two classes into one and silently lose a field.
- A site named in a merge that is absent from the document fails the run, as
  every other profile entry already does when it goes stale.
- The run reports each group of structurally identical inline schemas on the
  notice channel — the one `report-unrecognised-formats` established, stderr,
  never moving the exit status — and prints the exact profile block that would
  merge them, ready to paste. One line per group, not per site.
- The four examples regenerate under the new naming, and the rename is recorded
  as an intended change to byte-stable output rather than a surprise in a diff.

== Non-goals

- Merging by structural equality, automatically or as a default. The owner
  ruled it manual and the reasoning is above.
- Renaming schemas the document did name. A component keeps its own name; this
  is only about the ones with none.
- The existing rename and normalisation surfaces, which keep their meaning.

== Files

- `src/Generator/Emit/InlinePayloadPlanner.php`
- `src/Generator/Naming/`
- `src/Generator/Profile.php`
- `src/Generator/ProfileTargetValidator.php`
- `examples/`
- `tests/`
