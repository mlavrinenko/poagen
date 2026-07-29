#import "@local/speconaut:0.1.0": *
#import "../domain/guidance.context.typ": *
#import "../domain/generation.context.typ": *

#show: standard.with(
  title: "Consumer guidance is data the generator reads, never code it runs",
  status: accepted(2026, 7, 29),
  contexts: (guidance-context,),
  rule: [
    Everything #a(UserFile) contributes to generation — #a(Profile), #a(BindsFormat),
    the result of #an(AttributeScan) — is read by #the(Generator) as a value and
    never executed as a template, a hook, or a callback that shapes output.
    #The(Generator) may look at what the consumer declared; it may not hand
    control to what the consumer wrote.

    Two consequences follow, and both are the point. Guidance cannot smuggle
    logic into #a(GeneratedFile), so no consumer's cleverness becomes a thing
    the next reader has to reverse-engineer out of the emitted tree. And
    guidance is inert on its own: delete every #a(UserFile) and generation
    still succeeds, producing a client that is less pleasant to use and no
    less correct.
  ],
)
