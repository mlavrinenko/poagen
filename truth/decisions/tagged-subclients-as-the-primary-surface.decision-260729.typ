#import "@local/speconaut:0.1.0": *
#import "../domain/generation.context.typ": *

#show: decision.with(
  title: "Tagged sub-clients are the primary generated surface",
  status: accepted(2026, 7, 29),
  contexts: (generation-context,),
  goals: (link("../goals/typed-injectable-surface.goal.typ"),),
  standards: (link("../standards/caller-surface-is-injectable.standard-260729.typ"),),
)

== Context

Today #the(Generator) emits one final #a(Client) class carrying every
operation in the document and implementing no interface. Against the
kilbil schema that is a 36-method type with no declared contract.

Two problems, one fix. There is nothing to implement or decorate, so
hand-written convenience has no seam to attach to and the only way in is
editing generated code. And a flat client is the wrong injection unit: a
service touching three endpoints must accept an object exposing all
thirty-six, and a unit test must fake a surface it never calls.

Options weighed:

- Keep the flat client and add one interface over it.
- Emit both flat methods and tagged sub-clients.
- Emit tagged sub-clients only.

== Choice

Tagged sub-clients only, each behind its own emitted interface.
#The([root], Client) becomes a composition root exposing one accessor
per tag, plus any operations the document left untagged, and carries no
flat operation methods — exactly one way to reach any endpoint.

Sub-clients are separately constructible from the transport and
factories, so they are injectable and fakeable on their own without
#the([root], Client) existing.

An operation carrying several tags is emitted on every one of its
sub-clients, because the schema author's tagging is intent and silently
picking one discards it. The profile can override that choice per
operation, and can assign a tag to an untagged operation so a consumer
repairs an under-tagged vendor document without editing the schema.

== Consequences

- #The([root], Client) is a thin composition root; every operation-level
  method lives on a tagged sub-client instead.
- Each sub-client and its interface is #a(GeneratedFile) like any other
  — regenerating a document whose tags did not change produces no diff.
- A consumer touching three endpoints depends on a type declaring
  roughly those three, not on one object exposing every operation in the
  schema, so a unit test only fakes the surface it actually calls.
- Hand-written convenience — a decorator, a retry wrapper, a richer
  return type — implements the same emitted interface a sub-client
  implements and delegates to it, giving it a seam to attach to that the
  flat client never had.
