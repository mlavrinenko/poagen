#import "@local/mindtape:0.2.0": *

#show: task.with(
  title: "Group operations into per-tag sub-clients",
  tags: ("dx",),
  priority: 5,
  difficulty: 7,
  status: proposed(2026, 7, 28),
)

== Summary

Every operation lands as a method on one class. That is tolerable for a small API and unusable for a large one: the GitHub example generates 827 methods on a single type, which no editor, reviewer or reader can navigate. Schemas already carry the grouping in their tags — the kilbil document declares nine, in the vendor's own language — and the generator discards it.

== Acceptance criteria

- Operations are grouped into sub-clients derived from schema tags, reached through accessors on the root client.
- Each sub-client has its own emitted interface, consistent with the client-interface task.
- An operation with no tag, or several tags, has a defined and tested placement.
- Tag names are normalised through the same pipeline as every other identifier, including non-Latin tag names.
- Whether grouping is on by default is settled explicitly; if it is opt-in, the profile carries the switch.
- The GitHub and DigitalOcean example trees regenerate and stay strict-clean.

== Non-goals

- Custom user-defined groupings beyond what tags express; a follow-up if it is ever asked for.
- Changing model emission.

== Files

- \`src/Generator/Emit/ClientEmitter.php\`
- \`src/Generator/Profile.php\`
- \`src/Generator/Naming/SymbolKind.php\`
- \`examples/\`
- \`truth/specs/operation-generator.typ\`
