#import "@local/speconaut:0.1.0": *
#import "../domain/generation.context.typ": *
#import "../domain/schema.context.typ": *

#show: decision.with(
  title: "Operation bodies delegate to an injected runtime transport",
  status: accepted(2026, 7, 30),
  contexts: (generation-context,),
  goals: (
    link("../goals/typed-injectable-surface.goal.typ"),
    link("../goals/never-edit-generated.goal.typ"),
  ),
  standards: (
    link("../standards/caller-surface-is-injectable.standard-260729.typ"),
    link("../standards/generated-types-are-total.standard-260729.typ"),
  ),
)

== Context

Every operation #the(Generator) emits writes the whole request-and-response
sequence into #a(GeneratedFile): interpolate the path, assemble the query
string, build the request, attach the body, send it, branch on the status,
decode, hydrate. None of that varies with #the(Schema) beyond a path, a verb
and a type name, so each operation restates it and each reader meets it again.

Measured rather than asserted. Against the kilbil document the emitted tree
runs 30.69% duplicated lines; one 117-line sub-client holds four blocks that
are identical token for token apart from a path literal and a class name.
Twelve #a(Client) classes take the same seven constructor parameters, which is
a second family of the same problem.

Options weighed:

- Leave it. Nobody edits #a(GeneratedFile), so repetition there costs no
  maintenance.
- Deduplicate inside the emitted tree, with a shared base class or a trait each
  #a(Client) pulls in.
- Move the invariant half out of the tree, behind a collaborator #a(Client)
  receives through its constructor.

== Choice

The third. An emitted operation becomes a single call describing the request
and naming the response type; assembling, sending and decoding belong to the
runtime.

The second option is rejected on a settled question rather than on taste. A
generated base class reintroduces inheritance into the emitted tree, which the
decision on inheritance and protected regions already ruled out — a consumer
must not be able to reach generated behaviour by extending it, because total
regeneration would then destroy their subclass.

The first option is rejected because the cost is not maintenance. It is that a
consumer reading a client to understand what it will send has to read the same
fifteen lines thirty-six times to discover they were the same fifteen lines.

== Consequences

- #A(Client) shrinks to what the document actually says: a verb, a path, the
  parameters, the response type. The repeated sequence appears once, in the
  runtime, where it can be read once.
- The constructor collapses with it. #A(Client) receives one transport plus
  whatever credentials #the(Schema) declares, instead of restating the message
  factories, the base address and the hydration machinery.
- This narrows what the standard on total generated types covers. Behaviour
  that was visible in #a(GeneratedFile), and analysed there at maximum
  strictness with nothing ignored, moves into a library. That is a real loss of
  locality and it is the price of this decision. The hydration machinery
  already sat on the far side of that line, so the boundary moves rather than
  appears.
- The transport therefore has to be replaceable and not merely injected. An
  interface a consumer can implement keeps the injectable-surface standard
  honest at the new boundary; a concrete class named in a constructor default
  would quietly make the runtime unswappable exactly where the most behaviour
  now lives.
- Duplication in the emitted tree becomes measurable progress rather than an
  impression, because the instrument landed first and the before figure is
  recorded.
