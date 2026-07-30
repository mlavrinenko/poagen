#import "@local/speconaut:0.1.0": *
#import "../domain/schema.context.typ": *
#import "../domain/generation.context.typ": *

#show: standard.with(
  title: "Every emitted caller surface is an interface and arrives by injection",
  status: accepted(2026, 7, 29),
  contexts: (generation-context,),
  rule: [
    Every #a(Client) paogen emits is declared by an interface it implements, and
    acquires each of its collaborators — the transport, the message factories,
    the base address, the hydration machinery — through its constructor. Nothing
    is resolved from a container, read from global state, or constructed
    internally where a consumer might have wanted to supply it.

    The interface is what consumers type-hint against, which is what makes the
    architecture work: hand-written convenience implements the same contract and
    delegates to the generated implementation, so consumer code and emitted code
    meet at something the compiler checks. Without it, the only place to add a
    retry or a paginated iterator is inside #a(GeneratedFile), and total
    regeneration would destroy it.

    Emitted surfaces are also grained to be worth injecting. A caller that needs
    three endpoints depends on a type declaring roughly those three, not on one
    object exposing every operation in #the(Schema) — otherwise a unit test has
    to stand in for a surface it never calls.
  ],
  structural: "enforced by ClientConstructor.php, which is the sole constructor
    for the root client and every sub-client and routes every collaborator —
    the transport and any credential the schema declares — through a promoted
    parameter type-hinted against TransportInterface rather than a concrete
    class; and by SubClientEmitter.php, which emits a matching interface with
    no constructor member for each client, so a hand-written decorator
    satisfies the same contract by implementing the interface rather than by
    extending or reaching into the class. No emitter resolves a collaborator
    from a container or global state.",
)
