#import "@local/speconaut:0.1.0": *
#import "../domain/schema.context.typ": *
#import "../domain/generation.context.typ": *

#show: standard.with(
  title: "Every emitted caller surface is an interface and arrives by injection",
  status: accepted(2026, 7, 29),
  contexts: (generation-context,),
  requires-cases: (
    "sub-client-interface-omits-constructor",
    "sub-client-injects-transport-not-root",
  ),
  rule: [
    Every #a(Client) poagen emits is declared by an interface it implements, and
    acquires its transport — and whatever credential #the(Schema) declares —
    through its constructor, type-hinted against `TransportInterface` rather
    than a concrete class. The message factories, the base address, and the
    hydration machinery are not parameters of #the(Client) at all; they live one
    level down, inside whatever implements `TransportInterface`. Nothing is
    resolved from a container, read from global state, or constructed
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
  structural: "enforced by the single emission path that constructs every
    root and sub-client, which routes every collaborator — the transport and
    any credential the schema declares — through a promoted constructor
    parameter type-hinted against TransportInterface rather than a concrete
    class; and by the emission path for each sub-client's interface, which
    declares no constructor member, so a hand-written decorator satisfies the
    same contract by implementing the interface rather than by extending or
    reaching into the class. No emitter resolves a collaborator from a
    container or global state.",
)
